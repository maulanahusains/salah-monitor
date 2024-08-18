<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class JenisCrudTest extends TestCase
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
     * Test To Create Data
     */
    public function test_data_must_created(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('/api/jenis', [
            'jenis_name' => 'Ruku',
            'poin_per_rakaat' => 4
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true])
            ->assertDatabaseHas('jenis', [
                'jenis_name' => 'Ruku'
            ]);
    }

    /**
     * Test To Update Data
     */
    public function test_data_must_updated(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $jenis = Jenis::create([
            'jenis_name' => 'Ruku',
            'poin_per_rakaat' => 4
        ]);

        $response = $this->put('/api/jenis/' . $jenis->id, [
            'jenis_name' => 'Sujud',
        ], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertDatabaseHas('jenis', [
                'jenis_name' => 'Sujud'
            ]);
    }

    /**
     * Test To Delete Data
     */
    public function test_data_must_deleted(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);
        $jenis = Jenis::create([
            'jenis_name' => 'Ruku',
            'poin_per_rakaat' => 4
        ]);

        $response = $this->delete('/api/jenis/' . $jenis->id, [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }

    public function test_data_must_failed_when_jenis_name_is_same(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        Jenis::create([
            'jenis_name' => 'Ruku',
            'poin_per_rakaat' => 4
        ]);

        $response = $this->post('/api/jenis', [
            'jenis_name' => 'Ruku',
            'poin_per_rakaat' => 4
        ], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(422)
            ->assertJsonFragment(['success' => false]);
    }
}
