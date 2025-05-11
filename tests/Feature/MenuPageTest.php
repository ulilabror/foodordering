<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the menu page loads successfully.
     */
    public function test_menu_page_loads_successfully(): void
    {
        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertViewIs('landing.menu');
    }

    /**
     * Test if categories are displayed on the menu page.
     */
    public function test_categories_are_displayed_on_menu_page(): void
    {
        // Create sample categories
        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);

        // Assert that each category name is visible on the page
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }

    /**
     * Test if menus are displayed under the correct categories.
     */
    public function test_menus_are_displayed_under_correct_categories(): void
    {
        // Create a category with menus
        $category = Category::factory()->create();
        $menus = Menu::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);

        // Assert that the category name is visible
        $response->assertSee($category->name);

        // Assert that each menu item is visible under the category
        foreach ($menus as $menu) {
            $response->assertSee($menu->name);
            $response->assertSee(number_format($menu->price, 2));
            $response->assertSee($menu->description);
        }
    }

    /**
     * Test if the menu page handles categories without menus.
     */
    public function test_menu_page_handles_empty_categories(): void
    {
        // Create a category without menus
        $category = Category::factory()->create();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);

        // Assert that the category name is visible
        $response->assertSee($category->name);

        // Assert that no menu items are displayed
        $response->assertDontSee('menu-item');
    }
}