<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class DemoAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->session()->get('demo_user_id');
        if (!$userId) {
            return redirect()->route('login.form');
        }

        $user = User::find($userId);
        if (!$user) {
            $request->session()->forget('demo_user_id');
            return redirect()->route('login.form');
        }

        // Attach user to request for convenience
        $request->attributes->set('demo_user', $user);

        return $next($request);
    }
}
