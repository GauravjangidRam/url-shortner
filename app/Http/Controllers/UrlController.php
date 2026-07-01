<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Http\Requests\StoreUrlRequest;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $urls = Url::visibleTo($request->user())->latest()->paginate(15);
        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        return view('urls.create');
    }

    public function store(StoreUrlRequest $request, \App\Services\UrlService $urlService)
    {
        $url = Url::create([
            'original_url' => $request->original_url,
            'short_code' => $urlService->generateShortCode(),
            'company_id' => $request->user()->company_id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('urls.index')->with('success', 'URL created successfully.');
    }

    public function show(Url $url)
    {
        //
    }

    public function edit(Url $url)
    {
        //
    }

    public function update(Request $request, Url $url)
    {
        //
    }

    public function destroy(Url $url)
    {
        $url->delete();
        return redirect()->route('urls.index')->with('success', 'URL deleted.');
    }
}
