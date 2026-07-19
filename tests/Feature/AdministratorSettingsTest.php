<?php

namespace Tests\Feature;

use App\Models\Librarian;
use App\Models\MemberAuth;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdministratorSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_view_validate_and_update_system_settings(): void
    {
        $profile = Librarian::factory()->create();
        $administrator = MemberAuth::factory()->create([
            'librarian_id' => $profile->librarian_id,
            'username' => 'system.settings.admin',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Administrator',
            'account_status' => 'Active',
        ]);
        Setting::set('default_borrow_days', 7);
        Setting::set('daily_fine_amount', 12.50);

        $this->actingAs($administrator, 'member')
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Staff/Settings/Administrator')
                ->where('staffPortal.staff.isAdministrator', true)
                ->where('staffPortal.routes.settings', route('admin.settings.index'))
                ->where('systemSettings.defaultBorrowDays', 7)
                ->where('systemSettings.dailyFineAmount', 12.5)
                ->where('systemSettings.updateUrl', route('admin.settings.store')));

        $this->actingAs($administrator, 'member')
            ->post(route('admin.settings.store'), [
                'default_borrow_days' => 0,
                'daily_fine_amount' => -1,
            ])->assertSessionHasErrors(['default_borrow_days', 'daily_fine_amount']);

        $this->assertEquals(7, Setting::get('default_borrow_days'));
        $this->assertEquals(12.5, Setting::get('daily_fine_amount'));

        $this->actingAs($administrator, 'member')
            ->post(route('admin.settings.store'), [
                'default_borrow_days' => 14,
                'daily_fine_amount' => 15.75,
            ])->assertRedirect(route('admin.settings.index'))
            ->assertSessionHas('success', 'System settings have been updated successfully.');

        $this->assertDatabaseHas('settings', ['key' => 'default_borrow_days', 'value' => '14']);
        $this->assertDatabaseHas('settings', ['key' => 'daily_fine_amount', 'value' => '15.75']);
        $this->assertEquals(14, Setting::get('default_borrow_days'));
        $this->assertEquals(15.75, Setting::get('daily_fine_amount'));
    }

    public function test_librarian_cannot_access_administrator_system_settings(): void
    {
        $profile = Librarian::factory()->create();
        $librarian = MemberAuth::factory()->create([
            'librarian_id' => $profile->librarian_id,
            'username' => 'settings.librarian',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Librarian',
            'account_status' => 'Active',
        ]);

        $this->actingAs($librarian, 'member')
            ->get(route('admin.settings.index'))
            ->assertRedirect(route('librarian.dashboard'));

        $this->actingAs($librarian, 'member')
            ->post(route('admin.settings.store'), [
                'default_borrow_days' => 30,
                'daily_fine_amount' => 0,
            ])->assertRedirect(route('librarian.dashboard'));

        $this->assertDatabaseMissing('settings', ['key' => 'default_borrow_days']);
    }
}
