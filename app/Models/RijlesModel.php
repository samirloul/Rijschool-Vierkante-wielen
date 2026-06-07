<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RijlesModel
{
    /**
     * Haal alle rijlessen op via stored procedure.
     * Retourneert een array van objecten met gekoppelde leerling- en instructeurgegevens.
     */
    public static function index(): array
    {
        try {
            $results = DB::select('CALL sp_rijles_index()');
            Log::info('sp_rijles_index aangeroepen', ['aantal' => count($results)]);
            return $results;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijlessen', ['fout' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Haal één rijles op via stored procedure op basis van ID.
     * Retourneert een object of null als de rijles niet bestaat.
     */
    public static function show(int $id): object|null
    {
        try {
            $results = DB::select('CALL sp_rijles_show(?)', [$id]);
            $record = $results[0] ?? null;

            if ($record) {
                Log::info('sp_rijles_show aangeroepen', ['id' => $id]);
            } else {
                Log::warning('sp_rijles_show: rijles niet gevonden', ['id' => $id]);
            }

            return $record;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen rijles', ['id' => $id, 'fout' => $e->getMessage()]);
            return null;
        }
    }
}
