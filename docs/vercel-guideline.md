# Deploying UITS Research Archive on Vercel

Vercel is primarily designed for static sites and serverless functions (like Next.js or Nuxt), but it is possible to deploy a PHP/Laravel application using the `vercel-php` runtime.

**Important Note for Laravel on Vercel:**
Vercel's Serverless Functions have an **ephemeral file system**. This means any files uploaded by users (like PDFs or images) to the local `/storage` directory will be **lost** when the function goes to sleep. To properly run this archive on Vercel, you *must* use an external storage service like AWS S3 or a cloud database for file storage, rather than the local filesystem. You will also need an external MySQL database (like PlanetScale, Supabase, or Railway).

Here is the step-by-step guide to deploying your Laravel app on Vercel.

---

## Step 1: Install Vercel CLI (Optional but Recommended)

It's easier to test and configure Vercel locally using their CLI.
```bash
npm i -g vercel
```

## Step 2: Create the `vercel.json` Configuration File

In the root of your Laravel project (where `composer.json` is), create a new file named `vercel.json` and add the following configuration:

```json
{
    "version": 2,
    "builds": [
        {
            "src": "api/index.php",
            "use": "vercel-php@0.6.0"
        },
        {
            "src": "public/**",
            "use": "@vercel/static"
        }
    ],
    "routes": [
        {
            "src": "/build/(.*)",
            "dest": "/public/build/$1"
        },
        {
            "src": "/(.*)",
            "dest": "/api/index.php"
        }
    ],
    "env": {
        "APP_ENV": "production",
        "APP_DEBUG": "false",
        "LOG_CHANNEL": "stderr",
        "VIEW_COMPILED_PATH": "/tmp",
        "CACHE_DRIVER": "array",
        "SESSION_DRIVER": "cookie",
        "QUEUE_CONNECTION": "sync"
    }
}
```

### Explanation:
*   **`vercel-php`**: This is a community runtime that executes PHP on Vercel's serverless infrastructure.
*   **`public/**`**: We serve CSS, JS, and images as static files.
*   **`VIEW_COMPILED_PATH`**: Vercel's filesystem is read-only except for `/tmp`. Blade views need to be compiled there.
*   **`LOG_CHANNEL`**: Logs must go to `stderr` because we cannot write to the `storage/logs` directory.
*   **`SESSION_DRIVER`**: We change this to `cookie` (or `database`) because the default `file` driver will not persist data across serverless executions.

## Step 3: Create the Serverless Entry Point

Vercel needs a specific entry point to process requests.
1. Create a new folder named `api` in the root of your project.
2. Inside `api`, create a file named `index.php`.
3. Add the following code to `api/index.php`:

```php
<?php

/**
 * Vercel Serverless Entry Point for Laravel
 */

require __DIR__ . '/../public/index.php';
```

## Step 4: Fix Artisan Commands (Directory Creation)

Because `/storage` and `/bootstrap/cache` are read-only on Vercel, Laravel will crash if it tries to create directories there. We need to create a custom Service Provider to handle this.

1. Create a new file `app/Providers/VercelServiceProvider.php`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Use /tmp for compiled views on Vercel
        if (isset($_ENV['VERCEL'])) {
            config(['view.compiled' => '/tmp/views']);
        }
    }

    public function boot()
    {
        // Ensure the /tmp/views folder exists
        if (isset($_ENV['VERCEL']) && !is_dir('/tmp/views')) {
            mkdir('/tmp/views', 0777, true);
        }
    }
}
```

2. Register this provider in your `config/app.php` arrays under `providers`:
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    // ...
    App\Providers\VercelServiceProvider::class,
])->toArray(),
```

## Step 5: External Database & Storage Setup

Before deploying, you must set these up:
1.  **Database**: Create a MySQL database on a platform like [Railway.app](https://railway.app), [Supabase](https://supabase.com/database) or [PlanetScale](https://planetscale.com) (if they support typical MySQL). Get the Host, Port, Username, and Password.
2.  **Storage**: For PDF uploads, you need AWS S3 or a similar S3-compatible service (like Cloudflare R2 or DigitalOcean Spaces). You would configure this in `config/filesystems.php` and set up the corresponding env variables.

## Step 6: Deploy to Vercel via GitHub

The easiest way to deploy is through Vercel's GitHub integration.

1.  Push your code to a GitHub repository.
2.  Go to your [Vercel Dashboard](https://vercel.com/dashboard) and click **"Add New Project"**.
3.  Import your GitHub repository.
4.  Expand the **"Environment Variables"** section.
5.  Add all the necessary production environment variables. Make sure your database variables point to your *external* database.

    **Crucial Variables to Add:**
    *   `APP_KEY`: Output of `php artisan key:generate --show`
    *   `APP_URL`: Your final Vercel domain
    *   `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
    *   `APP_ENV`: `production`
    *   `APP_DEBUG`: `false`

6.  Click **"Deploy"**.

## Step 7: Run Database Migrations

Since Vercel is serverless, you cannot easily SSH into it to run migrations. You have two options:

**Option A: Run remotely from your local machine**
Update your **local** `.env` to briefly point to your *production* external database, then run:
```bash
php artisan migrate --force
```
*(Remember to change it back to your local database afterwards!)*

**Option B: Create a Route for Migrations (Not entirely secure, use caution)**
Add a temporary route in `routes/web.php` to run the migration:
```php
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations ran successfully.';
});
```
Visit the Vercel URL `your-app.vercel.app/run-migrations` once, then immediately remove this code and push an update to Vercel.

---

### Final Considerations
*   Uploading large PDFs directly to a Vercel function might hit their 4.5MB payload size limit. For large file uploads, you should look into Direct to S3 Uploads (Presigned URLs) returning the file path back to your Laravel controller.
