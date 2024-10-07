<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_user()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertStatus(200)
                ->assertJson([
                    'name' => 'User',
                    'email' => 'user@example.com'
                ]);
    }
    public function test_delete_user()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200)
                ->assertSee('User deleted successfully');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }


    public function test_update_user()
{
    $user = User::create([
        'name' => 'Old Name',
        'email' => 'oldemail@example.com',
        'password' => bcrypt('password123'),
    ]);

    $this->actingAs($user);

    $updateData = [
        'name' => 'New Name',
        'email' => 'newemail@example.com',
        'role' => 'user',
    ];

    $response = $this->putJson('/api/users/' . $user->id, $updateData);
    $response->assertStatus(200);
    $response->assertJson([
        'name' => 'New Name',
        'email' => 'newemail@example.com'
    ]);
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
        'email' => 'newemail@example.com'
    ]);
}

}
