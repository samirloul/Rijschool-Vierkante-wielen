<?php

namespace App\Http\Controllers;

use App\Models\Lespakket;
use Illuminate\Database\QueryException;

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
}
