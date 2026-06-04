<?php

namespace App\Http\Controllers;

use App\Models\Betaling;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BetalingOverzichtController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'vanaf' => ['nullable', 'date'],
            'tot' => ['nullable', 'date', 'after_or_equal:vanaf'],
        ]);

        $vanaf = $validated['vanaf'] ?? null;
        $tot = $validated['tot'] ?? null;

        try {
            $betalingen = Betaling::overzicht($vanaf, $tot);
        } catch (QueryException $exception) {
            report($exception);

            return view('pages.betalingoverzicht', [
                'betalingen' => [],
                'vanaf' => $vanaf,
                'tot' => $tot,
                'betalingOverzichtError' => 'Betaling overzicht kon niet worden geladen. Controleer of de database Vierkante_Wielen en stored procedure sp_betaling_overzicht bestaan.',
            ]);
        }

        return view('pages.betalingoverzicht', [
            'betalingen' => $betalingen,
            'vanaf' => $vanaf,
            'tot' => $tot,
            'betalingOverzichtError' => null,
        ]);
    }
}
