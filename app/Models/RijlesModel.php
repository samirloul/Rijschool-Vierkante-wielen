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

    /**
     * Sla een nieuwe rijles op via stored procedure.
**/
    public static function store(
        int $leerlingId,
        int $instructeurId,
        int $voertuigId,
        string $datumTijd,
        int $duurMinuten,
        int $ophaaladresId
    ): int {
        $pdo  = DB::getPdo();
        $stmt = $pdo->prepare('CALL sp_rijles_store(?, ?, ?, ?, ?, ?)');
        $stmt->execute([$leerlingId, $instructeurId, $voertuigId, $datumTijd, $duurMinuten, $ophaaladresId]);

        $nieuwId = null;
        do {
            $row = $stmt->fetch(\PDO::FETCH_OBJ);
            if ($row && isset($row->NieuwId)) {
                $nieuwId = (int) $row->NieuwId;
                break;
            }
        } while ($stmt->nextRowset());

        if (!$nieuwId) {
            throw new \RuntimeException('sp_rijles_store retourneerde geen geldig ID.');
        }

        Log::info('sp_rijles_store aangeroepen', ['nieuw_id' => $nieuwId]);
        return $nieuwId;
    }
}