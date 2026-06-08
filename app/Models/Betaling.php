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
}
