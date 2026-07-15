<?php

namespace Tests\Feature;

use App\User;
use App\SidebarAd;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SidebarAdTest extends TestCase
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

        // Clear existing database seeded records first to prevent duplicates
        SidebarAd::truncate();

        // Seed default slots
        SidebarAd::create([
            'slot_name' => 'slot_1',
            'title' => 'Upper Small Ad',
            'image_path' => 'home_background/2.jpg',
            'target_url' => null,
            'is_active' => true,
        ]);

        SidebarAd::create([
            'slot_name' => 'slot_2',
            'title' => 'Lower Manual Ad',
            'image_path' => 'home_background/sms.jpg',
            'target_url' => 'tel:0503539237',
            'button_text' => 'You are specially invited | Call Us',
            'is_active' => true,
        ]);
    }

    /**
     * Guests cannot access sidebar ads management.
     */
    public function testGuestsCannotAccessSidebarAds()
    {
        $response = $this->get('/admin/sidebar-ads');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/sidebar-ads/1/edit');
        $response->assertRedirect('/login');
    }

    /**
     * Non-admin users cannot access sidebar ads management.
     */
    public function testNonAdminsCannotAccessSidebarAds()
    {
        $response = $this->actingAs($this->normalUser)->get('/admin/sidebar-ads');
        $response->assertStatus(403);

        $response = $this->actingAs($this->normalUser)->get('/admin/sidebar-ads/1/edit');
        $response->assertStatus(403);
    }

    /**
     * Admin can access sidebar ads index page.
     */
    public function testAdminCanAccessSidebarAdsIndex()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/sidebar-ads');
        $response->assertStatus(200);
        $response->assertSee('Sidebar Advertisement Slots');
        $response->assertSee('Upper Small Ad');
        $response->assertSee('Lower Manual Ad');
    }

    /**
     * Admin can edit sidebar ad.
     */
    public function testAdminCanEditSidebarAd()
    {
        $ad = SidebarAd::where('slot_name', 'slot_1')->first();
        $response = $this->actingAs($this->adminUser)->get("/admin/sidebar-ads/{$ad->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Edit Settings');
    }

    /**
     * Admin can update sidebar ad parameters.
     */
    public function testAdminCanUpdateSidebarAd()
    {
        $ad = SidebarAd::where('slot_name', 'slot_1')->first();

        $response = $this->actingAs($this->adminUser)->put("/admin/sidebar-ads/{$ad->id}", [
            'title' => 'New Ad Title',
            'target_url' => 'https://google.com',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/sidebar-ads');
        
        $ad->refresh();
        $this->assertEquals('New Ad Title', $ad->title);
        $this->assertEquals('https://google.com', $ad->target_url);
        $this->assertTrue($ad->is_active);
    }

    /**
     * Admin can hide an advertisement slot.
     */
    public function testAdminCanHideAdSlot()
    {
        $ad = SidebarAd::where('slot_name', 'slot_1')->first();

        $response = $this->actingAs($this->adminUser)->put("/admin/sidebar-ads/{$ad->id}", [
            'title' => 'Hidden Ad',
            // Omit 'is_active' key to simulate unchecked checkbox
        ]);

        $ad->refresh();
        $this->assertFalse($ad->is_active);
    }

    /**
     * Active sidebar ads are shared globally with view context.
     */
    public function testSidebarAdsSharedGlobally()
    {
        $response = $this->get('/');
        $response->assertViewHas('sidebarAds');
        
        $ads = $response->original->getData()['sidebarAds'];
        $this->assertNotNull($ads);
        $this->assertTrue($ads->has('slot_1'));
        $this->assertTrue($ads->has('slot_2'));
    }
}
