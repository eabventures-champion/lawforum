<?php

namespace Tests\Feature;

use App\User;
use App\HomepageCustomSlide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageCustomSlidesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guests cannot access custom slides CRUD.
     */
    public function testGuestsCannotAccessCustomSlides()
    {
        $response = $this->get('/admin/homepage-custom-slides');
        $response->assertRedirect('/login');
    }

    /**
     * Test non-admin users get 403 on custom slides CRUD.
     */
    public function testNonAdminsCannotAccessCustomSlides()
    {
        $user = User::create([
            'name' => 'Regular',
            'lname' => 'User',
            'email' => 'regular@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/admin/homepage-custom-slides');
        $response->assertStatus(403);
    }

    /**
     * Test admins can view custom slides.
     */
    public function testAdminsCanAccessCustomSlidesIndex()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $slide = HomepageCustomSlide::create([
            'title' => 'Test Custom Slide',
            'subtitle' => 'Subtitle badge',
            'content' => 'Description paragraph',
            'icon' => 'fa-star',
            'order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/homepage-custom-slides');
        $response->assertStatus(200);
        $response->assertSee('Test Custom Slide');
        $response->assertSee('Subtitle badge');
    }

    /**
     * Test admins can create custom slide.
     */
    public function testAdminsCanCreateCustomSlide()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/homepage-custom-slides', [
            'title' => 'New Dynamic Slide',
            'subtitle' => 'New Subtitle',
            'content' => 'Dynamic description content text',
            'icon' => 'fa-rocket',
            'order' => 5,
            'is_published' => '1',
            'is_coming_soon' => '1',
        ]);

        $response->assertRedirect('/admin/homepage-custom-slides');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('homepage_custom_slides', [
            'title' => 'New Dynamic Slide',
            'icon' => 'fa-rocket',
            'order' => 5,
            'is_published' => true,
            'is_coming_soon' => true,
        ]);
    }

    /**
     * Test admins can update custom slide.
     */
    public function testAdminsCanUpdateCustomSlide()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $slide = HomepageCustomSlide::create([
            'title' => 'Initial Title',
            'subtitle' => 'Initial Subtitle',
            'content' => 'Initial Content',
            'icon' => 'fa-star',
            'order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->put("/admin/homepage-custom-slides/{$slide->id}", [
            'title' => 'Updated Title',
            'subtitle' => 'Updated Subtitle',
            'content' => 'Updated Content',
            'icon' => 'fa-globe',
            'order' => 2,
            'is_coming_soon' => '1',
        ]);

        $response->assertRedirect('/admin/homepage-custom-slides');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('homepage_custom_slides', [
            'id' => $slide->id,
            'title' => 'Updated Title',
            'icon' => 'fa-globe',
            'order' => 2,
            'is_published' => false, // unchecked is_published defaults to false
            'is_coming_soon' => true,
        ]);
    }

    /**
     * Test admins can delete custom slide.
     */
    public function testAdminsCanDeleteCustomSlide()
    {
        $admin = User::create([
            'name' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $slide = HomepageCustomSlide::create([
            'title' => 'ToDelete',
            'icon' => 'fa-trash',
            'order' => 1,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/homepage-custom-slides/{$slide->id}");

        $response->assertRedirect('/admin/homepage-custom-slides');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('homepage_custom_slides', [
            'id' => $slide->id,
        ]);
    }
}
