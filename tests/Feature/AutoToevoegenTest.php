<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AutoToevoegenTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_when_visiting_auto_toevoegen(): void
    {
        $response = $this->get(route('autos.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_auto_toevoegen_fails_with_missing_required_fields(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('autos.store'), [
            'merk' => 'Tesla',
            'model' => '',
            'transmissie' => 'automatisch',
            'beschikbaarheid' => 'beschikbaar',
        ]);

        $response->assertSessionHas('error', 'Vul alle verplichte velden in.');
    }

    public function test_auto_is_successfully_added_via_stored_procedure(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        DB::shouldReceive('statement')
            ->once()
            ->with(
                'CALL sp_VoegAutoToe(?, ?, ?, ?)',
                ['Tesla', 'Model 3', 1, 1]
            )
            ->andReturnTrue();

        $response = $this->post(route('autos.store'), [
            'merk' => 'Tesla',
            'model' => 'Model 3',
            'transmissie' => 'automatisch',
            'beschikbaarheid' => 'beschikbaar',
        ]);

        $response->assertRedirect(route('autos.overzicht'));
        $response->assertSessionHas('success', 'Auto succesvol toegevoegd.');
    }
}
