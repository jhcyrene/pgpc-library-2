<?php

namespace Tests\Feature\Auth;

use App\Models\Librarian;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_student_can_authenticate_using_username(): void
    {
        $member = Member::factory()->create();
        $user = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'active',
            'account_type' => 'Member',
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user, 'member');
        $response->assertRedirect('/student/dashboard');
    }

    public function test_student_can_authenticate_using_student_id(): void
    {
        $member = Member::factory()->create([
            'student_id_number' => '04-12345',
        ]);
        $user = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'active',
            'account_type' => 'Member',
        ]);

        $response = $this->post('/login', [
            'login' => '04-12345',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user, 'member');
        $response->assertRedirect('/student/dashboard');
    }

    public function test_staff_login_page_can_be_rendered(): void
    {
        $this->get(route('staff.login'))
            ->assertOk()
            ->assertSee('Administrators and librarians');
    }

    public function test_administrator_can_sign_in_through_staff_login(): void
    {
        $admin = Librarian::factory()->create();
        $user = MemberAuth::factory()->create([
            'librarian_id' => $admin->librarian_id,
            'username' => 'admin_user',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'active',
            'account_type' => 'Administrator',
        ]);

        $response = $this->post(route('staff.login.store'), [
            'login' => 'admin_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user, 'member');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_librarian_can_sign_in_through_staff_login(): void
    {
        $lib = Librarian::factory()->create();
        $user = MemberAuth::factory()->create([
            'librarian_id' => $lib->librarian_id,
            'username' => 'lib_user',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'active',
            'account_type' => 'Librarian',
        ]);

        $response = $this->post(route('staff.login.store'), [
            'login' => 'lib_user',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user, 'member');
        $response->assertRedirect(route('librarian.dashboard'));
    }

    public function test_staff_login_always_uses_the_account_role_dashboard(): void
    {
        $librarian = Librarian::factory()->create();
        $account = MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'role_redirect_librarian',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'Active',
            'account_type' => 'Librarian',
        ]);

        $response = $this->withSession(['url.intended' => route('admin.dashboard')])
            ->post(route('staff.login.store'), [
                'login' => 'role_redirect_librarian',
                'password' => 'password123',
            ]);

        $this->assertAuthenticatedAs($account, 'member');
        $response->assertRedirect(route('librarian.dashboard'));
    }

    public function test_legacy_staff_login_pages_redirect_to_shared_staff_login(): void
    {
        $this->get('/admin/login')->assertRedirect(route('staff.login'));
        $this->get('/librarian/login')->assertRedirect(route('staff.login'));
    }

    public function test_protected_staff_pages_redirect_guests_to_shared_staff_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('staff.login'));
        $this->get(route('librarian.dashboard'))->assertRedirect(route('staff.login'));
    }

    public function test_legacy_staff_form_endpoint_still_authenticates(): void
    {
        $librarian = Librarian::factory()->create();
        $account = MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'legacy_staff',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'Active',
            'account_type' => 'Librarian',
        ]);

        $response = $this->post(route('adminlogin.store'), [
            'login' => 'legacy_staff',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($account, 'member');
        $response->assertRedirect(route('librarian.dashboard'));
    }

    public function test_student_accounts_cannot_use_the_staff_portal(): void
    {
        $member = Member::factory()->create();
        MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'student_user',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'Active',
            'account_type' => 'Member',
        ]);

        $response = $this->post(route('staff.login.store'), [
            'login' => 'student_user',
            'password' => 'password123',
        ]);

        $this->assertGuest('member');
        $response->assertSessionHasErrors('login');
    }

    public function test_user_can_not_authenticate_with_invalid_password(): void
    {
        $member = Member::factory()->create();
        $user = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Member',
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('member');
    }

    public function test_staff_accounts_cannot_use_the_student_portal(): void
    {
        $librarian = Librarian::factory()->create();
        MemberAuth::factory()->create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'staff_user',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'Active',
            'account_type' => 'Librarian',
        ]);

        $response = $this->post('/login', [
            'login' => 'staff_user',
            'password' => 'password123',
        ]);

        $this->assertGuest('member');
        $response->assertSessionHasErrors('login');
    }

    public function test_user_can_not_authenticate_if_inactive(): void
    {
        $member = Member::factory()->create();
        $user = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'inactive',
            'account_type' => 'Member',
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertGuest('member');
        $response->assertSessionHasErrors(['login' => 'Your account is currently unavailable. Please contact the library administrator.']);
    }

    public function test_broken_account_relationship_is_rejected(): void
    {
        // Member account without member_id
        $user = MemberAuth::factory()->create([
            'member_id' => null,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_status' => 'active',
            'account_type' => 'Member',
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertGuest('member');
        $response->assertSessionHasErrors(['login' => 'Your account configuration is invalid. Please contact the library administrator.']);
    }

    public function test_user_can_logout(): void
    {
        $member = Member::factory()->create();
        $user = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Member',
        ]);

        $this->actingAs($user, 'member');

        $response = $this->post('/logout');

        $this->assertGuest('member');
        $response->assertRedirect('/');
    }
}
