<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an admin can access the admin panel.
     */
    public function test_admin_can_access_admin_panel(): void
    {
        // Buat pengguna dengan peran admin
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Login sebagai admin
        $response = $this->actingAs($admin)->get('/admin');

        // Pastikan admin dapat mengakses panel admin
        $response->assertStatus(200);
        $response->assertSee('Mie Gacor Admin'); // Pastikan teks tertentu di halaman admin terlihat
    }

    /**
     * Test that a courier cannot access the admin panel.
     */
    public function test_courier_cannot_access_admin_panel(): void
    {
        // Buat pengguna dengan peran courier
        $courier = User::factory()->create([
            'role' => 'courier',
        ]);

        // Login sebagai courier
        $response = $this->actingAs($courier)->get('/admin');

        // Pastikan courier tidak dapat mengakses panel admin
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test that a customer cannot access the admin panel.
     */
    public function test_customer_cannot_access_admin_panel(): void
    {
        // Buat pengguna dengan peran customer
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        // Login sebagai customer
        $response = $this->actingAs($customer)->get('/admin');

        // Pastikan customer tidak dapat mengakses panel admin
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test that a guest cannot access the admin panel.
     */
    public function test_guest_cannot_access_admin_panel(): void
    {
        // Akses panel admin tanpa login
        $response = $this->get('/admin');

        // Pastikan guest diarahkan ke halaman login
        $response->assertRedirect('/admin/login');
    }
}