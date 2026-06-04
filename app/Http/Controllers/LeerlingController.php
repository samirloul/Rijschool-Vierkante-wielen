<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class LeerlingController extends Controller
{
    public function index()
    {
        $error = null;

        try {
            // Roep de stored procedure aan om leerlingen op te halen
            $leerlingen = collect(DB::select('CALL sp_get_leerlingen()'));

            // Log het aantal geladen leerlingen
            $count = $leerlingen->count();
            if ($count > 0) {
                Log::info("[Leerlingen] {$count} leerlingen succesvol geladen");
            } else {
                Log::warning('[Leerlingen] Geen leerlingen gevonden');
            }
        } catch (Exception $e) {
            // Log de error
            Log::error('[Leerlingen] Fout bij laden van leerlingen: ' . $e->getMessage());

            // Toon in de view een lege lijst in plaats van technische foutmelding.
            $leerlingen = collect();
            $error = null;
        }

        return view('Leerling.index', compact('leerlingen', 'error'));
    }
}
