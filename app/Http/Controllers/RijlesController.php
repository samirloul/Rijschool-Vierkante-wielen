<?php

namespace App\Http\Controllers;

use App\Models\RijlesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RijlesController extends Controller
{
    /**
     * Toon een overzicht van alle rijlessen.
     */
    public function index()
    {
        try {
            $rijlessen = RijlesModel::index();

            if (empty($rijlessen)) {
                Log::warning('Geen rijlessen gevonden in de database.');
                return view('rijlessen.index', ['rijlessen' => []])
                    ->with('warning', 'Er zijn momenteel geen rijlessen beschikbaar.');
            }

            return view('rijlessen.index', compact('rijlessen'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijlesoverzicht', ['fout' => $e->getMessage()]);

            return view('rijlessen.index', ['rijlessen' => []])
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de rijlessen. Probeer het later opnieuw.');
        }
    }

    /**
     * Toon de detailpagina van één rijles.
     */
    public function show(int $id)
    {
        try {
            $rijles = RijlesModel::show($id);

            if (!$rijles) {
                Log::warning('Rijles niet gevonden', ['id' => $id]);
                abort(404, 'De opgevraagde rijles bestaat niet.');
            }

            return view('rijlessen.show', compact('rijles'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijles detail', ['id' => $id, 'fout' => $e->getMessage()]);

            return redirect()->route('rijlessen.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de rijles. Probeer het later opnieuw.');
        }
    }

    /**
     * Toon het formulier voor het toevoegen van een nieuwe rijles.
     */
    public function create()
    {
        $leerlingen   = DB::select(
            'SELECT l.Id, CONCAT(
                g.Voornaam,
                IF(g.Tussenvoegsel IS NOT NULL, CONCAT(\' \', g.Tussenvoegsel, \' \'), \' \'),
                g.Achternaam
            ) AS Naam
            FROM Leerling l
            INNER JOIN Gebruiker g ON g.Id = l.GebruikerId
            WHERE l.IsActief = 1
            ORDER BY g.Achternaam, g.Voornaam'
        );

        $instructeurs = DB::select(
            'SELECT i.Id, CONCAT(
                g.Voornaam,
                IF(g.Tussenvoegsel IS NOT NULL, CONCAT(\' \', g.Tussenvoegsel, \' \'), \' \'),
                g.Achternaam
            ) AS Naam
            FROM Instructeur i
            INNER JOIN Gebruiker g ON g.Id = i.GebruikerId
            WHERE i.IsActief = 1
            ORDER BY g.Achternaam, g.Voornaam'
        );

        $voertuigen = DB::select(
            'SELECT Id, CONCAT(Merk, \' \', Type, \' (\', Kenteken, \')\') AS Naam
             FROM Voertuig WHERE IsActief = 1 ORDER BY Merk, Type'
        );

        return view('rijlessen.create', compact('leerlingen', 'instructeurs', 'voertuigen'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'leerling_id'       => ['required', 'integer'],
            'voertuig_id'       => ['required', 'integer'],
            'instructeur_id'    => ['required', 'integer'],
            'datum_tijd'        => ['required', 'date', 'after:now'],
            'duur_minuten'      => ['required', 'integer', 'min:30', 'max:240'],
            'ophaal_straat'     => ['required', 'string', 'max:60'],
            'ophaal_huisnummer' => ['required', 'string', 'max:10'],
            'ophaal_postcode'   => ['required', 'string', 'max:10'],
            'ophaal_stad'       => ['required', 'string', 'max:40'],
        ], [
            'leerling_id.required'       => 'Selecteer een leerling.',
            'voertuig_id.required'       => 'Selecteer een voertuig.',
            'voertuig_id.integer'        => 'De voertuig-selectie is ongeldig.',
            'leerling_id.integer'        => 'De leerling-selectie is ongeldig.',
            'instructeur_id.required'    => 'Selecteer een instructeur.',
            'instructeur_id.integer'     => 'De instructeur-selectie is ongeldig.',
            'datum_tijd.required'        => 'Vul een datum en tijd in.',
            'datum_tijd.date'            => 'De datum en tijd zijn niet geldig.',
            'datum_tijd.after'           => 'Lessen kunnen niet in het verleden plaatsvinden',
            'duur_minuten.required'      => 'Vul een tijdsduur in.',
            'duur_minuten.integer'       => 'De tijdsduur moet een heel getal zijn.',
            'duur_minuten.min'           => 'Een rijles duurt minimaal 30 minuten.',
            'duur_minuten.max'           => 'Een rijles duurt maximaal 240 minuten.',
            'ophaal_straat.required'     => 'Vul een straatnaam in.',
            'ophaal_straat.max'          => 'De straatnaam mag maximaal 60 tekens bevatten.',
            'ophaal_huisnummer.required' => 'Vul een huisnummer in.',
            'ophaal_huisnummer.max'      => 'Het huisnummer mag maximaal 10 tekens bevatten.',
            'ophaal_postcode.required'   => 'Vul een postcode in.',
            'ophaal_postcode.max'        => 'De postcode mag maximaal 10 tekens bevatten.',
            'ophaal_stad.required'       => 'Vul een stad in.',
            'ophaal_stad.max'            => 'De stad mag maximaal 40 tekens bevatten.',
        ]);

        try {
            DB::insert(
                'INSERT INTO Adres (Straat, Huisnummer, Postcode, Stad) VALUES (?, ?, ?, ?)',
                [
                    $validated['ophaal_straat'],
                    $validated['ophaal_huisnummer'],
                    $validated['ophaal_postcode'],
                    $validated['ophaal_stad'],
                ]
            );
            $ophaaladresId = (int) DB::getPdo()->lastInsertId();
            Log::info('Nieuw ophaaladres aangemaakt', ['adres_id' => $ophaaladresId]);

            $nieuwId = RijlesModel::store(
                leerlingId:    (int) $validated['leerling_id'],
                instructeurId: (int) $validated['instructeur_id'],
                voertuigId:    (int) $validated['voertuig_id'],
                datumTijd:     $validated['datum_tijd'],
                duurMinuten:   (int) $validated['duur_minuten'],
                ophaaladresId: $ophaaladresId,
            );

            Log::info('Rijles succesvol toegevoegd', ['id' => $nieuwId]);
            return redirect()->route('rijlessen.index')
                ->with('success', 'Les succesvol toegevoegd');

        } catch (\Exception $e) {
            $foutbericht = $e->getMessage();
            Log::error('Fout bij opslaan rijles', ['fout' => $foutbericht]);

            if (str_contains($foutbericht, 'Lessen kunnen niet in het verleden plaatsvinden')) {
                return back()->withInput()
                    ->withErrors(['datum_tijd' => 'Lessen kunnen niet in het verleden plaatsvinden']);
            }

            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het opslaan van de rijles. Probeer het later opnieuw.');
        }
    }
}