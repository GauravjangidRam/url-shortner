<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisibilityScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_sees_all_urls(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin', 'company_id' => $companyA->id]);

        Url::factory()->count(3)->create(['company_id' => $companyA->id]);
        Url::factory()->count(2)->create(['company_id' => $companyB->id]);

        $this->actingAs($superAdmin)
            ->get('/urls')
            ->assertOk();

        $this->assertCount(5, Url::visibleTo($superAdmin)->get());
    }

    public function test_admin_sees_only_own_company_urls(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'Admin', 'company_id' => $companyA->id]);

        Url::factory()->count(3)->create(['company_id' => $companyA->id]);
        Url::factory()->count(2)->create(['company_id' => $companyB->id]);

        $this->assertCount(3, Url::visibleTo($admin)->get());
    }

    public function test_member_sees_only_own_urls(): void
    {
        $company = Company::factory()->create();
        $member = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);
        $otherMember = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);

        Url::factory()->count(2)->create(['company_id' => $company->id, 'user_id' => $member->id]);
        Url::factory()->count(4)->create(['company_id' => $company->id, 'user_id' => $otherMember->id]);

        $this->assertCount(2, Url::visibleTo($member)->get());
    }
}