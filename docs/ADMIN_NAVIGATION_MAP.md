# Admin Navigation Map

Dashboard
├── Route: admin.dashboard
├── Controller: Closure in web.php
├── Blade: admin.dashboard
├── Parent Group: MAIN
└── Status: Completed

Catalog
├── Main Page: Catalog (Not Clickable directly, it's a section header)
├── Books
│   ├── Main Page: Book Manager
│   │   ├── URL: /admin/books
│   │   ├── Route: admin.books.index
│   │   ├── Controller: BookDataController@index
│   │   ├── Blade: admin.bookManager
│   │   └── Status: Completed
│   ├── Add Book
│   │   ├── Route: admin.books.create
│   │   ├── Controller: BookDataController@create
│   │   ├── Blade: admin.addBook
│   │   └── Status: Completed
│   ├── Quick Add Book
│   │   ├── Route: admin.books.quick-create
│   │   └── Status: Completed
│   └── Batch Add Books
│       ├── Route: admin.books.batch-create
│       └── Status: Completed
└── Reservations
    ├── Route: N/A
    └── Status: Missing

Circulation
├── Main Page: Circulation Desk (WIP)
├── Check-out (WIP)
├── Check-in (WIP)
└── Renew (WIP)
Note: Circulation pages are missing from current implementation. Marked as disabled.

Users
├── Main Page: User Management
│   ├── URL: /admin/users
│   ├── Route: admin.users.index
│   ├── Controller: UserManagementController@index
│   ├── Blade: admin.users.index
│   └── Status: Completed
├── Members
│   ├── URL: /admin/users?type=member
│   └── Status: Completed
├── Librarians
│   ├── URL: /admin/users?type=librarian
│   └── Status: Completed
├── Add Member
│   ├── Route: admin.members.create
│   └── Status: Completed
└── Add Librarian
    ├── Route: admin.librarians.create
    └── Status: Completed

System
├── Reports
│   ├── Route: N/A
│   └── Status: Missing
└── Settings
    ├── Route: N/A (actually admin/settings blade exists but no route named settings. Wait, there's no `admin.settings` route. I'll document it as missing route).
    └── Status: Partially completed (Blade exists, no route)
