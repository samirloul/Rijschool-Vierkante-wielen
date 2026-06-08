<?php

namespace App\Http\Controllers;

use App\Models\Betaling;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BetalingOverzichtController extends Controller
// Deze controller is verantwoordelijk voor het tonen van het overzicht van betalingen.
{
    public function index(Request $request)
    // Valideer de input van de gebruiker voor de datums.
    {
        $validated = $request->validate([
            'vanaf' => ['nullable', 'date'],
            'tot' => ['nullable', 'date', 'after_or_equal:vanaf'],
        ]);
        // Haal de datums op uit de gevalideerde input. Als er geen datums zijn opgegeven, zullen deze null zijn, wat betekent dat het overzicht voor alle datums zal worden getoond.

        $vanaf = $validated['vanaf'] ?? null;
        $tot = $validated['tot'] ?? null;
        // Probeer het overzicht van betalingen op te halen. Als er een fout optreedt (bijvoorbeeld als de database of stored procedure niet bestaat), log de fout en toon een foutmelding in de view.
        try {
            $betalingen = Betaling::overzicht($vanaf, $tot);
        } catch (QueryException $exception) {
            report($exception);
// Log de fout en toon een foutmelding in de view.
            return view('pages.betalingoverzicht', [
                'betalingen' => [],
                'vanaf' => $vanaf,
                'tot' => $tot,
                // Toon een foutmelding in de view als er een probleem is met het laden van het overzicht.
                'betalingOverzichtError' => 'Betaling overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en stored procedure sp_betaling_overzicht bestaan.',
                // Log de fout voor verdere analyse.
                ]);
        }

        return view('pages.betalingoverzicht', [
            // Als het overzicht succesvol is geladen, toon de betalingen in de view.
            'betalingen' => $betalingen,
            'vanaf' => $vanaf,
            // Toon de geselecteerde datums in de view zodat de gebruiker kan zien welke periode ze hebben geselecteerd.
            'tot' => $tot,
            'betalingOverzichtError' => null,
            // Als er geen fout is, is de foutmelding null en zal deze niet worden weergegeven in de view.
        ]);
    }
}
