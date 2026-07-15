<?php

namespace Tests\Feature;

use App\User;
use App\HomepageSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Update the seeded record to a custom test value
        HomepageSetting::where('key', 'slide_0_badge')->update([
            'value' => 'Test Badge',
        ]);
    }

    /**
     * Test guests are redirected or aborted.
     */
    public function testGuestsCannotAccessHomepageSettings()
    {
        $response = $this->get('/admin/homepage-settings');
        // Since it has auth middleware, it redirects to login or gets intercepted
        $response->assertRedirect('/login');
    }

    /**
     * Test non-admin users get 403.
     */
    public function testNonAdminsCannotAccessHomepageSettings()
    {
        $user = User::create([
            'name' => 'Regular',
            'lname' => 'User',
            'email' => 'regular@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/admin/homepage-settings');
        $response->assertStatus(403);
    }

    /**
     * Test admins can view settings.
     */
    public function testAdminsCanAccessHomepageSettings()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com', // Recognized as admin
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get('/admin/homepage-settings');
        $response->assertStatus(200);
        $response->assertSee('Homepage Slider Settings');
        $response->assertSee('Test Badge');
    }

    /**
     * Test admins can update settings.
     */
    public function testAdminsCanUpdateHomepageSettings()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/homepage-settings/update', [
            'settings' => [
                'slide_0_published' => '1',
                'slide_0_badge' => 'Updated Badge Text',
            ]
        ]);

        $response->assertRedirect('/admin/homepage-settings');
        $response->assertSessionHas('success');

        // Check database values updated
        $this->assertEquals('1', HomepageSetting::where('key', 'slide_0_published')->first()->value);
        $this->assertEquals('Updated Badge Text', HomepageSetting::where('key', 'slide_0_badge')->first()->value);
    }
}
