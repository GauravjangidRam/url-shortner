<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generate Short URL</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('urls.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Long URL</label>
                            <input type="url" name="original_url" class="form-control" placeholder="e.g. https://example.com/very/long/url" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
