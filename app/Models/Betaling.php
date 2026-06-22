<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Betaling extends Model
{
    protected $table = 'Betaling';
    // De timestamps worden niet automatisch beheerd door Eloquent, omdat de tabel Betaling geen created_at en updated_at kolommen heeft.

    public $timestamps = false;
    // De fillable property is leeg, omdat we geen mass assignment toestaan voor dit model. We zullen alleen specifieke methoden gebruiken om gegevens op te halen, zoals de overzicht methode die de stored procedure aanroept.

    /**
     * @return array<int, object>
     */
    public static function overzicht(?string $vanaf, ?string $tot): array
    // Deze methode roept de stored procedure sp_betaling_overzicht aan om een overzicht van betalingen op te halen binnen de opgegeven datums. Als er geen datums zijn opgegeven, zal het overzicht voor alle datums worden getoond.
    {
        return DB::select('CALL sp_betaling_overzicht(?, ?)', [
            // De datums worden doorgegeven aan de stored procedure. Als er geen datums zijn opgegeven, zullen deze null zijn, wat betekent dat het overzicht voor alle datums zal worden getoond.
            $vanaf,
            // De datums worden doorgegeven aan de stored procedure. Als er geen datums zijn opgegeven, zullen deze null zijn, wat betekent dat het overzicht voor alle datums zal worden getoond.
            $tot,
        ]);
    }

    /**
     * @return array<int, object>
     */
    public static function factuurOpties(): array
    {
        return DB::table('Factuur')
            ->join('Leerling', 'Leerling.Id', '=', 'Factuur.LeerlingId')
            ->join('Gebruiker', 'Gebruiker.Id', '=', 'Leerling.GebruikerId')
            ->select([
                'Factuur.Id',
                'Factuur.Factuurnummer',
                'Factuur.Factuurdatum',
                'Factuur.Vervaldatum',
                DB::raw("CONCAT(Gebruiker.Voornaam, ' ', IFNULL(Gebruiker.Tussenvoegsel, ''), ' ', Gebruiker.Achternaam) AS LeerlingNaam"),
            ])
            ->where('Factuur.IsActief', 1)
            ->orderBy('Factuur.Factuurdatum', 'desc')
            ->get()
            ->all();
    }

    public static function bestaatVoorLeerlingEnPeriode(int $factuurId, string $betaaldatum): bool
    {
        $leerlingId = DB::table('Factuur')
            ->where('Id', $factuurId)
            ->value('LeerlingId');

        if (! $leerlingId) {
            return false;
        }

        return DB::table('Betaling')
            ->join('Factuur', 'Factuur.Id', '=', 'Betaling.FactuurId')
            ->where('Betaling.IsActief', 1)
            ->where('Factuur.LeerlingId', (int) $leerlingId)
            ->whereYear('Betaling.Betaaldatum', date('Y', strtotime($betaaldatum)))
            ->whereMonth('Betaling.Betaaldatum', date('m', strtotime($betaaldatum)))
            ->exists();
    }

    public static function toevoegenViaStoredProcedure(
        int $factuurId,
        float $bedrag,
        string $betaaldatum,
        string $betaalmethode,
        ?string $referentie
    ): void {
        DB::statement(
            'CALL sp_betaling_toevoegen(?, ?, ?, ?, ?)',
            [
                $factuurId,
                $bedrag,
                $betaaldatum,
                $betaalmethode,
                $referentie,
            ]
        );
    }
}
