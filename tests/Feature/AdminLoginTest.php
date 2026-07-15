<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $normalUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an Admin user (email is admin@admin.com to satisfy isAdmin())
        $this->adminUser = User::create([
            'name' => 'Admin User',
            'lname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Create a normal user
        $this->normalUser = User::create([
            'name' => 'Normal User',
            'lname' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);
    }

    /**
     * Guest can view the admin login form.
     */
    public function testGuestCanViewAdminLoginForm()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Administration Portal');
        $response->assertSee('Authenticate Admin');
    }

    /**
     * Valid admin login succeeds and redirects to laws index.
     */
    public function testValidAdminLoginSucceeds()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/laws');
        $this->assertAuthenticatedAs($this->adminUser);
    }

    /**
     * Normal user is rejected from logging in via the admin portal.
     */
    public function testNormalUserRejectedFromAdminPortal()
    {
        $response = $this->post('/admin/login', [
            'email' => 'user@user.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Incorrect credentials fail login.
     */
    public function testIncorrectCredentialsFail()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
