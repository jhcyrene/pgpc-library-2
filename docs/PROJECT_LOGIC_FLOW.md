Related documentation:

- [Main Technical Guide](PROJECT_TECHNICAL_GUIDE.md)
- [Project File Map](PROJECT_FILE_MAP.md)
- [Project Logic Flow](PROJECT_LOGIC_FLOW.md)
- [Troubleshooting Guide](PROJECT_TROUBLESHOOTING_GUIDE.md)
- [Command Reference](PROJECT_COMMAND_REFERENCE.md)

# Project Logic Flow

This document maps out exactly how data moves through the system for every major action. If you need to understand or change a feature, follow these arrows.

## 1. Add Book (Regular)
When an admin fills out the full Add Book form.

```text
Route           (POST /admin/books -> 'admin.books.store')
   ↓
Request         (StoreBookDataRequest -> Validates title, isbn, publisher)
   ↓
Controller      (BookDataController@store)
   ↓
Service         (BookService@createBook -> Starts Database Transaction)
   ↓
Model           (Creates BookData, BookDetail)
   ↓
Model           (Finds/Creates Publisher, Author, Category)
   ↓
Database        (Saves to book_data, book_details, publishers, authors, categories)
   ↓
Model           (Attaches via Pivot Tables: book_author, book_category)
   ↓
Model           (Creates initial physical Book copy)
   ↓
Database        (Saves to books)
   ↓
Redirect        (Redirects back to route('admin.books.index'))
   ↓
View            (Displays admin.books.index with success message)
```

## 2. Quick Add Book
When an admin uses the fast-entry book form.

```text
Route           (POST /admin/books-quick -> 'admin.books.quick-store')
   ↓
Request         (QuickStoreBookRequest -> Validates minimum fields: title, author)
   ↓
Controller      (QuickBookController@store)
   ↓
Service         (BookService@createBook)
   ↓
Model           (Creates BookData, BookDetail, Book)
   ↓
Database        (Saves to book_data, book_details, books with default empty values)
   ↓
Redirect        (Redirects back to route('admin.books.quick-create'))
   ↓
View            (Displays admin.books.quick-add with success message)
```

## 3. Batch Add Book
When an admin uploads a CSV.

```text
Route           (POST /admin/books-batch/import -> 'admin.books.batch-store')
   ↓
Controller      (BatchBookController@store)
   ↓
Service         (BatchBookImportService@import -> Reads CSV headers)
   ↓
Service         (BatchBookImportService@processRow -> Checks each row)
   ↓
Database        (Saves to book_data, book_details, books based on duplication logic)
   ↓
Redirect        (Redirects back to route('admin.books.index'))
   ↓
View            (Displays admin.books.index with import summary alert)
```

## 4. Add Physical Copy
When an admin adds another copy to an existing title.

```text
Route           (POST /admin/books/{bookData}/copies -> 'admin.books.copies.store')
   ↓
Request         (StoreBookCopyRequest -> Validates accession number)
   ↓
Controller      (BookController@store)
   ↓
Model           (Creates Book)
   ↓
Database        (Saves to books table, linked to existing book_id)
   ↓
Redirect        (Redirects back to route('admin.books.copies.index'))
   ↓
View            (Displays admin.books.copies with success message)
```

## 5. Add Member
When an admin creates a new student account.

```text
Route           (POST /admin/members -> 'admin.members.store')
   ↓
Request         (StoreMemberRequest -> Validates email, student ID)
   ↓
Controller      (MemberController@store)
   ↓
Service         (UserManagementService@createMember -> Starts Transaction)
   ↓
Model           (Creates Member)
   ↓
Database        (Saves to members table)
   ↓
Model           (Optionally Creates MemberAuth with hashed password)
   ↓
Database        (Saves to member_auth table)
   ↓
Redirect        (Redirects back to route('admin.users.index'))
   ↓
View            (Displays admin.users.index with success message)
```

## 6. Add Librarian
When an admin creates another admin account.

