<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lespakket extends Model
{
    protected $table = 'Lespakket';

    public $timestamps = false;

    /**
     * @return array<int, object>
     */
    public static function overzicht(): array
    {
        return DB::table('Lespakket')
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
            ->get()
            ->all();
    }
}
