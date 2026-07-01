<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_code_redirects_and_increments_hits(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->for($company)->create(['role' => 'Member']);
        $url = Url::factory()->create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'original_url' => 'https://google.com',
            'short_code' => 'abc123',
            'hits' => 0,
        ]);

        $this->get('/abc123')->assertRedirect('https://google.com');
        $this->assertEquals(1, $url->fresh()->hits);
    }

    public function test_invalid_short_code_returns_404(): void
    {
        $this->get('/nonexistent')->assertNotFound();
    }
}