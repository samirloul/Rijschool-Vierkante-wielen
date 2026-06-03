<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeerlingController extends Controller
{
    public function index()
    {
        // Roep de stored procedure aan om leerlingen op te halen
        $leerlingen = collect(DB::select('CALL sp_get_leerlingen()'));

        // Log het aantal geladen leerlingen
        $count = $leerlingen->count();
        if ($count > 0) {
            Log::info("[Leerlingen] {$count} leerlingen succesvol geladen");
        } else {
            Log::warning('[Leerlingen] Geen leerlingen gevonden');
        }

        // Zet error bericht als er geen leerlingen zijn
        $error = null;
        if ($leerlingen->isEmpty()) {
            $error = 'Geen leerlingen gevonden';
        }

        return view('Leerling.index', compact('leerlingen', 'error'));
    }
}
