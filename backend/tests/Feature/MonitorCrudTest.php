<?php

namespace Tests\Feature;

use App\Models\Jenis;
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

        $jenis1 = Jenis::factory()->create();
        $jenis2 = Jenis::factory()->create();

        $response = $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [$jenis1->id, $jenis2->id],
            'total_rakaat' => 4,
            'total_gagal' => 2,
        ], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['success' => true]);
    }

    public function test_data_must_updated(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $jenis1 = Jenis::factory()->create();
        $jenis2 = Jenis::factory()->create();

        $data = $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [$jenis1->id, $jenis2->id],
            'total_rakaat' => 4,
            'total_gagal' => 2,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response = $this->put('api/monitor/' . $data->json('data')[0]['id'], [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => $jenis1->id,
            'total_rakaat' => 4,
            'total_gagal' => 5,
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }

    public function test_data_must_deleted(): void
    {
        $user = User::factory()->create();
        $token = $this->getToken($user);

        $jenis1 = Jenis::factory()->create();
        $jenis2 = Jenis::factory()->create();

        $data = $this->post('api/monitor', [
            'nama_monitor' => 'Shalat Dhuha',
            'tanggal_monitor' => date('Y-m-d'),
            'jenis_id' => [$jenis1->id, $jenis2->id],
            'total_rakaat' => 4,
            'total_gagal' => 2,
        ], [
            'Authoriztion' => "Bearer $token"
        ]);

        $response = $this->delete('api/monitor/' . $data->json('data')[0]['id'], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['success' => true]);
    }
}
