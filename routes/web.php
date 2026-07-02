<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;

Route::redirect('/', '/login');

Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invitations/accept/{token}', [InvitationController::class, 'register'])->name('invitations.register');

Route::get('/dashboard', function () {
    $user = auth()->user();
    $data = [];
    
    $query = \App\Models\Url::query();
    
    $filter = request('filter');
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
        $data['companies'] = \App\Models\Company::withCount('users')->get();
        $data['urls'] = (clone $query)->with('company')->latest()->paginate(10);
    } elseif ($user->role === 'Admin') {
        $data['urls'] = (clone $query)->where('company_id', $user->company_id)->latest()->paginate(10);
        $data['members'] = \App\Models\User::where('company_id', $user->company_id)
            ->withCount('urls')
            ->withSum('urls', 'hits')
            ->get();
        $data['pendingInvitations'] = \App\Models\Invitation::where('company_id', $user->company_id)
            ->whereNull('accepted_at')
            ->latest()
            ->get();
    } else {
        $data['urls'] = (clone $query)->where('user_id', $user->id)->latest()->paginate(10);
    }
    $data['urls']->appends(['filter' => $filter]);
    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/urls/export', [\App\Http\Controllers\UrlController::class, 'export'])->name('urls.export')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index')->middleware('role:SuperAdmin');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create')->middleware('role:SuperAdmin');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')->middleware('role:SuperAdmin');
    
    Route::get('/members/create', [InvitationController::class, 'create'])->name('members.create')->middleware('role:Admin');
    Route::post('/members', [InvitationController::class, 'store'])->name('members.store')->middleware('role:Admin');

    Route::get('/urls', [\App\Http\Controllers\UrlController::class, 'index'])->name('urls.index')->middleware('role:Admin,Member,SuperAdmin');
    Route::get('/urls/create', [\App\Http\Controllers\UrlController::class, 'create'])->name('urls.create')->middleware('role:Admin,Member');
    Route::post('/urls', [\App\Http\Controllers\UrlController::class, 'store'])->name('urls.store')->middleware('role:Admin,Member');
});

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('/reset-password-direct', function () {
        return view('auth.reset-password-direct');
    })->name('password.reset.direct');

    Route::post('/reset-password-direct', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'Password has been reset successfully. You can now login.');
    })->name('password.update.direct');
});


Route::get('/{shortCode}', [App\Http\Controllers\RedirectController::class, 'redirect'])
->name('redirect');


