<?php

namespace App\Http\Controllers;

use App\Models\Lespakket;
use Illuminate\Database\QueryException;
// Deze controller is verantwoordelijk voor het tonen van het overzicht van rijlespakketten.

class RijlespakkettenOverzichtController extends Controller
{
    // Deze methode toont het overzicht van rijlespakketten aan de gebruiker. --- IGNORE ---
    public function index()
    {
        try {
            // Probeer het overzicht van rijlespakketten op te halen. Als er een fout optreedt (bijvoorbeeld als de database of tabel niet bestaat), log de fout en toon een foutmelding in de view.
            $lespakketten = Lespakket::overzicht();
        } catch (QueryException $exception) {
            report($exception);
            // Log de fout en toon een foutmelding in de view.
            return view('pages.packages', [
                'lespakketten' => [],
                // Toon een foutmelding in de view als er een probleem is met het laden van het overzicht.
                'lespakkettenOverzichtError' => 'Rijlespakketten overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en tabel Lespakket bestaan.',
                // Log de fout voor verdere analyse.
                ]);
        }

        return view('pages.packages', [
            // Als het overzicht succesvol is geladen, toon de rijlespakketten in de view.
            'lespakketten' => $lespakketten,
            // Als er geen fout is, is de foutmelding null en zal deze niet worden weergegeven in de view.
            'lespakkettenOverzichtError' => null,
        ]);
    }

    public function dashboardIndex()
    // Deze methode toont het overzicht van rijlespakketten in het dashboard aan de gebruiker. --- IGNORE ---
    {
        try {
            // Probeer het overzicht van rijlespakketten op te halen. Als er een fout optreedt (bijvoorbeeld als de database of tabel niet bestaat), log de fout en toon een foutmelding in de view.
            $lespakketten = Lespakket::overzicht();
        } catch (QueryException $exception) {
            // Log de fout en toon een foutmelding in de view.
            report($exception);
            // Log de fout en toon een foutmelding in de view.
            return view('pages.dashboard-lespakketten-overzicht', [
                'lespakketten' => [],
                'lespakkettenOverzichtError' => 'Rijlespakketten overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en tabel Lespakket bestaan.',
                // Log de fout voor verdere analyse.
                ]);
        }
        // Als het overzicht succesvol is geladen, toon de rijlespakketten in de view.
        return view('pages.dashboard-lespakketten-overzicht', [
            // Als het overzicht succesvol is geladen, toon de rijlespakketten in de view.
            'lespakketten' => $lespakketten,
            // Als er geen fout is, is de foutmelding null en zal deze niet worden weergegeven in de view.
            'lespakkettenOverzichtError' => null,
            ]);
    }
}
