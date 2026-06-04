<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Betaling extends Model
{
    protected $table = 'Betaling';

    public $timestamps = false;

    /**
     * @return array<int, object>
     */
    public static function overzicht(?string $vanaf, ?string $tot): array
    {
        return DB::select('CALL sp_betaling_overzicht(?, ?)', [
            $vanaf,
            $tot,
        ]);
    }
}
