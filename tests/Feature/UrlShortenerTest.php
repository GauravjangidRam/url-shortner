<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_member_can_create_short_urls(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'Admin', 'company_id' => $company->id]);
        $member = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);

        $this->actingAs($admin)
            ->post('/urls', ['original_url' => 'https://example.com/admin'])
            ->assertRedirect(route('urls.index'));

        $this->actingAs($member)
            ->post('/urls', ['original_url' => 'https://example.com/member'])
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', ['original_url' => 'https://example.com/admin']);
        $this->assertDatabaseHas('urls', ['original_url' => 'https://example.com/member']);
    }

    public function test_superadmin_cannot_create_short_urls(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);

        $response = $this->actingAs($superAdmin)
            ->post('/urls', ['original_url' => 'https://example.com/super']);

        $response->assertForbidden(); // Assuming RoleMiddleware throws 403. Let's check middleware later.
    }

    public function test_superadmin_can_see_all_urls(): void
    {
        $superAdmin = User::factory()->create(['role' => 'SuperAdmin']);
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        Url::factory()->create(['company_id' => $company1->id]);
        Url::factory()->create(['company_id' => $company2->id]);

        $response = $this->actingAs($superAdmin)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewHas('urls', function ($urls) {
            return $urls->total() === 2;
        });
    }

    public function test_admin_can_only_see_own_company_urls(): void
    {
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'Admin', 'company_id' => $company1->id]);
        
        Url::factory()->create(['company_id' => $company1->id]);
        Url::factory()->create(['company_id' => $company2->id]);

        $response = $this->actingAs($admin)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewHas('urls', function ($urls) {
            return $urls->total() === 1;
        });
    }

    public function test_member_can_only_see_own_urls(): void
    {
        $company = Company::factory()->create();
        $member1 = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);
        $member2 = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);
        
        Url::factory()->create(['user_id' => $member1->id, 'company_id' => $company->id]);
        Url::factory()->create(['user_id' => $member2->id, 'company_id' => $company->id]);

        $response = $this->actingAs($member1)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewHas('urls', function ($urls) {
            return $urls->total() === 1;
        });
    }

    public function test_short_urls_are_publicly_resolvable_and_redirect(): void
    {
        $company = Company::factory()->create();
        $url = Url::factory()->create([
            'company_id' => $company->id,
            'original_url' => 'https://example.com/target',
            'short_code' => 'abcdef',
            'hits' => 0
        ]);

        $response = $this->get('/abcdef');
        
        $response->assertRedirect('https://example.com/target');
        
        // Assert hit count increased
        $this->assertEquals(1, $url->fresh()->hits);
    }
}
