<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generated Short URLs</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('urls.create') }}" class="btn btn-primary">Generate Short URL</a>
                        <button class="btn btn-outline-primary">Download</button>
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Short URL</th>
                                <th>Long URL</th>
                                <th>Hits</th>
                                <th>Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urls as $url)
                            <tr>
                                <td><a href="{{ route('redirect', $url->short_code) }}" target="_blank">{{ url('/' . $url->short_code) }}</a></td>
                                <td>{{ Str::limit($url->original_url, 40) }}</td>
                                <td>{{ $url->hits }}</td>
                                <td>{{ $url->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $urls->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
