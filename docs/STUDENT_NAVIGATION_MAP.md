# Student Navigation Map

This document outlines the hierarchical structure of the Student Portal navigation.

```text
Student Portal (/student)
│
├── Dashboard (/dashboard)
│   └── Overview of current borrows, fines, reservations, and history.
│
├── Borrowing (Group)
│   ├── Current Borrows (/borrow-transactions/current)
│   │   └── List of books currently checked out by the student.
│   │
│   ├── History (/borrow-transactions/history)
│   │   └── Log of all previously borrowed and returned books.
│   │
│   └── Overdue Items (/overdue-items)
│       └── Filtered view showing only items past their due date.
│
├── Reservations (/reservations)
│   ├── Index: List of all active/past reservations and their status.
│   ├── Create (/reservations/create/{bookData}): Form to confirm a reservation.
│   └── Show (/reservations/{reservation}): Detailed timeline of a specific reservation.
│
├── Saved Items (/saved-items)
│   └── Grid view of bookmarked books with quick links to reserve.
│
├── Fines & Penalties (/fines)
│   └── Table of all fines, their corresponding books, amounts, and payment status.
│
└── Account (Group)
    ├── Profile (/profile)
    │   ├── Show: View current profile details.
    │   └── Edit (/profile/edit): Update name, email, and phone number.
    │
    └── Settings (/account-settings)
        └── Change account password securely.
```
