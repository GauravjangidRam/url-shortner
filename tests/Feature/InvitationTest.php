<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_create_company_with_admin_invite(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);

        $this->actingAs($superAdmin)->post('/companies', [
            'name' => 'Acme Inc',
            'admin_email' => 'admin@acme.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('companies', ['name' => 'Acme Inc']);
        $this->assertDatabaseHas('invitations', ['email' => 'admin@acme.com', 'role' => 'Admin']);
    }

    public function test_admin_can_invite_member_in_own_company(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'Admin', 'company_id' => $company->id]);

        $this->actingAs($admin)->post('/members', [
            'email' => 'member@acme.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('invitations', [
            'email' => 'member@acme.com',
            'role' => 'Member',
            'company_id' => $company->id,
        ]);
    }

    public function test_member_cannot_invite(): void
    {
        $member = User::factory()->create(['role' => 'Member']);

        $this->actingAs($member)->post('/members', [
            'email' => 'x@acme.com',
        ])->assertForbidden();
    }
}