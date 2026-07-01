<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Url;
use App\Services\UrlService;

class RedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct(private readonly UrlService $urlService) {}

    public function redirect(string $shortCode): RedirectResponse
    {
        $url = Url::where('short_code', $shortCode)->firstOrFail();

        $this->urlService->registerHit($url);

        return redirect()->away($url->original_url);
    }
}
