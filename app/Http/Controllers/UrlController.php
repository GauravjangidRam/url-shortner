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



    public function export(Request $request)
    {
        $user = auth()->user();
        $query = Url::query();

        $filter = $request->filter;
        if ($filter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($filter === 'last_week') {
            $query->whereBetween('created_at', [now()->subWeek(), now()]);
        } elseif ($filter === 'last_month') {
            $query->whereMonth('created_at', now()->subMonth()->month);
        } elseif ($filter === 'this_month') {
            $query->whereMonth('created_at', now()->month);
        }

        if ($user->role === 'SuperAdmin') {
            $urls = $query->with('company')->latest()->get();
        } elseif ($user->role === 'Admin') {
            $urls = $query->where('company_id', $user->company_id)->latest()->get();
        } else {
            $urls = $query->where('user_id', $user->id)->latest()->get();
        }

        $filename = "urls_export_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function() use ($urls) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Short URL', 'Original URL', 'Hits', 'Created At']);
            foreach ($urls as $url) {
                fputcsv($handle, [
                    url('/' . $url->short_code),
                    $url->original_url,
                    $url->hits,
                    $url->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
