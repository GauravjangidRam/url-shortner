<x-app-layout>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(auth()->user()->role === 'SuperAdmin')
        <!-- SUPER ADMIN VIEW -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header py-3">
                <span class="text-primary fw-bold">Clients</span>
                <a href="{{ route('companies.create') }}" class="btn btn-outline-primary btn-sm px-4">Invite</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-muted fw-normal">Client Name</th>
                            <th class="text-muted fw-normal">Users</th>
                            <th class="text-muted fw-normal">Total Generated URLs</th>
                            <th class="text-muted fw-normal text-end pe-4">Total URL Hits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies ?? [] as $company)
                        <tr>
                            <td class="ps-4 py-3">{{ $company->name }}</td>
                            <td class="py-3">{{ $company->users_count }}</td>
                            <td class="py-3">--</td>
                            <td class="text-end pe-4 py-3">--</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No clients found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex align-items-center text-muted small">
                    Showing clients
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->role === 'Admin')
        <!-- ADMIN VIEW (TEAM MEMBERS) -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header py-3">
                <span class="text-primary fw-bold">Team Members</span>
                <a href="{{ route('members.create') }}" class="btn btn-outline-primary btn-sm px-4">Invite</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 text-muted fw-normal">Name</th>
                            <th class="text-muted fw-normal">Email</th>
                            <th class="text-muted fw-normal">Role</th>
                            <th class="text-muted fw-normal">Total Generated URLs</th>
                            <th class="text-muted fw-normal text-end pe-4">Total URL Hits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members ?? [] as $member)
                        <tr>
                            <td class="ps-4 py-3">{{ $member->name }}</td>
                            <td class="py-3">{{ $member->email }}</td>
                            <td class="py-3">{{ $member->role }}</td>
                            <td class="py-3">--</td>
                            <td class="text-end pe-4 py-3">--</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No team members found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ALL ROLES GET GENERATED URLS -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header py-3">
            <span class="text-primary fw-bold">Generated Short URLs</span>
            <div class="d-flex gap-2">
                @if(auth()->user()->role !== 'SuperAdmin')
                    <a href="{{ route('urls.create') }}" class="btn btn-outline-primary btn-sm px-4">Generate</a>
                @endif
                <form action="{{ route('dashboard') }}" method="GET" class="mb-0 d-inline-block">
                    <select name="filter" onchange="this.form.submit()" class="form-select form-select-sm w-auto d-inline-block text-primary border-primary">
                        <option value="">All Time</option>
                        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="this_month" {{ request('filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                    </select>
                </form>
                <a href="{{ route('urls.export', ['filter' => request('filter')]) }}" class="btn btn-primary btn-sm px-4">Download</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 text-muted fw-normal">Short URL</th>
                        <th class="text-muted fw-normal">Long URL</th>
                        <th class="text-muted fw-normal">Hits</th>
                        <th class="text-muted fw-normal text-end pe-4">Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($urls ?? [] as $url)
                    <tr>
                        <td class="ps-4 py-3">
                            <a href="{{ route('redirect', $url->short_code) }}" target="_blank" class="text-decoration-none">
                                {{ url('/' . $url->short_code) }}
                            </a>
                        </td>
                        <td class="py-3 text-truncate" style="max-width: 300px;">{{ $url->original_url }}</td>
                        <td class="py-3">{{ $url->hits }}</td>
                        <td class="text-end pe-4 py-3 text-muted">{{ $url->created_at->format('d M y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No generated URLs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                @if(isset($urls) && $urls->hasPages())
                    {{ $urls->links('pagination::bootstrap-5') }}
                @else
                    <span class="text-muted small">Showing URLs</span>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
