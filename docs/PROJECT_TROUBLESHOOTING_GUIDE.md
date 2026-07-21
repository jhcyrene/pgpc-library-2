Related documentation:

- [Main Technical Guide](PROJECT_TECHNICAL_GUIDE.md)
- [Project File Map](PROJECT_FILE_MAP.md)
- [Project Logic Flow](PROJECT_LOGIC_FLOW.md)
- [Troubleshooting Guide](PROJECT_TROUBLESHOOTING_GUIDE.md)
- [Command Reference](PROJECT_COMMAND_REFERENCE.md)

# Project Troubleshooting Guide

When something breaks, do not panic. Read the error message, check the logs, and refer to this guide to find out exactly how to fix it.

## 1. How to Read Laravel Logs

Before guessing what went wrong, check the log file:
`storage/logs/laravel.log`

- Scroll to the **very bottom** of the file.
- Look for the line that starts with `[YYYY-MM-DD HH:MM:SS] local.ERROR:`.
- The first few lines of the stack trace below it will tell you exactly which file and line number caused the crash.

---

## 2. Server & Build Issues

### Laravel does not start
**Symptom:** You run `php artisan serve` and get an error, or the page says "No connection could be made."
**Fix:**
- Check if your `.env` file exists. If not, copy `.env.example` to `.env` and run `php artisan key:generate`.
- Make sure another application (like XAMPP or another Laravel project) isn't already using port 8000.

### Vite build error / CSS not updating
**Symptom:** You made changes to a Blade file or Tailwind class, but the browser isn't updating. Or you get a "Vite manifest not found" error on load.
**Fix:**
- You must run Vite! Run `npm run dev` in a separate terminal and leave it open.
- If deploying, run `npm run build`.
- If the browser still isn't updating, do a hard refresh (`Ctrl + F5` or `Cmd + Shift + R`).

### Cache issues
**Symptom:** You changed a config file or a route, but Laravel acts like you didn't.
**Fix:**
- Run `php artisan optimize:clear` to wipe all Laravel caches.

---

## 3. Database Issues

### Database table missing
**Symptom:** `SQLSTATE[HY000]: General error: 1 no such table: books`
**Fix:**
- You forgot to run your migrations. Run `php artisan migrate`.
- If you are on a new computer, make sure the `database/database.sqlite` file actually exists.

### Foreign-key error
**Symptom:** `Integrity constraint violation: foreign key constraint failed`
**Fix:**
- You are trying to delete a record that is still being used by another table. For example, deleting a physical copy (`books`) that currently has an active checkout (`book_borrows`).
- You must either delete the borrowing record first, or change the database logic to prevent deletion (e.g., using Soft Deletes).

### Seeder failing
**Symptom:** `ReflectionException: Class Database\Seeders\BookSeeder does not exist`
**Fix:**
- You recently created or deleted a seeder file, and composer hasn't recognized it yet.
- Run `composer dump-autoload` and try again.

---

## 4. Code & Routing Issues

### Route not found
**Symptom:** `Route [admin.books.edit] not defined.`
**Fix:**
- You typed `route('admin.books.edit')` in a Blade file, but that name does not exist.
- Run `php artisan route:list` to see all valid route names.
- Ensure the route is defined in `routes/web.php` and the name matches perfectly.

### Controller not found
**Symptom:** `Target class [App\Http\Controllers\BookController] does not exist.`
**Fix:**
- Check your `web.php` file. You probably forgot to import the controller at the top: `use App\Http\Controllers\BookController;`.
- Check the spelling of the controller filename.

### Model not found
**Symptom:** `Class "App\Models\Book" not found`
**Fix:**
- You forgot to import the model at the top of your controller: `use App\Models\Book;`.

### View not found
**Symptom:** `View [admin.books.index] not found.`
**Fix:**
- Laravel is looking for `resources/views/admin/books/index.blade.php`, but it isn't there.
- Check for spelling mistakes. `admin/book/index` is different from `admin/books/index`.

### Blade component not found
**Symptom:** `Unable to locate a class or view for component [button].`
**Fix:**
- You typed `<x-button>` in your HTML, but `resources/views/components/button.blade.php` does not exist.
- Ensure the component file exists and is named correctly.

---

## 5. Form & Input Issues

### Validation error
**Symptom:** The user submits a form, but it just reloads the page and does nothing.
**Fix:**
- The form failed validation (e.g., in `StoreBookDataRequest`).
- You forgot to display the error messages in the Blade view. Add this under your inputs: 
  `@error('fieldname') <span class="text-red-500">{{ $message }}</span> @enderror`

### CSRF token mismatch
**Symptom:** `419 Page Expired` when submitting a form.
**Fix:**
- You forgot to include `@csrf` inside your `<form>` tag in the Blade file.

---

## 6. Layout & UI Issues

### Sidebar not opening
**Symptom:** Clicking a sidebar parent link doesn't open the submenu.
**Fix:**
- Check if Alpine.js or your custom JavaScript is actually running. Look at the browser console (F12) for JS errors.
- Ensure the `id` of the submenu matches the `aria-controls` target in the button.

### Mobile layout broken
**Symptom:** The admin table is stretching off the screen on a phone, creating a horizontal scrollbar for the whole page.
**Fix:**
- You probably used a fixed width (like `w-[800px]`) instead of `w-full`.
- Wrap your `<table>` in a `<div class="overflow-x-auto">` so only the table scrolls, not the whole page.

---

## 7. Import & External Logic Issues

### CSV import failing
**Symptom:** The batch upload returns "Invalid format" for every row.
**Fix:**
- Open the CSV in Excel/Notepad. Does it have the exact header names the `BatchBookImportService` expects (e.g., `title`, `author`, `isbn`)?
- Check for hidden spaces in the column headers.

### MARC file not parsing
**Symptom:** The system crashes when uploading an `.mrc` file.
**Fix:**
- Ensure you have the required MARC parser package installed in `composer.json`.
- Ensure the uploaded file is binary MARC21, not MARCXML.

### Authentication failure
**Symptom:** "Invalid credentials" even though you know the password is correct.
**Fix:**
- Check the `member_auth` table. Are passwords hashed using bcrypt, or did someone manually type "password123" into the database? Laravel cannot verify unhashed passwords.
- Ensure `getAuthPassword()` in the `MemberAuth` model points to the correct `password_hash` column.
