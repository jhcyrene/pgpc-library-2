<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Librarian;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');
        $search = $request->query('search');

        $membersQuery = DB::table('members')
            ->leftJoin('member_auth', 'members.member_id', '=', 'member_auth.member_id')
            ->select(
                'members.member_id as id', 
                'members.student_id_number as identifier', 
                'members.first_name', 
                'members.last_name', 
                'members.email', 
                DB::raw("'Member' as type"), 
                'member_auth.account_status', 
                'member_auth.username', 
                'member_auth.last_login_at', 
                'members.created_at',
                'member_auth.member_auth_id'
            )
            ->whereNull('members.deleted_at');

        $librariansQuery = DB::table('librarians')
            ->leftJoin('member_auth', 'librarians.librarian_id', '=', 'member_auth.librarian_id')
            ->select(
                'librarians.librarian_id as id', 
                'librarians.employee_number as identifier', 
                'librarians.first_name', 
                'librarians.last_name', 
                'librarians.email', 
                DB::raw("'Librarian' as type"), 
                'member_auth.account_status', 
                'member_auth.username', 
                'member_auth.last_login_at', 
                'librarians.created_at',
                'member_auth.member_auth_id'
            )
            ->whereNull('librarians.deleted_at');

        if ($search) {
            $membersQuery->where(function($q) use ($search) {
                $q->where('members.first_name', 'like', "%{$search}%")
                  ->orWhere('members.last_name', 'like', "%{$search}%")
                  ->orWhere('members.student_id_number', 'like', "%{$search}%")
                  ->orWhere('member_auth.username', 'like', "%{$search}%");
            });

            $librariansQuery->where(function($q) use ($search) {
                $q->where('librarians.first_name', 'like', "%{$search}%")
                  ->orWhere('librarians.last_name', 'like', "%{$search}%")
                  ->orWhere('librarians.employee_number', 'like', "%{$search}%")
                  ->orWhere('member_auth.username', 'like', "%{$search}%");
            });
        }

        if ($type === 'member') {
            $query = $membersQuery;
        } elseif ($type === 'librarian') {
            $query = $librariansQuery;
        } else {
            $query = $membersQuery->union($librariansQuery);
        }

        // We use query builder pagination directly.
        // Wait, for union queries in SQLite, it's safer to wrap them in a subquery for proper ordering.
        $wrappedQuery = DB::query()->fromSub($query, 'users_union')->orderByDesc('created_at');
        
        $users = $wrappedQuery->paginate(15)->appends($request->query());

        // For summary counts
        $totalMembers = DB::table('members')->whereNull('deleted_at')->count();
        $totalLibrarians = DB::table('librarians')->whereNull('deleted_at')->count();
        $activeAccounts = DB::table('member_auth')->where('account_status', 'Active')->count();
        $lockedAccounts = DB::table('member_auth')->whereIn('account_status', ['Locked', 'Suspended'])->count();

        return view('admin.users.index', compact('users', 'type', 'search', 'totalMembers', 'totalLibrarians', 'activeAccounts', 'lockedAccounts'));
    }

    public function show($type, $id)
    {
        if ($type === 'member') {
            $user = Member::with('memberAuth')->withCount(['bookBorrows', 'bookRequests'])->findOrFail($id);
            return view('admin.users.show', compact('user', 'type'));
        } elseif ($type === 'librarian') {
            $user = Librarian::with('memberAuth')->findOrFail($id);
            return view('admin.users.show', compact('user', 'type'));
        }

        abort(404);
    }
}
