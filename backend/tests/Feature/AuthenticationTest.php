<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
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
     * Test that a user can log in.
     */
    public function test_user_should_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertJsonStructure(['access_token']);
    }

    /**
     * Test that a user's password can be reset.
     */
    public function test_user_password_should_resetted(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('/api/auth/reset-password', [
            'old_password' => 'password',
            'new_password' => 'new_pass'
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true])
            ->assertJsonStructure(['access_token']);
    }

    /**
     * Test that a user can't login when the password is incorrect.
     */
    public function test_user_should_not_login_when_password_is_incorrect(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'username' => $user->username,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment(['success' => false]);
    }

    /**
     * Test that a user can't login when the username is incorrect.
     */
    public function test_user_should_not_login_when_username_is_incorrect(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'username' => 'wrong_username',
            'password' => 'password',
        ]);
        $response->assertStatus(401)
            ->assertJsonFragment(['success' => false]);
    }

    /**
     * Test that a user can log out.
     */
    public function test_user_should_logged_out(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->get('/api/auth/logout', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }
}
