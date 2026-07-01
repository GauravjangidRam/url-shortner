<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_superadmin_cannot_access_companies(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);

        $this->actingAs($admin)->get('/companies')->assertForbidden();
    }

    public function test_member_cannot_access_member_create(): void
    {
        $member = User::factory()->create(['role' => 'Member']);

        $this->actingAs($member)->get('/members/create')->assertForbidden();
    }

    public function test_superadmin_cannot_create_url(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);

        $this->actingAs($superAdmin)->get('/urls/create')->assertForbidden();
    }
}