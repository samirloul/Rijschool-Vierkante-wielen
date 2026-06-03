<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Leerling extends Model
{
    use HasFactory;

    protected $table = 'Leerling';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'GebruikerId',
        'RijbewijscategorieId',
        'HeeftBeperking',
        'OmschrijvingBeperking',
        'IsActief',
        'Opmerkingen',
    ];

    protected $casts = [
        'HeeftBeperking' => 'boolean',
        'IsActief' => 'boolean',
    ];

    public function gebruiker()
    {
        return $this->belongsTo(User::class, 'GebruikerId', 'Id');
    }
}
