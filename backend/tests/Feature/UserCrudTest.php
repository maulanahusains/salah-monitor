<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;
    private function getToken(User $user): string
    {
        $response = $this->post('/api/auth/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        return $response->json('access_token');
    }

    /**
     * Test To Validate Fields
     */

    public function test_fields_must_be_filled(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('/api/user', [], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(400)
            ->assertJsonFragment(['success' => false]);
    }

    public function test_password_minimum_length(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('/api/user', [
            'username' => 'saya_user',
            'password' => 'pass'
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(400)
            ->assertJsonFragment(['success' => false]);
    }

    /**
     * Test To Create Data
     */
    public function test_data_must_created(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('/api/user', [
            'username' => 'saya_user',
            'password' => 'passwordnya'
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true]);
    }

    /**
     * Test To Update Data
     */
    public function test_data_must_updated(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->put('/api/user/' . $user->id, [
            'username' => 'updated_user',
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }

    /**
     * Test To Delete Data
     */
    public function test_data_must_deleted(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->delete('/api/user/' . $user->id, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }
}
