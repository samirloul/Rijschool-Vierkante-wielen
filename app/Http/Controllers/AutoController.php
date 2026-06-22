<?php

namespace App\Http\Controllers;

use App\Models\auto;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

/**
 * AutoController handles all vehicle/auto related operations
 * Responsible for displaying available vehicles to end-users
 *
 * @package App\Http\Controllers
 */
class AutoController extends Controller
{
    /**
     * Display a listing of all available vehicles.
     *
     * Retrieves all active vehicles from the Voertuig table with a LEFT JOIN
     * to the Rijles table to show how many lessons each vehicle has been used for.
     * This demonstrates the use of database JOINs in the application layer.
     *
     * Exception Handling:
     * - Catches any database errors and logs them for debugging
     * - Returns error message to user instead of crashing
     * - Maintains user experience during failures
     *
     * @return View Rendered view with vehicle data or error message
     */
    public function overzicht(): View
    {
        try {
            /**
             * Query vehicles with Rijles JOIN to demonstrate JOIN usage.
             * LEFT JOIN shows all vehicles even if they have no lessons scheduled.
             * GROUP BY ensures we get one row per vehicle.
             */
            $autos = DB::table('Voertuig')
                ->leftJoin('Rijles', 'Voertuig.Id', '=', 'Rijles.VoertuigId')
                ->where('Voertuig.IsActief', 1)
                ->groupBy(
                    'Voertuig.Id',
                    'Voertuig.Merk',
                    'Voertuig.Type',
                    'Voertuig.Kenteken',
                    'Voertuig.Bouwjaar',
                    'Voertuig.IsElektrisch',
                    'Voertuig.IsActief',
                    'Voertuig.Opmerkingen',
                    'Voertuig.DatumAangemaakt',
                    'Voertuig.DatumGewijzigd'
                )
                ->select(
                    'Voertuig.Id',
                    'Voertuig.Merk',
                    'Voertuig.Type',
                    'Voertuig.Kenteken',
                    'Voertuig.Bouwjaar',
                    'Voertuig.IsElektrisch',
                    'Voertuig.IsActief',
                    'Voertuig.Opmerkingen',
                    DB::raw('COUNT(Rijles.Id) as AantalRijlessen')
                )
                ->orderBy('Voertuig.Merk')
                ->orderBy('Voertuig.Type')
                ->get();

            /**
             * Log successful retrieval for debugging and monitoring purposes.
             * PSR-12: Proper logging at info level for successful operations.
             */
            \Log::info('Voertuigen opgehaald met Rijles JOIN', [
                'count' => $autos->count(),
                'data' => $autos,
            ]);

            return view('autos.overzicht', [
                'autos' => $autos,
            ]);
        } catch (\Exception $exception) {
            /**
             * Exception Handler: PSR-12 compliant error handling
             * Log the complete error trace for debugging
             * Return user-friendly error message to prevent data exposure
             */
            \Log::error('Fout bij ophalen van voertuigen overzicht met JOIN', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            /**
             * Return view with empty collection and user-friendly error message
             * Prevents application crash and provides graceful degradation
             */
            return view('autos.overzicht', [
                'autos' => collect(),
                'error' => 'Er is een fout opgetreden bij het ophalen van de voertuigen. Probeer het later opnieuw.',
            ]);
        }
    }
}

