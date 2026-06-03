<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InstructeurController extends Controller
{
    public function index()
    {
        $defaultConnection = DB::getDefaultConnection();

        if ($defaultConnection === 'sqlite') {
            $instructeurs = collect(
                DB::table('Instructeur as i')
                    ->join('Gebruiker as g', 'g.Id', '=', 'i.GebruikerId')
                    ->where('g.IsActief', 1)
                    ->orderBy('g.Achternaam')
                    ->orderBy('g.Voornaam')
                    ->select(
                        'i.Id AS InstructeurId',
                        'g.Id AS GebruikerId',
                        'g.Voornaam',
                        'g.Tussenvoegsel',
                        'g.Achternaam',
                        'g.Email',
                        'g.Telefoonnummer',
                        'i.Rijbewijsnummer',
                        'i.IndienstDatum',
                        'i.Opmerkingen',
                        'i.IsActief'
                    )
                    ->get()
            )->map(function ($row) {
                $row->VolledigeNaam = trim($row->Voornaam . ' ' . ($row->Tussenvoegsel ? $row->Tussenvoegsel . ' ' : '') . $row->Achternaam);
                return $row;
            });
        } else {
            $instructeurs = collect(DB::select('CALL sp_get_instructeurs()'));
        }

        $count = $instructeurs->count();
        if ($count > 0) {
            Log::info("[Instructeurs] {$count} instructeurs succesvol geladen");
        } else {
            Log::warning('[Instructeurs] Geen instructeurs gevonden');
        }

        $error = null;
        if ($instructeurs->isEmpty()) {
            $error = 'Geen instructeurs gevonden';
        }

        return view('Instructeur.index', compact('instructeurs', 'error'));
    }
}
