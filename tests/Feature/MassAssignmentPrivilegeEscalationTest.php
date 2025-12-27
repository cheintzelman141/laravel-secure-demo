<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MassAssignmentPrivilegeEscalationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_escalate_role_via_profile_update(): void
    {
        // Seed demo users
        $this->seed(\Database\Seeders\DemoUserSeeder::class);

        $user = User::where('email', 'user@example.com')->firstOrFail();

        // Simulate logged-in session for demo auth middleware
        $this->withSession(['demo_user_id' => $user->id]);

        // Attempt role escalation
        $this->patch('/profile', [
            'name' => 'User',
            'email' => 'user@example.com',
            'role' => 'admin',
        ])->assertRedirect('/profile');

        $user->refresh();

        // Ensure role did not change
        $this->assertSame('user', $user->role);
    }

    public function test_non_admin_cannot_access_admin_page(): void
    {
        $this->seed(\Database\Seeders\DemoUserSeeder::class);

        $user = User::where('email', 'user@example.com')->firstOrFail();
        $this->withSession(['demo_user_id' => $user->id]);

        $this->get('/admin')->assertStatus(403);
    }
}
