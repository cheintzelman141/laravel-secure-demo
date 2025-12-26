<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoAuthController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [DemoAuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [DemoAuthController::class, 'login'])->name('login.do');
Route::get('/logout', [DemoAuthController::class, 'logout'])->name('logout');

Route::middleware('demo.auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/admin', function (\Illuminate\Http\Request $request) {
        $user = $request->attributes->get('demo_user');
        abort_unless($user->role === 'admin', 403);
        return "✅ Admin access granted for {$user->email}";
    })->name('admin');
});
