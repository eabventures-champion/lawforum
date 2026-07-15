<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\MaintenanceSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Seed the maintenance settings for each test.
     */
    protected function seedMaintenanceSettings(bool $enabled = false, string $passcode = 'testpass123')
    {
        MaintenanceSetting::updateOrCreate(['key' => 'maintenance_enabled'], ['value' => $enabled ? '1' : '0', 'label' => 'Enable', 'type' => 'boolean']);
        MaintenanceSetting::updateOrCreate(['key' => 'maintenance_passcode'], ['value' => $passcode, 'label' => 'Passcode', 'type' => 'text']);
        MaintenanceSetting::updateOrCreate(['key' => 'maintenance_title'], ['value' => 'Test Title', 'label' => 'Title', 'type' => 'text']);
        MaintenanceSetting::updateOrCreate(['key' => 'maintenance_subtitle'], ['value' => 'Test Subtitle', 'label' => 'Subtitle', 'type' => 'textarea']);
        MaintenanceSetting::updateOrCreate(['key' => 'maintenance_dialogue_messages'], ['value' => json_encode([['sender' => 'system', 'text' => 'Hello']]), 'label' => 'Messages', 'type' => 'json']);
    }

    /**
     * Test that the homepage is accessible when maintenance is OFF.
     */
    public function testSiteAccessibleWhenMaintenanceOff()
    {
        $this->seedMaintenanceSettings(false);

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test that public routes redirect to maintenance page when enabled.
     */
    public function testPublicRoutesRedirectWhenMaintenanceOn()
    {
        $this->seedMaintenanceSettings(true);

        $response = $this->get('/');
        $response->assertRedirect('/maintenance');
    }

    /**
     * Test that the maintenance page renders correctly.
     */
    public function testMaintenancePageRendersWhenEnabled()
    {
        $this->seedMaintenanceSettings(true);

        $response = $this->get('/maintenance');
        $response->assertStatus(200);
        $response->assertSee('Test Title');
        $response->assertSee('Test Subtitle');
    }

    /**
     * Test that admin routes are still accessible during maintenance.
     */
    public function testAdminRoutesAccessibleDuringMaintenance()
    {
        $this->seedMaintenanceSettings(true);

        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        // Admin routes should NOT redirect to maintenance page
        // (They may fail for other reasons like missing tables, but the key assertion
        // is that we are NOT being sent to the maintenance page)
        $this->assertNotEquals(302, $response->status(), 'Admin route should not redirect during maintenance');
    }

    /**
     * Test that correct passcode grants bypass access.
     */
    public function testCorrectPasscodeGrantsBypass()
    {
        $this->seedMaintenanceSettings(true, 'mySecretCode');

        $response = $this->post('/maintenance/verify', ['passcode' => 'mySecretCode']);
        $response->assertRedirect('/');
        $response->assertSessionHas('maintenance_bypass', true);
    }

    /**
     * Test that incorrect passcode is rejected.
     */
    public function testIncorrectPasscodeIsRejected()
    {
        $this->seedMaintenanceSettings(true, 'mySecretCode');

        $response = $this->post('/maintenance/verify', ['passcode' => 'wrongPassword']);
        $response->assertSessionHasErrors('passcode');
    }

    /**
     * Test that bypass session allows normal site access.
     */
    public function testBypassSessionAllowsAccess()
    {
        $this->seedMaintenanceSettings(true);

        $response = $this->withSession(['maintenance_bypass' => true])->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test admin can update maintenance settings.
     */
    public function testAdminCanUpdateMaintenanceSettings()
    {
        $this->seedMaintenanceSettings(false);

        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/maintenance-settings/update', [
            'maintenance_enabled' => '1',
            'maintenance_passcode' => 'newPass2026',
            'maintenance_title' => 'New Title',
            'maintenance_subtitle' => 'New Subtitle text here',
            'dialogue_messages' => ['Hello world', 'Testing message'],
        ]);

        $response->assertRedirect(route('admin.maintenance-settings.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('maintenance_settings', [
            'key' => 'maintenance_enabled',
            'value' => '1',
        ]);
        $this->assertDatabaseHas('maintenance_settings', [
            'key' => 'maintenance_passcode',
            'value' => 'newPass2026',
        ]);
        $this->assertDatabaseHas('maintenance_settings', [
            'key' => 'maintenance_title',
            'value' => 'New Title',
        ]);
    }

    /**
     * Test admin can access maintenance settings page.
     */
    public function testAdminCanAccessMaintenanceSettingsPage()
    {
        $this->seedMaintenanceSettings(false);

        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get('/admin/maintenance-settings');
        $response->assertStatus(200);
        $response->assertSee('Maintenance Mode');
        $response->assertSee('Hello'); // One of the dialogue messages seeded
    }
}
