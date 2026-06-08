<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lespakket extends Model
{
    protected $table = 'Lespakket';
    // De timestamps worden niet automatisch beheerd door Eloquent, omdat de tabel Lespakket geen created_at en updated_at kolommen heeft.
    public $timestamps = false;
    // De fillable property is leeg, omdat we geen mass assignment toestaan voor dit model. We zullen alleen specifieke methoden gebruiken om gegevens op te halen, zoals de overzicht methode die de stored procedure aanroept.

    /**
     * @return array<int, object>
     * // Deze methode haalt een overzicht van actieve rijlespakketten op uit de database. We selecteren alleen de benodigde kolommen en sorteren de resultaten op aantal lessen en naam. Als er een fout optreedt (bijvoorbeeld als de database of tabel niet bestaat), zal er een exception worden gegooid die kan worden afgehandeld in de controller.
     */
    public static function overzicht(): array
    {
        return DB::table('Lespakket')
        // We selecteren alleen de benodigde kolommen voor het overzicht van rijlespakketten. We filteren op actieve lespakketten en sorteren eerst op aantal lessen en daarna op naam.
            ->select([
                'Id',
                'Naam',
                'AantalLessen',
                'Prijs',
                'Omschrijving',
            ])
            ->where('IsActief', 1)
            ->orderBy('AantalLessen')
            ->orderBy('Naam')
            // We gebruiken get() om de resultaten op te halen als een collectie van objecten, en vervolgens all() om deze te converteren naar een array van objecten die kan worden gebruikt in de controller en view.
            ->get()
            ->all();
    }
}
