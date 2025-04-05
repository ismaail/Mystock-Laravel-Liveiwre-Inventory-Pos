<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unauthenticated_users_cant_access_admin_dashboard()
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    #[Test]
    public function not_authorized_users_cant_access_admin_dashboard()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_access_admin_dashboard()
    {
        $this->loginAsAdmin();

        $this->get('/admin')->assertOk();
    }
}
