<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->attributes->get('demo_user');
        return view('profile.edit', compact('user'));
    }

    // VULNERABLE: Mass assignment privilege escalation via role=admin
    public function update(Request $request)
    {
        $user = $request->attributes->get('demo_user');
        if ($request->has('role')) {
            Log::warning('Mass assignment attempt: role field submitted', [
                'email' => $user->email,
                'submitted_role' => $request->input('role'),
                'ip' => $request->ip(),
            ]);
        }
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);
    
        $user->update($validated); // allowlisted + validated
        return redirect()->route('profile.edit')->with('status', 'Updated');
    }
}

