<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex mb-3 gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                        <a href="{{ route('companies.create') }}" class="btn btn-primary">Add Company</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr><th>ID</th><th>Name</th></tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $c)
                            <tr><td>{{ $c->id }}</td><td>{{ $c->name }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
