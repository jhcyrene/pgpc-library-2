<?php

namespace Tests\Feature\Auth;

use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_students_can_register(): void
    {
        $response = $this->post('/register', [
            'student_id_number' => '04-99999',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'program' => 'BSIT',
            'year_level' => '1st Year',
            'username' => 'testuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('members', [
            'student_id_number' => '04-99999',
            'email' => 'test@example.com',
        ]);
        
        $member = Member::where('student_id_number', '04-99999')->first();
        $this->assertDatabaseHas('member_auth', [
            'member_id' => $member->member_id,
            'username' => 'testuser',
            'account_type' => 'Member',
            'account_status' => 'Active',
        ]);

        $auth = MemberAuth::where('username', 'testuser')->first();
        $this->assertTrue(Hash::check('password123', $auth->password_hash));
    }

    public function test_registration_fails_if_passwords_do_not_match(): void
    {
        $response = $this->post('/register', [
            'student_id_number' => '04-99999',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'program' => 'BSIT',
            'year_level' => '1st Year',
            'username' => 'testuser',
            'password' => 'password123',
            'password_confirmation' => 'password456',
            'terms' => '1',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('members', ['student_id_number' => '04-99999']);
    }

    public function test_registration_fails_if_student_id_is_duplicate(): void
    {
        Member::factory()->create(['student_id_number' => '04-12345']);

        $response = $this->post('/register', [
            'student_id_number' => '04-12345',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test2@example.com',
            'program' => 'BSIT',
            'year_level' => '1st Year',
            'username' => 'testuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
        ]);

        $response->assertSessionHasErrors('student_id_number');
    }

    public function test_registration_requires_terms_acceptance(): void
    {
        $response = $this->post('/register', [
            'student_id_number' => '04-88888',
            'first_name' => 'Test',
            'last_name' => 'Student',
            'email' => 'terms@example.com',
            'program' => 'BSIT',
            'year_level' => '1st Year',
            'username' => 'termsuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('terms');
        $this->assertDatabaseMissing('members', [
            'student_id_number' => '04-88888',
        ]);
    }
}
