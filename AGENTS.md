# AGENTS.md

UITS Research Archive — Laravel 12 (PHP ^8.2) + MySQL. Research paper / capstone / thesis submission portal for UITS. All project docs live in `docs/` (README.md, changelog.md, guideline-cpanle.md, vercel-guideline.md).

## Commands

- `composer setup` — full bootstrap: install deps, copy `.env`, generate key, migrate, npm install + build.
- `composer dev` — concurrently runs `php artisan serve`, queue worker, `php artisan pail` (logs), and Vite. This is the expected local dev loop.
- `composer test` — `config:clear` then `php artisan test`. Tests are only Breeze defaults (tests/Feature/Auth, ProfileTest); no feature tests exist for submissions/admin yet — don't assume coverage.
- `php artisan migrate --seed` — needed after fresh clone; seeder creates 15 departments, 27 domains, and 3 users (all password `password`): `admin@uits.edu.bd` (role admin), `student@uits.edu.bd`, `faculty@uits.edu.bd`.
- `npm run build` — Vite build (input: `resources/css/app.css`, `resources/js/app.js`).

## Environment / DB gotchas

- Committed local `.env` uses **MySQL** (`uits_archive`, root/toor, APP_ENV=prod, APP_DEBUG=true). `.env.example` defaults to **sqlite**. Tests use in-memory sqlite via phpunit.xml.
- `database.sql` is a phpMyAdmin import snapshot used only for the no-SSH cPanel path (docs/guideline-cpanle.md). Keep it in sync with migrations when the schema changes, or the import path deploys a stale schema.
- No file uploads: submissions store `pdf_url`, `external_links`, `drive_links` as plain URL strings (validation `nullable|url`). Local `storage` symlink is not needed for app functionality.

## Architecture

- `routes/web.php` is the single source of routing: public (`/`, `/archive`, `/search`), Breeze auth (`routes/auth.php`), auth'd submissions CRUD, and `admin.*` routes under `prefix('admin')`.
- Admin gate: `admin` middleware alias registered in `bootstrap/app.php` → `app/Http/Middleware/AdminMiddleware.php` (non-admin gets 403). Adding a route for admins requires both the `admin` middleware AND a route inside the admin group.
- `Submission` model (app/Models/Submission.php): status scopes `approved/pending/rejected`; `research_domains`, `authors`, `external_links`, `drive_links` are JSON-cast arrays — pass PHP arrays, store as JSON columns.
- Frontend: views use **Bootstrap 5 + Bootstrap Icons from CDN** (`resources/views/welcome.blade.php` header). Do NOT add Tailwind classes — `tailwind.config.js` and the `@tailwind` directives in `resources/css/app.css` are vestigial.
- README features list is currently more aspirational than accurate; verify against controllers before editing it.

## Deployment docs (stale — verify before trusting)

- `docs/vercel-guideline.md` describes `api/index.php` and `VercelServiceProvider`, but **neither exists in the repo**; `vercel.json` also builds via `@vercel/static-build` (distDir `public`) which the doc omits. Vercel deploy is currently broken as described.
- `docs/guideline-cpanle.md` mixes two directory names (`uits-archive` vs `uits-research-archive` in the index.php path replacements). Use the actual folder name at deploy time.
- File is intentionally misspelled `guideline-cpanle.md` — don't "fix" it without updating references.

## Git

- Single branch `main`, remote `main` → `https://github.com/4xrhd/uits-research-archive`.
- `docs/changelog.md` records dated entries per milestone; update it (and README when features change) on completion of work.
