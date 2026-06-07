<?php

namespace App\Http\Controllers;

use App\Models\RijlesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RijlesController extends Controller
{
    /**
     * Toon een overzicht van alle rijlessen.
     * Happy scenario: rijlessen worden opgehaald en weergegeven.
     * Unhappy scenario: lege lijst wordt weergegeven met een melding.
     */
    public function index()
    {
        try {
            $rijlessen = RijlesModel::index();

            // Unhappy scenario: geen rijlessen gevonden
            if (empty($rijlessen)) {
                Log::warning('Geen rijlessen gevonden in de database.');
                return view('rijlessen.index', ['rijlessen' => []])
                    ->with('warning', 'Er zijn momenteel geen rijlessen beschikbaar.');
            }

            // Happy scenario: rijlessen succesvol opgehaald
            return view('rijlessen.index', compact('rijlessen'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijlesoverzicht', ['fout' => $e->getMessage()]);

            return view('rijlessen.index', ['rijlessen' => []])
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de rijlessen. Probeer het later opnieuw.');
        }
    }

    /**
     * Toon de detailpagina van één rijles.
     * Happy scenario: rijles wordt gevonden en weergegeven.
     * Unhappy scenario: rijles bestaat niet, 404 wordt teruggegeven.
     */
    public function show(int $id)
    {
        try {
            $rijles = RijlesModel::show($id);

            // Unhappy scenario: rijles niet gevonden
            if (!$rijles) {
                Log::warning('Rijles niet gevonden', ['id' => $id]);
                abort(404, 'De opgevraagde rijles bestaat niet.');
            }

            // Happy scenario: rijles succesvol gevonden
            return view('rijlessen.show', compact('rijles'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijles detail', ['id' => $id, 'fout' => $e->getMessage()]);

            return redirect()->route('rijlessen.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de rijles. Probeer het later opnieuw.');
        }
    }
}
