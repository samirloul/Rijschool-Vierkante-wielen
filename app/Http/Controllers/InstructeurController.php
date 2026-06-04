<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class InstructeurController extends Controller
{
    public function index()
    {
        $error = null;

        try {
            // Roep de stored procedure aan om instructeurs op te halen
            $instructeurs = collect(DB::select('CALL sp_get_instructeurs()'));

            // Log het aantal geladen instructeurs
            $count = $instructeurs->count();
            if ($count > 0) {
                Log::info("[Instructeurs] {$count} instructeurs succesvol geladen");
            } else {
                Log::warning('[Instructeurs] Geen instructeurs gevonden');
            }
        } catch (Exception $e) {
            // Log de error
            Log::error('[Instructeurs] Fout bij laden van instructeurs: ' . $e->getMessage());

            // Toon in de view een lege lijst in plaats van technische foutmelding.
            $instructeurs = collect();
            $error = null;
        }

        return view('Instructeur.index', compact('instructeurs', 'error'));
    }
}
