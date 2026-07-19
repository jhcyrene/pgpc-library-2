<?php

namespace Tests\Feature;

use App\Models\Librarian;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class LibrarianSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_librarian_can_update_profile_and_password_through_react_settings(): void
    {
        $librarian = Librarian::factory()->create([
            'first_name' => 'Lina',
            'last_name' => 'Library',
            'email' => 'lina@example.test',
            'position' => 'Librarian',
        ]);
        $account = MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'lina.settings',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Librarian',
            'account_status' => 'Active',
        ]);

        $this->actingAs($account, 'member')
            ->get(route('librarian.settings.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Staff/Settings/Librarian')
                ->where('settings.profile.id', $librarian->librarian_id)
                ->where('settings.profile.firstName', 'Lina')
                ->where('settings.profile.email', 'lina@example.test')
                ->where('settings.account.username', 'lina.settings')
                ->where('settings.forms.profileUrl', route('librarian.settings.profile'))
                ->where('settings.forms.passwordUrl', route('librarian.settings.password')));

        $this->actingAs($account, 'member')
            ->put(route('librarian.settings.profile'), [
                'first_name' => 'Linette',
                'middle_name' => 'M',
                'last_name' => 'Library',
                'email' => 'linette@example.test',
                'position' => 'Head Librarian',
            ])->assertRedirect(route('librarian.settings.index'))
            ->assertSessionHas('success', 'Profile updated successfully.');

        $this->assertDatabaseHas('librarians', [
            'librarian_id' => $librarian->librarian_id,
            'first_name' => 'Linette',
            'email' => 'linette@example.test',
            'position' => 'Head Librarian',
        ]);

        $this->actingAs($account, 'member')
            ->put(route('librarian.settings.password'), [
                'current_password' => 'incorrect-password',
                'password' => 'NewLibraryPassword123!',
                'password_confirmation' => 'NewLibraryPassword123!',
            ])->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password123', $account->fresh()->password_hash));

        $this->actingAs($account, 'member')
            ->put(route('librarian.settings.password'), [
                'current_password' => 'password123',
                'password' => 'NewLibraryPassword123!',
                'password_confirmation' => 'NewLibraryPassword123!',
            ])->assertRedirect(route('librarian.settings.index'))
            ->assertSessionHas('success', 'Password updated successfully.');

        $account->refresh();
        $this->assertTrue(Hash::check('NewLibraryPassword123!', $account->password_hash));
        $this->assertNotNull($account->password_changed_at);
    }
}
