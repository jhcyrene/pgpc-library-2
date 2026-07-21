Related documentation:

- [Main Technical Guide](PROJECT_TECHNICAL_GUIDE.md)
- [Project File Map](PROJECT_FILE_MAP.md)
- [Project Logic Flow](PROJECT_LOGIC_FLOW.md)
- [Troubleshooting Guide](PROJECT_TROUBLESHOOTING_GUIDE.md)
- [Command Reference](PROJECT_COMMAND_REFERENCE.md)

# Project Command Reference

This is your cheat sheet for all terminal commands used in the PGPC ILMS project.

## Safe Commands (Run these anytime)

| Goal | Command | Purpose & When to use | Expected Result | Safety Warning |
| ---- | ------- | --------------------- | --------------- | -------------- |
| **Start Laravel** | `php artisan serve` | Starts the local PHP server. Run this every time you sit down to code. | `Server running on [http://127.0.0.1:8000]` | **SAFE** |
| **Start Vite** | `npm run dev` | Compiles Tailwind CSS and Javascript in real-time. Run this alongside `artisan serve`. | `vite building for development...` | **SAFE** |
| **Clear Caches** | `php artisan optimize:clear` | Wipes out cached views, routes, and configs. Run this if your code changes aren't showing up. | `Caches cleared successfully.` | **SAFE**. (This does *not* delete database data). |
| **List Routes** | `php artisan route:list` | Shows every valid URL in the application. Run this when you get a "Route not defined" error. | A table listing GET/POST methods and Route Names. | **SAFE** |
| **Check Migrations** | `php artisan migrate:status` | Shows which database tables have been created. Run this to verify your SQLite database is working. | A list of migrations with a `[Ran]` or `[Pending]` status. | **SAFE** |
| **Run Tests** | `php artisan test` | Runs automated tests to ensure nothing is broken. Run this before committing code. | `PASS  Tests\Feature\ExampleTest` | **SAFE** |
| **Build Assets** | `npm run build` | Compiles and minifies CSS/JS for production. Run this right before you upload the project to the live server. | `✓ built in 1.2s` | **SAFE** |
| **Refresh Autoload** | `composer dump-autoload` | Tells composer to rescan the project folders. Run this if you get a "Class not found" error after creating a new file. | `Generating optimized autoload files` | **SAFE** |
| **Inspect Version** | `php artisan about` | Shows Laravel, PHP, and connection info. | Environment details. | **SAFE** |

## Database Modifying Commands (Use with care)

| Goal | Command | Purpose & When to use | Common Error | Safety Warning |
| ---- | ------- | --------------------- | ------------ | -------------- |
| **Run Migration** | `php artisan migrate` | Creates new database tables based on scripts in `database/migrations/`. Run this after downloading new code or creating a migration. | `Table already exists` | **SAFE-ISH**. It only adds new tables, but cannot easily be undone if the migration is broken. |
| **Seed Database** | `php artisan db:seed` | Inserts dummy data into the database. | `Class does not exist` | **SAFE-ISH**. Might create duplicate data if run multiple times without wiping first. |

## Destructive Commands (DANGER)

> [!CAUTION]
> **NEVER run these commands on the live production server.**

| Goal | Command | Purpose & When to use | Safety Warning |
| ---- | ------- | --------------------- | -------------- |
| **Wipe & Rebuild** | `php artisan migrate:fresh` | Drops ALL tables and recreates them from scratch. Use this when your database is completely messed up during local development. | **DANGER.** This deletes ALL your local books, users, and borrows permanently. |
| **Wipe, Rebuild & Seed** | `php artisan migrate:fresh --seed` | Wipes the database and immediately inserts the dummy data. | **DANGER.** Destroys all current data. |
| **Reset Migrations** | `php artisan migrate:reset` | Rolls back all migrations. | **DANGER.** Deletes all tables. |
| **Wipe DB** | `php artisan db:wipe` | Drops all tables without running migrations again. | **DANGER.** |

## Safe Development Practices with SQLite

Because this project uses SQLite, the entire database is stored in a single file: `database/database.sqlite`.

1. **Backups are easy:** If you are about to test a dangerous feature, just copy/paste the `database.sqlite` file somewhere else. If you break it, delete the broken one and paste your backup back in.
2. **Do not commit it:** Ensure `database.sqlite` is in your `.gitignore` file. You do not want to upload your local dummy data (or real student data) to GitHub.
3. **Database locked error:** If you get a `database is locked` error, it means two things are trying to write to SQLite at the exact same millisecond. Usually, just refreshing the page fixes it. If it persists, restart `php artisan serve`.
