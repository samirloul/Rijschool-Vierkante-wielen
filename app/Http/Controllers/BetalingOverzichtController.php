<?php

namespace App\Http\Controllers;

use App\Models\Betaling;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $factuurOpties = Betaling::factuurOpties();
        } catch (QueryException $exception) {
            report($exception);
// Log de fout en toon een foutmelding in de view.
            return view('pages.betalingoverzicht', [
                'betalingen' => [],
                'factuurOpties' => [],
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
            'factuurOpties' => $factuurOpties,
            'vanaf' => $vanaf,
            // Toon de geselecteerde datums in de view zodat de gebruiker kan zien welke periode ze hebben geselecteerd.
            'tot' => $tot,
            'betalingOverzichtError' => null,
            // Als er geen fout is, is de foutmelding null en zal deze niet worden weergegeven in de view.
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'factuur_id' => ['required', 'integer', 'min:1', 'exists:Factuur,Id'],
                'bedrag' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
                'betaaldatum' => ['required', 'date'],
                'betaalmethode' => ['required', 'in:Ideal,Creditcard,Contant,Overboeking'],
                'referentie' => ['nullable', 'string', 'max:50'],
            ],
            [
                'factuur_id.required' => 'Factuur is verplicht.',
                'factuur_id.exists' => 'Geselecteerde factuur bestaat niet.',
                'bedrag.required' => 'Bedrag is verplicht.',
                'betaaldatum.required' => 'Betaaldatum is verplicht.',
                'betaalmethode.required' => 'Betaalmethode is verplicht.',
            ]
        );

        $factuurId = (int) $validated['factuur_id'];
        $betaaldatum = (string) $validated['betaaldatum'];

        if (Betaling::bestaatVoorLeerlingEnPeriode($factuurId, $betaaldatum)) {
            return redirect()
                ->route('betaling.overzicht')
                ->withInput()
                ->withErrors([
                    'factuur_id' => 'Er bestaat al een betaling voor deze leerling en periode',
                ]);
        }

        try {
            Betaling::toevoegenViaStoredProcedure(
                $factuurId,
                (float) $validated['bedrag'],
                $betaaldatum,
                $validated['betaalmethode'],
                $validated['referentie'] ?? null
            );

            Log::info('Betaling succesvol toegevoegd', [
                'factuur_id' => $factuurId,
                'bedrag' => (float) $validated['bedrag'],
                'betaaldatum' => $betaaldatum,
                'betaalmethode' => $validated['betaalmethode'],
            ]);

            return redirect()
                ->route('betaling.overzicht')
                ->with('status', 'Betaling succesvol toegevoegd');
        } catch (QueryException $exception) {
            Log::error('Fout bij toevoegen betaling via stored procedure', [
                'factuur_id' => $factuurId,
                'exception' => $exception->getMessage(),
            ]);

            $meldingDubbelePeriode = str_contains(
                strtolower($exception->getMessage()),
                'betaling voor deze leerling en periode'
            );

            return redirect()
                ->route('betaling.overzicht')
                ->withInput()
                ->withErrors([
                    $meldingDubbelePeriode ? 'factuur_id' : 'bedrag' => $meldingDubbelePeriode
                        ? 'Er bestaat al een betaling voor deze leerling en periode'
                        : 'Betaling kon niet worden toegevoegd. Probeer het opnieuw.',
                ]);
        }
    }
}
