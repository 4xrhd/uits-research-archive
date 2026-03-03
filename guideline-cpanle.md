# Deploying UITS Research Archive on cPanel (Shared Hosting)

This guide provides step-by-step instructions on how to deploy your Laravel application (UITS Research Archive) on a standard cPanel shared hosting environment that only supports PHP.

## Prerequisites

Before you begin, ensure you have the following:

1.  **cPanel Access:** Username, password, and the login URL for your hosting account.
2.  **PHP Version:** Ensure your hosting environment is running **PHP 8.2 or higher**. You can usually check and change this in cPanel under "Select PHP Version" or "MultiPHP Manager".
3.  **Database Access:** Ability to create MySQL databases and users in cPanel.
4.  **Local Project Files:** A zipped version of your entire Laravel project (excluding the `vendor` and `node_modules` folders to save upload time, though you can include `vendor` if you can't run Composer on the server).

---

## Step 1: Prepare the Project Locally

Before uploading, you need to prepare your project.

1.  **Clear Caches:** Open your local terminal/command prompt in your project directory and run:
    ```bash
    php artisan optimize:clear
    ```
2.  **Zip the Project:**
    *   Compress all the files and folders inside your `uits-research-archive` directory into a single zip file (e.g., `archive-site.zip`).
    *   *Note: If your shared hosting does not have SSH/Composer access, you **must** include the `vendor` directory in your zip file.*

---

## Step 2: Set Up the Database in cPanel

1.  Log in to your cPanel dashboard.
2.  Find the **Databases** section and click on **MySQL® Databases**.
3.  **Create a New Database:** Enter a name (e.g., `uits_archive`) and click "Create Database". Note the full database name (usually prefixed with your cPanel username, like `cpaneluser_uits_archive`).
4.  **Create a New User:** Scroll down to "MySQL Users - Add New User". Enter a username and a strong password. Note these down.
5.  **Add User to Database:** Scroll down to "Add User To Database". Select the user and database you just created, click "Add", and grant **ALL PRIVILEGES**.

---

## Step 3: Upload Files to the Server

In a standard cPanel setup, the public-facing directory is `public_html`. However, for security, Laravel's core files should reside *outside* or *above* `public_html`.

### The Recommended Directory Structure:

```
/home/cpanelusername/
│
├── uits-archive/        <-- Your Laravel project goes here (app, config, routes, etc.)
│
└── public_html/         <-- Only the contents of Laravel's 'public' folder go here
```

### Instructions:

1.  In cPanel, go to **File Manager**.
2.  **Upload the Core Files:**
    *   Navigate to your home directory (`/home/yourusername/`). Do *not* go into `public_html` yet.
    *   Create a new folder named `uits-archive`.
    *   Go into the `uits-archive` folder and click **Upload** to upload your `archive-site.zip` file.
    *   Once uploaded, select the zip file and click **Extract**.
3.  **Move the Public Files:**
    *   Still inside `uits-archive`, go into the extracted `public` folder.
    *   Select ALL files and folders inside `public` (including `.htaccess` and `index.php`).
    *   Click **Move** and change the destination path to `/public_html/` (or your subdomain directory if you are using one).

---

## Step 4: Configure the Paths

Since we moved the `public` files away from the core Laravel files, we need to tell `index.php` where to find them.

1.  In cPanel File Manager, navigate to `public_html`.
2.  Find `index.php` and click **Edit**.
3.  Update the paths to point to your `uits-archive` folder. Change these lines:

    **Find:**
    ```php
    require __DIR__.'/../vendor/autoload.php';
    ```
    **Replace with:**
    ```php
    require __DIR__.'/../uits-archive/vendor/autoload.php';
    ```

    **Find:**
    ```php
    $app = require_once __DIR__.'/../bootstrap/app.php';
    ```
    **Replace with:**
    ```php
    $app = require_once __DIR__.'/../uits-archive/bootstrap/app.php';
    ```
4.  Save the changes.

---

## Step 5: Configure the Environment (.env)

1.  In File Manager, navigate back to your `uits-archive` folder.
2.  Find the `.env` file (you may need to enable "Show Hidden Files" in File Manager settings). If there is only a `.env.example` file, copy it and rename the copy to `.env`.
3.  Click **Edit** on the `.env` file.
4.  Update the following settings:

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://yourdomain.com  # Enter your actual domain name

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_cpanel_database_name
    DB_USERNAME=your_cpanel_database_username
    DB_PASSWORD=your_cpanel_database_password
    ```
5.  Save the changes.

---

## Step 6: Install Dependencies and Migrate (If you have SSH Terminal access)

If your cPanel provides a "Terminal" app:

1.  Open the **Terminal** in cPanel.
2.  Navigate to your project directory:
    ```bash
    cd ~/uits-archive
    ```
3.  If you did not upload the `vendor` folder, run:
    ```bash
    composer install --optimize-autoloader --no-dev
    ```
4.  Run the database migrations to create the tables:
    ```bash
    php artisan migrate --force
    ```
    *(Note: Using `--force` is required when `APP_ENV=production`)*
5.  Create the storage link (crucial for uploaded files like PDFs):
    ```bash
    php artisan storage:link
    ```
   *Note: Because you separated the `public_html` folder from the core files, `php artisan storage:link` might put the symlink inside `uits-archive/public/storage`. You will need to manually create a symlink in `public_html` pointing to `uits-archive/storage/app/public` instead, or move the generated symlink.*

   To fix the symlink via cPanel Terminal, run this command from inside `public_html`:
   ```bash
   ln -s /home/yourcpanelusername/uits-archive/storage/app/public storage
   ```

### Alternatively: If you DON'T have SSH Terminal Access

1.  **Dependencies:** Ensure you uploaded the `vendor` folder when you zipped the project in Step 1.
2.  **Database export/import:** Instead of running migrations, export your local database using phpMyAdmin. Then, go to cPanel -> phpMyAdmin, select your newly created remote database, and import the SQL file.
3.  **Storage Link:** You can create a route in your `routes/web.php` temporarily to run the artisan command:
    ```php
    Route::get('/create-symlink', function () {
        $targetFolder = base_path().'/storage/app/public';
        $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
        symlink($targetFolder, $linkFolder);
        return 'Symlink process successfully completed';
    });
    ```
    Visit `yourdomain.com/create-symlink` in your browser once, then remove the route for security.

---

## Step 7: Final Optimization

Once everything is uploaded and the database is connected, it is highly recommended to cache your configuration and routes for better performance.

If you have Terminal access, run:
```bash
cd ~/uits-archive
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Troubleshooting:**
*   **500 Internal Server Error:** This is almost always a file permission issue or a wrong path in `index.php`. Ensure folders are `755` and files are `644`. Double-check the paths in Step 4. Check the `uits-archive/storage/logs/laravel.log` file for specific error messages.
*   **Images/PDFs not loading:** Ensure the symlink for the storage folder was created correctly in Step 6.

Your UITS Research Archive should now be live on your cPanel server!
