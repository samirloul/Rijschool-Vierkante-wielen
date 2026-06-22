<?php

namespace App\Http\Controllers;

use App\Models\Lespakket;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Deze controller is verantwoordelijk voor het tonen van het overzicht van rijlespakketten.

class RijlespakkettenOverzichtController extends Controller
{
    public function index()
    {
        try {
            $lespakketten = Lespakket::overzicht();
        } catch (QueryException $exception) {
            report($exception);

            return view('pages.packages', [
                'lespakketten' => [],
                'lespakkettenOverzichtError' => 'Rijlespakketten overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en tabel Lespakket bestaan.',
            ]);
        }

        return view('pages.packages', [
            'lespakketten' => $lespakketten,
            'lespakkettenOverzichtError' => null,
        ]);
    }

    public function dashboardIndex()
    {
        try {
            $lespakketten = Lespakket::overzicht();
        } catch (QueryException $exception) {
            report($exception);

            return view('pages.dashboard-lespakketten-overzicht', [
                'lespakketten' => [],
                'lespakkettenOverzichtError' => 'Rijlespakketten overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en tabel Lespakket bestaan.',
            ]);
        }

        return view('pages.dashboard-lespakketten-overzicht', [
            'lespakketten' => $lespakketten,
            'lespakkettenOverzichtError' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    { // Deze methode verwerkt het formulier voor het toevoegen van een nieuw rijlespakket. --- IGNORE ---
        $validated = $request->validate(
            [// Valideer de invoer van het formulier. We verwachten een pakketnummer, naam, aantal lessen, prijs en een optionele omschrijving. Als de validatie faalt, worden de fouten automatisch teruggestuurd naar de view en weergegeven aan de gebruiker.
                'pakket_nummer' => ['required', 'integer', 'min:1'],
                'naam' => ['required', 'string', 'max:60'],
                'aantal_lessen' => ['required', 'integer', 'min:1', 'max:999'],
                'prijs' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
                'omschrijving' => ['nullable', 'string', 'max:250'],
            ],// Aangepaste foutmeldingen voor de validatie. Deze worden weergegeven als de validatie faalt.
            [
                'pakket_nummer.required' => 'Nummer is verplicht.',
                'pakket_nummer.integer' => 'Nummer moet een geheel getal zijn.',
                'pakket_nummer.min' => 'Nummer moet minimaal 1 zijn.',
                'naam.required' => 'Naam is verplicht.',
                'aantal_lessen.required' => 'Aantal lessen is verplicht.',
                'prijs.required' => 'Prijs is verplicht.',
            ]
        );

        $pakketNummer = (int) $validated['pakket_nummer'];// We casten het pakketnummer naar een integer, omdat we in de validatie al hebben gecontroleerd dat het een geldig geheel getal is. Dit zorgt ervoor dat we altijd met een integer werken in de rest van de methode, wat belangrijk is voor de database-insert en eventuele verdere logica die afhankelijk is van het pakketnummer als een integer.

        if (Lespakket::bestaatNummer($pakketNummer)) {// Controleer of het opgegeven pakketnummer al in gebruik is. Als dat het geval is, stuur de gebruiker terug naar het formulier met een foutmelding dat het nummer al in gebruik is.
            return redirect()
                ->route('dashboard.packages')// Stuur de gebruiker terug naar het overzicht van rijlespakketten in het dashboard.
                ->withInput()
                ->withErrors([
                    'pakket_nummer' => 'Nummer is al in gebruik',// Toon een foutmelding dat het nummer al in gebruik is.
                ]);
        }

        if (Lespakket::bestaatDubbeleGegevens(// Controleer of er al een rijlespakket bestaat met dezelfde naam, aantal lessen, prijs en omschrijving. Als dat het geval is, stuur de gebruiker terug naar het formulier met een foutmelding dat deze pakketgegevens al bestaan.
            $validated['naam'],
            (int) $validated['aantal_lessen'],// We casten het aantal lessen naar een integer, omdat we in de validatie al hebben gecontroleerd dat het een geldig geheel getal is. Dit zorgt ervoor dat we altijd met een integer werken in de rest van de methode, wat belangrijk is voor de database-insert en eventuele verdere logica die afhankelijk is van het aantal lessen als een integer.
            (float) $validated['prijs'],
            $validated['omschrijving'] ?? null
        )) {
            return redirect()//
                ->route('dashboard.packages')
                ->withInput()// Stuur de gebruiker terug naar het overzicht van rijlespakketten in het dashboard.
                ->withErrors([
                    'naam' => 'Deze pakketgegevens bestaan al en kunnen niet opnieuw worden toegevoegd.',
                ]);
        }

        try {
            Lespakket::toevoegenViaStoredProcedure(
                $pakketNummer,// We gebruiken het opgegeven pakketnummer dat we eerder hebben gevalideerd en gecontroleerd op dubbele nummers.
                $validated['naam'],
                (int) $validated['aantal_lessen'],
                (float) $validated['prijs'],
                $validated['omschrijving'] ?? null// We gebruiken null coalescing operator om ervoor te zorgen dat als er geen omschrijving is opgegeven, we null doorgeven aan de stored procedure, wat overeenkomt met de database-definitie van de Omschrijving-kolom die nullable is.
            );

            Log::info('Rijlespakket succesvol toegevoegd', [
                'pakket_nummer' => $pakketNummer,
                'naam' => $validated['naam'],// We loggen de naam van het pakket in plaats van de prijs en aantal lessen, omdat deze informatie nuttiger is voor het identificeren van het toegevoegde pakket in de logs, terwijl de prijs en aantal lessen minder relevant zijn voor logging doeleinden.
                'aantal_lessen' => (int) $validated['aantal_lessen'],
                'prijs' => (float) $validated['prijs'],
            ]);

            return redirect()
                ->route('dashboard.packages')// Stuur de gebruiker terug naar het overzicht van rijlespakketten in het dashboard.
                ->with('status', 'Rijlespakketten succesvol toegevoegd');
        } catch (QueryException $exception) {
            Log::error('Fout bij toevoegen rijlespakket via stored procedure', [
                'pakket_nummer' => $pakketNummer,
                'exception' => $exception->getMessage(),// We loggen de foutmelding van de exception om inzicht te krijgen in wat er mis is gegaan bij het toevoegen van het rijlespakket via de stored procedure. Dit kan helpen bij het debuggen en oplossen van eventuele problemen met de database of de stored procedure zelf.
            ]);

            $melding = str_contains(strtolower($exception->getMessage()), 'nummer is al in gebruik')
                ? 'Nummer is al in gebruik'
                : 'Rijlespakket kon niet worden toegevoegd. Probeer het opnieuw.';

            $dubbeleGegevens = str_contains(strtolower($exception->getMessage()), 'dezelfde gegevens');
// We controleren of de foutmelding van de exception aangeeft dat er al een pakket bestaat met dezelfde gegevens. Als dat het geval is, willen we een specifieke foutmelding tonen dat deze pakketgegevens al bestaan, in plaats van een algemene foutmelding over het niet kunnen toevoegen van het rijlespakket.
            return redirect()
                ->route('dashboard.packages')
                ->withInput()
                ->withErrors([
                    $dubbeleGegevens ? 'naam' : 'pakket_nummer' => $dubbeleGegevens
                        ? 'Deze pakketgegevens bestaan al en kunnen niet opnieuw worden toegevoegd.'
                        : $melding,
                ]);
        }
    }
}
