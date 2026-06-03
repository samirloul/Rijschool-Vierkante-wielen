<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeerlingController extends Controller
{
    public function index()
    {
        $defaultConnection = DB::getDefaultConnection();

        if ($defaultConnection === 'sqlite') {
            $leerlingen = collect(
                DB::table('Leerling as l')
                    ->join('Gebruiker as g', 'g.Id', '=', 'l.GebruikerId')
                    ->join('Rijbewijscategorie as rc', 'rc.Id', '=', 'l.RijbewijscategorieId')
                    ->where('g.IsActief', 1)
                    ->orderBy('g.Achternaam')
                    ->orderBy('g.Voornaam')
                    ->select(
                        'l.Id AS LeerlingId',
                        'g.Id AS GebruikerId',
                        'g.Voornaam',
                        'g.Tussenvoegsel',
                        'g.Achternaam',
                        'g.Email',
                        'g.Telefoonnummer',
                        'rc.Naam AS RijbewijsCategorie',
                        'l.HeeftBeperking',
                        'l.OmschrijvingBeperking',
                        'l.IsActief'
                    )
                    ->get()
            )->map(function ($row) {
                $row->VolledigeNaam = trim($row->Voornaam . ' ' . ($row->Tussenvoegsel ? $row->Tussenvoegsel . ' ' : '') . $row->Achternaam);
                return $row;
            });
        } else {
            $leerlingen = collect(DB::select('CALL sp_get_leerlingen()'));
        }

        $count = $leerlingen->count();
        if ($count > 0) {
            Log::info("[Leerlingen] {$count} leerlingen succesvol geladen");
        } else {
            Log::warning('[Leerlingen] Geen leerlingen gevonden');
        }

        $error = null;
        if ($leerlingen->isEmpty()) {
            $error = 'Geen leerlingen gevonden';
        }

        return view('Leerling.index', compact('leerlingen', 'error'));
    }
}