```text
Route           (POST /admin/librarians -> 'admin.librarians.store')
   ↓
Request         (StoreLibrarianRequest)
   ↓
Controller      (LibrarianController@store)
   ↓
Service         (UserManagementService@createLibrarian -> Starts Transaction)
   ↓
Model           (Creates Librarian, Creates MemberAuth)
   ↓
Database        (Saves to librarians, member_auth)
   ↓
Redirect        (Redirects back to route('admin.users.index'))
   ↓
View            (Displays admin.users.index with success message)
```

## 7. Login (Planned)
When a user attempts to log in.

```text
Route           (POST /student/login -> 'login.store')
   ↓
Request         (LoginRequest -> Validates username/email and password format)
   ↓
Controller      (AuthController@store)
   ↓
Laravel Auth    (Auth::attempt() -> Compares password hash against MemberAuth)
   ↓
Session         (Generates session token if successful)
   ↓
Redirect        (Redirects to intended page or Dashboard)
```

## 8. Reservation (Planned)
When a student requests a book from the OPAC.

```text
Route           (POST /reservations -> 'reservations.store')
   ↓
Middleware      (Checks if student is logged in, redirects if not)
   ↓
Request         (StoreReservationRequest)
   ↓
Controller      (ReservationController@store)
   ↓
Service         (ReservationService -> Checks limits and unpaid fines)
   ↓
Model           (Creates BookRequest)
   ↓
Database        (Saves to book_requests table with 'pending' status)
   ↓
Redirect        (Redirects to student borrow history)
```

## 9. Check-out (Planned)
When a librarian hands a book to a student.

```text
Route           (POST /admin/circulation/checkout -> 'admin.circulation.checkout')
   ↓
Request         (StoreCheckoutRequest -> Validates member ID and book accession)
   ↓
Controller      (CirculationController@checkout)
   ↓
Service         (CirculationService -> Verifies copy is available)
   ↓
Model           (Creates BookBorrow, Updates Book)
   ↓
Database        (Saves to book_borrows, changes books.status to 'borrowed')
   ↓
Redirect        (Redirects back to circulation desk)
```

## 10. Check-in (Planned)
When a student returns a book on time.

```text
Route           (POST /admin/circulation/checkin -> 'admin.circulation.checkin')
   ↓
Request         (StoreCheckinRequest -> Validates accession number)
   ↓
Controller      (CirculationController@checkin)
   ↓
Service         (CirculationService -> Calculates late days = 0)
   ↓
Model           (Updates BookBorrow, Updates Book)
   ↓
Database        (Changes book_borrows.status to 'returned', books.status to 'available')
   ↓
Redirect        (Redirects back to circulation desk)
```

## 11. Return with Fine (Planned)
When a student returns a book late.

```text
Route           (POST /admin/circulation/checkin -> 'admin.circulation.checkin')
   ↓
Controller      (CirculationController@checkin)
   ↓
Service         (CirculationService -> Calculates late days > 0)
   ↓
Model           (Updates BookBorrow, Updates Book, Creates FineDue)
   ↓
Database        (Updates borrows and books, saves penalty to fine_dues)
   ↓
Redirect        (Redirects to fine payment screen)
```

## 12. MARC Import (Planned)
When an admin uploads a `.mrc` file.

```text
Route           (POST /admin/marc/import)
   ↓
Controller      (MarcController@store)
   ↓
Service         (MarcExtractorService -> Parses .mrc binary into text)
   ↓
Service         (MarcMapperService -> Maps tags like 245$a to Title)
   ↓
Controller      (Returns Preview view)
   ↓
User Confirmation
   ↓
Service         (BatchBookImportService -> Same saving flow as CSV Batch Add)
```

## 13. Sidebar Navigation
When an admin clicks a menu item with a submenu (e.g., "Books").

```text
User            (Clicks parent label 'Books')
   ↓
Route           (GET /admin/books -> 'admin.books.index')
   ↓
Blade           (Checks if current route matches 'admin.books.*')
   ↓
CSS             (Applies 'active' and 'expanded' Tailwind classes)
   ↓
Browser         (Displays the Books page with the submenu visually open)
```
*Note: Clicking the arrow instead of the label triggers JavaScript to toggle the submenu visibility without sending a request to the server.*
