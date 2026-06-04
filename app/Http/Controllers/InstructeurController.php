<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class InstructeurController extends Controller
{
    public function index()
    {
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

            // Zet error bericht als er geen instructeurs zijn
            $error = null;
            if ($instructeurs->isEmpty()) {
                $error = 'Geen instructeurs gevonden';
            }
        } catch (Exception $e) {
            // Log de error
            Log::error('[Instructeurs] Fout bij laden van instructeurs: ' . $e->getMessage());
            
            // Zet lege collectie en error bericht
            $instructeurs = collect();
            $error = 'Er is een fout opgetreden bij het laden van instructeurs';
        }

        return view('Instructeur.index', compact('instructeurs', 'error'));
    }
}
