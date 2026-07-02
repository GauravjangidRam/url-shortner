<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function create()
    {
        return view('invitations.create');
    }

    public function store(StoreInvitationRequest $request)
    {
        Invitation::create([
            'email' => $request->email,
            'role' => $request->role,
            'company_id' => $request->user()->company_id,
            'token' => Str::random(32),
        ]);

        return redirect()->route('dashboard')->with('success', 'User invited successfully.');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')->firstOrFail();
        if (User::where('email', $invitation->email)->exists()) {
            $invitation->update(['accepted_at' => now()]);
            return redirect()->route('login')
                ->with('status', 'An account for ' . $invitation->email . ' already exists. Please log in.');
        }
        return view('invitations.accept', compact('invitation'));
    }

    public function register(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if (User::where('email', $invitation->email)->exists()) {
            return redirect()->route('login')
                ->with('status', 'An account for ' . $invitation->email . ' already exists. Please log in.');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'company_id' => $invitation->company_id,
            'role' => $invitation->role,
        ]);

        $invitation->update(['accepted_at' => now()]);

        auth()->login($user);
        return redirect()->route('dashboard')->with('success', 'Account created successfully.');
    }
}
