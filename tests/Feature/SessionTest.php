<?php

namespace Tests\Feature;

use App\Models\SessionTravail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_sessions_requires_authentication()
    {
        $response = $this->get('/sessions');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_sessions_index()
    {
        $user = User::factory()->create(['statut' => 'valide']);
        $response = $this->actingAs($user)->get('/sessions');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_session()
    {
        $user = User::factory()->create(['role' => 'admin', 'statut' => 'valide']);
        $response = $this->actingAs($user)->post('/sessions', [
            'numero' => '2024-001',
            'date' => '2024-12-01',
            'lieu' => 'Salle du conseil',
            'statut' => 'planifiee',
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('sessions_travail', ['numero' => '2024-001']);
    }
}
