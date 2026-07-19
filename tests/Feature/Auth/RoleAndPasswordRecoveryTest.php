<?php

namespace Tests\Feature\Auth;

use App\Models\Librarian;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RoleAndPasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_librarian_has_a_separate_dashboard_and_cannot_manage_accounts(): void
    {
        $librarian = Librarian::factory()->create(['first_name' => 'Lina']);
        $account = MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'account_type' => 'Librarian',
            'account_status' => 'Active',
            'username' => 'lina.library',
            'password_hash' => Hash::make('password123'),
        ]);

        $this->actingAs($account, 'member')
            ->get(route('librarian.dashboard'))
            ->assertOk()
            ->assertSee('Lina');

        $this->actingAs($account, 'member')
            ->get(route('admin.books.index'))
            ->assertOk()
            ->assertSee(route('librarian.dashboard'), false);

        $this->actingAs($account, 'member')
            ->get(route('librarian.settings.index'))
            ->assertOk()
            ->assertSee(route('librarian.settings.profile'), false)
            ->assertSee(route('librarian.settings.password'), false);

        $this->actingAs($account, 'member')
            ->get(route('admin.users.index'))
            ->assertRedirect(route('librarian.dashboard'));
    }

    public function test_student_can_complete_the_verification_code_password_reset_flow(): void
    {
        Mail::fake();

        $member = Member::factory()->create(['email' => 'reset.student@example.test']);
        $account = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'account_type' => 'Member',
            'account_status' => 'Active',
            'username' => 'reset.student',
            'password_hash' => Hash::make('old-password1'),
        ]);

        $this->post(route('forgot-password.send'), ['email' => $member->email])
            ->assertRedirect(route('forgot-password.otp'))
            ->assertSessionHas('password_reset_account_id', $account->member_auth_id);

        $account->refresh()->forceFill([
            'password_token' => Hash::make('123456'),
            'token_expiry' => now()->addMinutes(10),
        ])->save();

        $this->withSession([
            'password_reset_account_id' => $account->member_auth_id,
            'password_reset_email' => $member->email,
        ])->post(route('forgot-password.verify'), [
            'digits' => ['1', '2', '3', '4', '5', '6'],
        ])->assertRedirect(route('forgot-password.reset'));

        $this->post(route('forgot-password.update'), [
            'password' => 'new-password2',
            'password_confirmation' => 'new-password2',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('new-password2', $account->fresh()->password_hash));
        $this->assertNull($account->fresh()->password_token);
    }
}
