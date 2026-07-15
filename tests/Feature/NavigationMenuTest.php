<?php

namespace Tests\Feature;

use App\User;
use App\NavigationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationMenuTest extends TestCase
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
     * Guests cannot access navigation menus CRUD operations.
     */
    public function testGuestsCannotAccessNavigationMenusCrud()
    {
        $response = $this->get('/admin/navigation-menus');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/navigation-menus/create');
        $response->assertRedirect('/login');
    }

    /**
     * Non-admin users cannot access navigation menus CRUD operations.
     */
    public function testNonAdminsCannotAccessNavigationMenusCrud()
    {
        $response = $this->actingAs($this->normalUser)->get('/admin/navigation-menus');
        $response->assertStatus(403);

        $response = $this->actingAs($this->normalUser)->get('/admin/navigation-menus/create');
        $response->assertStatus(403);
    }

    /**
     * Admin users can access the index page.
     */
    public function testAdminCanAccessNavigationMenusIndex()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/navigation-menus');
        $response->assertStatus(200);
        $response->assertSee('Header Navigation Menus');
    }

    /**
     * Admin can create a new menu item.
     */
    public function testAdminCanCreateMenu()
    {
        $postData = [
            'title' => 'Test Custom Link',
            'link_type' => 'url',
            'url' => '/custom-path',
            'order' => 10,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/navigation-menus', $postData);

        $response->assertRedirect('/admin/navigation-menus');
        $this->assertDatabaseHas('navigation_menus', [
            'title' => 'Test Custom Link',
            'url' => '/custom-path',
            'order' => 10,
            'is_active' => true,
        ]);
    }

    /**
     * Admin can create a custom content dynamic page.
     */
    public function testAdminCanCreateCustomPageMenu()
    {
        $postData = [
            'title' => 'Terms of Service',
            'link_type' => 'content',
            'custom_content' => '<h1>Terms of Service</h1><p>Our terms are simple...</p>',
            'order' => 5,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/admin/navigation-menus', $postData);

        $response->assertRedirect('/admin/navigation-menus');
        $this->assertDatabaseHas('navigation_menus', [
            'title' => 'Terms of Service',
            'slug' => 'terms-of-service',
            'custom_content' => '<h1>Terms of Service</h1><p>Our terms are simple...</p>',
            'is_active' => true,
        ]);
    }

    /**
     * Admin can update an existing menu item.
     */
    public function testAdminCanUpdateMenu()
    {
        $menu = NavigationMenu::create([
            'title' => 'Old Title',
            'url' => '/old-url',
            'order' => 1,
            'is_active' => true,
        ]);

        $updateData = [
            'title' => 'New Updated Title',
            'link_type' => 'url',
            'url' => '/new-url',
            'order' => 2,
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put("/admin/navigation-menus/{$menu->id}", $updateData);

        $response->assertRedirect('/admin/navigation-menus');
        $this->assertDatabaseHas('navigation_menus', [
            'id' => $menu->id,
            'title' => 'New Updated Title',
            'url' => '/new-url',
            'order' => 2,
        ]);
    }

    /**
     * Admin can delete a menu item.
     */
    public function testAdminCanDeleteMenu()
    {
        $menu = NavigationMenu::create([
            'title' => 'Delete Me',
            'url' => '/delete',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/admin/navigation-menus/{$menu->id}");

        $response->assertRedirect('/admin/navigation-menus');
        $this->assertDatabaseMissing('navigation_menus', [
            'id' => $menu->id,
        ]);
    }

    /**
     * Guest can view custom dynamic page.
     */
    public function testDynamicPageRendersCorrectly()
    {
        $menu = NavigationMenu::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'custom_content' => '<h1>Privacy Policy</h1><p>We value your privacy.</p>',
            'is_active' => true,
        ]);

        $response = $this->get('/page/privacy-policy');
        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('We value your privacy.');
    }

    /**
     * Inactive menus are hidden from public.
     */
    public function testInactiveMenusAreHidden()
    {
        $menu = NavigationMenu::create([
            'title' => 'Secret Menu',
            'url' => '/secret',
            'is_active' => false,
        ]);

        // Load homepage and assert it does not show Secret Menu
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Secret Menu');

        // Dynamic page endpoint should return 404 for inactive page
        $page = NavigationMenu::create([
            'title' => 'Secret Page',
            'slug' => 'secret-page',
            'custom_content' => 'Secret content',
            'is_active' => false,
        ]);

        $response = $this->get('/page/secret-page');
        $response->assertStatus(404);
    }
}
