# Authentication Changelog

## [1.0.0] - Authentication Stabilization

### Added
- Created `AuthenticatedSessionController` to securely manage session lifecycle, replacing the makeshift `StudentAuthController`.
- Created `RegisteredStudentController` to securely handle public student registrations using database transactions.
- Created `LoginRequest` and `RegisterStudentRequest` form requests with comprehensive validation rules mirroring database column constraints.
- Created `StudentLoginTest` and `StudentRegistrationTest` feature tests ensuring core security.
- Added support for logging in via either `username` or `student_id_number` to improve UX.

### Changed
- `routes/web.php` auth routes completely mapped to the new controllers inside a `guest:member` middleware group.
- `logincard.blade.php` modified to accept both ID types and label appropriately, also added `autocomplete` tags for accessibility.
- `registercard.blade.php` overhauled to collect full profile data for students, conforming to the exact database schema.

### Removed
- Removed `StudentAuthController`.
- Removed `StudentLoginRequest`.
