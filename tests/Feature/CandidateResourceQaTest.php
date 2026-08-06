<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\User;
use Tests\TestCase;

class CandidateResourceQaTest extends TestCase
{
    public function test_candidate_resource_pages_render_for_authorized_user(): void
    {
        $user = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Administrador', 'RH Corp', 'RH']);
        })->first();

        $this->assertNotNull($user, 'No se encontró un usuario con rol autorizado.');

        $candidate = Candidate::first() ?? Candidate::create([
            'name' => 'QA Candidate',
            'email' => 'qa_candidate_' . uniqid() . '@example.com',
            'status' => 'en_proceso',
            'position_applied' => 'Directivo',
        ]);

        $this->actingAs($user);

        $this->get('/dashboard/candidates')->assertSuccessful();
        $this->get('/dashboard/candidates/' . $candidate->id)->assertSuccessful();
        $this->get('/dashboard/candidates/create')->assertSuccessful();

        // Cada tab de estatus del pipeline debe renderizar sin errores.
        foreach (['en_proceso', 'contratado', 'banco_talento', 'archivado', 'todos'] as $tab) {
            $this->get('/dashboard/candidates?activeTab=' . $tab)->assertSuccessful();
        }
    }
}
