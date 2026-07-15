<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Librarian;
use App\Http\Requests\StoreLibrarianRequest;
use App\Http\Requests\UpdateLibrarianRequest;
use App\Services\UserManagementService;

class LibrarianController extends Controller
{
    protected $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    public function create()
    {
        return view('admin.users.create', ['type' => 'librarian']);
    }

    public function store(StoreLibrarianRequest $request)
    {
        $profileData = $request->only(['employee_number', 'first_name', 'middle_name', 'last_name', 'email', 'position']);
        $authData = $request->only(['create_account', 'username', 'password', 'account_type', 'account_status']);
        
        $librarian = $this->userService->createLibrarian($profileData, $authData);

        return redirect()->route('admin.users.show', ['type' => 'librarian', 'id' => $librarian->librarian_id])
            ->with('success', 'Librarian created successfully.');
    }

    public function edit(Librarian $librarian)
    {
        $librarian->load('memberAuth');
        return view('admin.users.edit', ['type' => 'librarian', 'user' => $librarian]);
    }

    public function update(UpdateLibrarianRequest $request, Librarian $librarian)
    {
        $profileData = $request->only(['employee_number', 'first_name', 'middle_name', 'last_name', 'email', 'position']);
        $authData = $request->only(['create_account', 'username', 'password', 'account_type', 'account_status']);
        
        if (empty($authData['password'])) {
            unset($authData['password']);
        }

        $authDataPass = ($request->boolean('create_account') || $librarian->memberAuth) ? $authData : null;

        $this->userService->updateLibrarian($librarian, $profileData, $authDataPass);

        return redirect()->route('admin.users.show', ['type' => 'librarian', 'id' => $librarian->librarian_id])
            ->with('success', 'Librarian updated successfully.');
    }

    public function destroy(Librarian $librarian)
    {
        // Check for transactions
        $hasTransactions = $librarian->finePayments()->exists() || $librarian->bookBorrows()->exists();
        if ($hasTransactions) {
            return back()->with('error', 'This librarian cannot be deleted because transaction records exist.');
        }

        $librarian->delete();
        if ($librarian->memberAuth) {
            $librarian->memberAuth->delete();
        }

        return redirect()->route('admin.users.index', ['type' => 'librarian'])
            ->with('success', 'Librarian deactivated/deleted successfully.');
    }
}
