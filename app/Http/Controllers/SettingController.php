<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $defaultBorrowDays = Setting::get('default_borrow_days', env('DEFAULT_BORROW_DAYS', 3));
        $dailyFineAmount = Setting::get('daily_fine_amount', env('DAILY_FINE_AMOUNT', 10.0));

        return view('admin.settings.index', compact('defaultBorrowDays', 'dailyFineAmount'));
    }

    /**
     * Update the settings in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'default_borrow_days' => 'required|integer|min:1',
            'daily_fine_amount' => 'required|numeric|min:0',
        ]);

        Setting::set('default_borrow_days', $request->input('default_borrow_days'));
        Setting::set('daily_fine_amount', $request->input('daily_fine_amount'));

        return redirect()->route('admin.settings.index')
            ->with('success', 'System settings have been updated successfully.');
    }
}
