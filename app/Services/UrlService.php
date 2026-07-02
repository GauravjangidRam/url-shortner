<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Str;

class UrlService
{
    public function generateShortCode()
    {
        do {
            $shortCode = Str::random(6);
        } while (Url::where('short_code', $shortCode)->exists());

        return $shortCode;
    }
    public function registerHit(Url $url)
{
    $url->increment('hits');
}
}
