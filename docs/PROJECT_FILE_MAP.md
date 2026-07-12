Related documentation:

- [Main Technical Guide](PROJECT_TECHNICAL_GUIDE.md)
- [Project File Map](PROJECT_FILE_MAP.md)
- [Project Logic Flow](PROJECT_LOGIC_FLOW.md)
- [Troubleshooting Guide](PROJECT_TROUBLESHOOTING_GUIDE.md)
- [Command Reference](PROJECT_COMMAND_REFERENCE.md)

# Project File Map

This document explains where files are located in the PGPC ILMS project and what they do. 

## 1. Directory Tree Overview

```text
PGPC ILMS
├── app/
│   ├── Http/
│   │   ├── Controllers/  (Handles web requests)
│   │   ├── Requests/     (Validates form submissions)
│   │   └── Middleware/   (Filters requests)
│   ├── Models/           (Database table representatives)
│   └── Services/         (Complex logic handlers)
├── database/
│   ├── migrations/       (Database structure creators)
│   └── seeders/          (Dummy data inserters)
├── resources/
│   ├── views/
│   │   ├── admin/        (Admin dashboard pages)
│   │   ├── auth/         (Login pages)
│   │   └── components/   (Reusable HTML pieces)
│   ├── css/              (Source Tailwind CSS)
│   └── js/               (Source JavaScript)
├── routes/
│   └── web.php           (URL routing rules)
├── config/               (App settings)
├── storage/              (Logs and user uploads)
└── tests/                (Automated testing scripts)
```

## 2. Important File Paths & Their Purpose

### Configuration & Routing
- `routes/web.php`: The main entry point for all URLs. If you add a new page, it must be registered here.
- `.env`: (Ignored in Git) Contains your database credentials.
- `package.json`: Contains Node dependencies (Tailwind, DaisyUI).
- `composer.json`: Contains PHP dependencies (Laravel).
- `tailwind.config.js`: Tells Tailwind where to look for your CSS classes so it can compile them.
- `vite.config.js`: Tells Vite how to bundle your CSS and JS.

### Models (`app/Models/`)
- `BookData.php`: Represents the main title of a book.
- `BookDetail.php`: Represents specific publication info (ISBN, year).
- `Book.php`: Represents a single physical copy on the shelf.
- `Member.php`: Represents a student's profile.
- `Librarian.php`: Represents a librarian's profile.
- `MemberAuth.php`: Represents login credentials for either members or librarians.

### Services (`app/Services/`)
- `BookService.php`: Contains the logic for saving a book across multiple tables (Title, Details, physical copy).
- `BatchBookImportService.php`: Reads CSV files, validates rows, and saves multiple books at once.
- `UserManagementService.php`: Saves user profiles and handles password hashing.

### Views (`resources/views/`)
- `admin/dashboard.blade.php`: The main landing page after admin login.
- `admin/books/index.blade.php`: The Book Manager list.
- `admin/books/create.blade.php`: The "Add Book" form.
- `admin/users/index.blade.php`: The user management list.

### Shared Components (`resources/views/components/`)
- `admin-layout.blade.php`: The main layout shell used by all admin pages.
- `sidebar.blade.php`: The admin navigation sidebar.
- `header.blade.php`: The top navigation bar in the admin panel.

## 3. Feature-to-File Map

| Feature | Route File | Controller | Request | Service | Model | View | Component |
| ------- | ---------- | ---------- | ------- | ------- | ----- | ---- | --------- |
| Book Manager | `web.php` | `BookDataController` | N/A | `BookService` | `BookData` | `admin/books/index` | `table` |
| Add Book | `web.php` | `BookDataController` | `StoreBookDataRequest` | `BookService` | `BookData`, `BookDetail`, `Book` | `admin/books/create` | `input`, `select` |
| Quick Add | `web.php` | `QuickBookController`| `QuickStoreBookRequest`| `BookService` | `BookData`, `BookDetail`, `Book` | `admin/books/quick-add`| `input` |
| Batch Add | `web.php` | `BatchBookController` | N/A | `BatchBookImportService`| `BookData`, `Book` | `admin/books/batch/*` | `alert` |
| MARC Import | `web.php` | *(Planned)* | *(Planned)* | *(Planned)* | `BookData` | *(Planned)* | N/A |
| Add Copy | `web.php` | `BookController` | `StoreBookCopyRequest` | N/A | `Book` | `admin/books/copies/*` | `input` |
| User Manager | `web.php` | `UserManagementController`| N/A | N/A | `Member`, `Librarian` | `admin/users/index` | `table` |
| Add Member | `web.php` | `MemberController` | `StoreMemberRequest` | `UserManagementService` | `Member`, `MemberAuth`| `admin/members/create`| `input` |
| Add Librarian | `web.php` | `LibrarianController`| `StoreLibrarianRequest`| `UserManagementService` | `Librarian`, `MemberAuth`|`admin/librarians/create`|`input`|
| Login | `web.php` | *(Planned)* | *(Planned)* | N/A | `MemberAuth` | `auth/login` | `input` |
| Reservation | `web.php` | *(Planned)* | *(Planned)* | *(Planned)* | `BookRequest` | *(Planned)* | N/A |
| Check-out | `web.php` | *(Planned)* | *(Planned)* | *(Planned)* | `BookBorrow` | *(Planned)* | N/A |
| Check-in | `web.php` | *(Planned)* | *(Planned)* | *(Planned)* | `BookBorrow` | *(Planned)* | N/A |
| Dashboard | `web.php` | `routes/web.php` (Closure)| N/A | N/A | All models | `admin/dashboard` | `stat-card` |

## 4. Files You Should Not Edit

Do not edit files inside the `vendor/` or `node_modules/` directories. 
- These contain framework code installed by Composer and NPM. 
- Any changes you make here will be overwritten the next time someone runs `composer install` or `npm install`.

Do not edit the `database/database.sqlite` file directly with a text editor. Use a database management tool like DBeaver or TablePlus.

Do not edit files inside `public/build/`.
- These are generated automatically by Vite. Edit the files in `resources/css` or `resources/js` and let Vite compile them for you.

## 5. Old or Unused Files

- `resources/views/welcome.blade.php`: The default Laravel landing page. Safe to delete or replace with the actual OPAC homepage.
- Passkey models and requests (`passkey.php`, `PasskeyController.php`, `StorepasskeyRequest.php`, `UpdatepasskeyRequest.php`): These appear to be experimental features. If Passkeys are not in the final design requirements, these can be safely removed to reduce technical debt.
