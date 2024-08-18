<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MonitorCrudTest extends TestCase
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

    public function test_data_must_created(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $response = $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [1, 2],
            'total_rakaat' => 4,
            'total_gagal' => 2,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true])
            ->assertDatabaseHas('monitors', [
                'nama_monitor' => 'Shalat Dhuha',
                'total_gagal' => 2,
                'total_rakaat' => 4,
                'tanggal_monitor' => date('Y-m-d'),
            ]);
    }

    public function test_data_must_upadated(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [1, 2],
            'total_gagal' => 2,
            'total_rakaat' => 4,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response = $this->put('api/monitor/1', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [1, 2],
            'total_rakaat' => 4,
            'total_gagal' => 5,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertDatabaseHas('monitors', [
                'nama_monitor' => 'Shalat Dhuha',
                'total_gagal' => 5,
                'total_rakaat' => 4,
                'tanggal_monitor' => date('Y-m-d'),
            ]);
    }

    public function test_data_must_deleted(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [1, 2],
            'total_rakaat' => 4,
            'total_gagal' => 2,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response = $this->delete('api/monitor/1', [
            'Authoriztion' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }
}
