<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Company</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Company Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Admin Email (for invitation)</label>
                            <input type="email" name="admin_email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create & Invite</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
