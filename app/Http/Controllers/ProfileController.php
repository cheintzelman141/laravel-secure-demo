<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $user->update($request->all()); // <-- bug
        return redirect()->route('profile.edit')->with('status', 'Updated');
    }
}

