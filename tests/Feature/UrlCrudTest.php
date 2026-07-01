<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->create(['role' => 'Admin', 'company_id' => $company->id]);

        $this->actingAs($admin)->post('/urls', [
            'original_url' => 'https://example.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://example.com',
            'company_id' => $company->id,
            'user_id' => $admin->id,
        ]);
    }

    public function test_member_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $member = User::factory()->create(['role' => 'Member', 'company_id' => $company->id]);

        $this->actingAs($member)->post('/urls', [
            'original_url' => 'https://laravel.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('urls', ['original_url' => 'https://laravel.com']);
    }

    public function test_original_url_is_required_and_valid(): void
    {
        $member = User::factory()->create(['role' => 'Member']);

        $this->actingAs($member)->post('/urls', [
            'original_url' => 'not-a-url',
        ])->assertSessionHasErrors('original_url');
    }
}