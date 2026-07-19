<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $account = $request->user('member');
        $accountType = strtolower((string) ($account?->account_type ?? ''));

        $dashboardUrl = match (true) {
            in_array($accountType, ['member', 'student'], true) => route('student.dashboard'),
            $accountType === 'librarian' => route('librarian.dashboard'),
            $account !== null => route('admin.dashboard'),
            default => null,
        };

        $isStudent = $account !== null
            && $account->member_id
            && in_array($accountType, ['member', 'student'], true);
        $student = $isStudent ? $account->member : null;
        $isAdministrator = in_array($accountType, ['administrator', 'admin'], true);
        $isStaff = $account !== null
            && $account->librarian_id
            && ($isAdministrator || $accountType === 'librarian');
        $staff = $isStaff ? $account->librarian : null;
        $profile = $student ?? $staff;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $account ? [
                    'id' => $account->getKey(),
                    'accountType' => $accountType,
                    'firstName' => $profile?->first_name,
                    'lastName' => $profile?->last_name,
                ] : null,
                'dashboardUrl' => $dashboardUrl,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'status' => fn () => $request->session()->get('status'),
            ],
            'studentPortal' => $isStudent ? [
                'student' => [
                    'id' => (int) $student->member_id,
                    'studentId' => $student->student_id_number,
                    'firstName' => $student->first_name,
                    'lastName' => $student->last_name,
                    'program' => $student->program,
                    'yearLevel' => $student->year_level,
                ],
                'routes' => [
                    'dashboard' => route('student.dashboard'),
                    'catalog' => route('opac.index'),
                    'borrows' => route('student.borrow-transactions.index'),
                    'currentBorrows' => route('student.borrow-transactions.current'),
                    'borrowHistory' => route('student.borrow-transactions.history'),
                    'overdue' => route('student.overdue-items.index'),
                    'reservations' => route('student.reservations.index'),
                    'savedItems' => route('student.saved-items.index'),
                    'fines' => route('student.fines.index'),
                    'profile' => route('student.profile.show'),
                    'accountSettings' => route('student.account-settings.edit'),
                    'logout' => route('logout'),
                ],
            ] : null,
            'staffPortal' => $isStaff ? [
                'staff' => [
                    'id' => (int) $staff->librarian_id,
                    'employeeNumber' => $staff->employee_number,
                    'firstName' => $staff->first_name,
                    'lastName' => $staff->last_name,
                    'position' => $staff->position,
                    'roleLabel' => $isAdministrator ? 'Administrator' : 'Librarian',
                    'isAdministrator' => $isAdministrator,
                    'profileImage' => $account->profile_image,
                ],
                'routes' => [
                    'dashboard' => $isAdministrator ? route('admin.dashboard') : route('librarian.dashboard'),
                    'catalogSearch' => route('admin.books.index'),
                    'reservations' => route('admin.reservations.index'),
                    'circulation' => route('admin.circulation.index'),
                    'borrows' => route('admin.borrows.index'),
                    'books' => route('admin.books.index'),
                    'addBook' => route('admin.books.create'),
                    'quickAddBook' => route('admin.books.quick-create'),
                    'batchAddBooks' => route('admin.books.batch-create'),
                    'users' => $isAdministrator ? route('admin.users.index') : null,
                    'settings' => $isAdministrator ? route('admin.settings.index') : route('librarian.settings.index'),
                    'logout' => route('logout'),
                ],
            ] : null,
        ];
    }
}
