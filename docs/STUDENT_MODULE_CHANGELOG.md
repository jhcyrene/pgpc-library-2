# Student Module Changelog

All notable changes to the Student Module will be documented in this file.

## [1.0.0] - Initial Implementation

### Added
- **Authentication:**
  - Registered `member` guard in `config/auth.php`.
  - Created `StudentAuthMiddleware` to protect student routes.
  - Implemented `StudentAuthController` and `StudentLoginRequest`.
- **Database:**
  - Created `saved_items` table and `SavedItem` model for reading lists.
- **Services:**
  - `StudentDashboardService`: Aggregates data for the dashboard.
  - `ReservationService`: Handles eligibility checks and reservation creation/cancellation.
  - `SavedItemService`: Manages adding/removing items from the reading list.
- **Controllers:**
  - `StudentDashboardController`
  - `BorrowTransactionController` (current, history, overdue)
  - `ReservationController`
  - `SavedItemController`
  - `FineController`
  - `ProfileController`
  - `AccountSettingsController`
- **Routing:**
  - Added a protected `Route::middleware(['student'])` group under the `/student` prefix.
- **Views & UI:**
  - `x-layout.student` component with `sidebar` and `header`.
  - Navigation components (`nav-section`, `nav-group`, `nav-item`, `nav-subitem`).
  - Dashboard view with summary cards and recent activity.
  - Data tables for borrow transactions, fines, and reservations.
  - Profile and Settings editing forms.

### Changed
- Updated `logincard.blade.php` to post to the new `student.login.store` route.

### Fixed
- N/A (Initial release)
