<?php

namespace Tests\Feature;

use App\User;
use App\AdminTwoFactorCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $normalUser;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

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
     * Valid admin credentials initiate 2FA and redirect to verify-2fa screen.
     */
    public function testValidAdminCredentialsInitiatesTwoFactor()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/login/verify-2fa');
        $response->assertSessionHas('admin_2fa_pending');
        $this->assertGuest(); // Not authenticated until 2FA code is verified

        $this->assertDatabaseHas('admin_two_factor_codes', [
            'user_id' => $this->adminUser->id,
            'used' => false,
        ]);
    }

    /**
     * Admin can view the 2FA verification screen when pending.
     */
    public function testAdminCanViewTwoFactorVerificationScreen()
    {
        $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response = $this->get('/admin/login/verify-2fa');
        $response->assertStatus(200);
        $response->assertSee('Two-Factor Authentication');
        $response->assertSee('Verify & Enter Dashboard');
    }

    /**
     * Valid 2FA OTP code authenticates admin and redirects to dashboard.
     */
    public function testValidTwoFactorCodeAuthenticatesAdmin()
    {
        $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $codeRecord = AdminTwoFactorCode::where('user_id', $this->adminUser->id)->latest()->first();

        $response = $this->post('/admin/login/verify-2fa', [
            'code' => $codeRecord->code,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->adminUser);
        $this->assertTrue(session('admin_2fa_verified'));
    }

    /**
     * Invalid 2FA OTP code fails verification.
     */
    public function testInvalidTwoFactorCodeFails()
    {
        $this->post('/admin/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response = $this->post('/admin/login/verify-2fa', [
            'code' => '000000',
        ]);

        $response->assertSessionHasErrors('code');
        $this->assertGuest();
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
