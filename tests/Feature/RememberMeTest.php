<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RememberMeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that logging in with the remember option sets the remember cookie.
     */
    public function testLoginWithRememberMeSetsCookie()
    {
        // 1. Create a user
        $user = User::create([
            'name' => 'John',
            'lname' => 'Doe',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->email_verified_at = now();
        $user->save();

        // 2. Post to login route with remember checkbox set to 'on'
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => 'on',
        ]);

        // 3. Assert successful redirection
        $response->assertRedirect('/');

        // 4. Assert user is logged in
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());

        // 5. Assert the remember cookie is set in the response
        $cookieName = Auth::guard()->getRecallerName();
        $response->assertCookie($cookieName);

        // 6. Assert remember token is generated in the database for the user
        $user->refresh();
        $this->assertNotEmpty($user->remember_token);
    }

    /**
     * Test that user is automatically logged in using the remember me cookie
     * even when the session cookie is absent (simulating a closed browser).
     */
    public function testRememberMeCookieAuthenticatesUser()
    {
        // 1. Create a user
        $user = User::create([
            'name' => 'John',
            'lname' => 'Doe',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->email_verified_at = now();
        $user->save();

        // 2. Login with remember option
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => 'on',
        ]);

        // 3. Extract the remember cookie value from the response
        $cookieName = Auth::guard()->getRecallerName();
        $rememberCookie = $response->headers->getCookies();
        
        $rememberValue = null;
        foreach ($rememberCookie as $cookie) {
            if ($cookie->getName() === $cookieName) {
                $rememberValue = $cookie->getValue();
                break;
            }
        }

        $this->assertNotNull($rememberValue, "Remember cookie was not found in response.");

        // 4. Decrypt the value and strip the cookie prefix (HMAC|...) added by Laravel's cookie system
        $decryptedValueWithPrefix = decrypt($rememberValue, false);
        $parts = explode('|', $decryptedValueWithPrefix, 2);
        $rawRecallerValue = $parts[1]; // Get the actual 'id|token|hash' segment

        // 5. Simulate browser close (clear session and forget user, but do NOT logout which invalidates the token)
        Auth::guard()->forgetUser();
        $this->flushSession();
        $this->assertFalse(Auth::check());

        // 6. Make a request passing the raw recaller cookie value
        $response2 = $this->withCookie($cookieName, $rawRecallerValue)
                           ->get('/accounts/dashboard');

        // 7. Verify that the user was successfully authenticated via the remember cookie
        $this->assertTrue(Auth::check(), "User was not automatically logged in using the remember me cookie.");
        $this->assertEquals($user->id, Auth::id());
        $response2->assertStatus(200);
    }
}
