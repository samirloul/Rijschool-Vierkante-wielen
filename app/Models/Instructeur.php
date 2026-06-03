<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Instructeur extends Model
{
    use HasFactory;

    protected $table = 'Instructeur';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'GebruikerId',
        'Rijbewijsnummer',
        'IndienstDatum',
        'IsActief',
        'Opmerkingen',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
    ];

    public function gebruiker()
    {
        return $this->belongsTo(User::class, 'GebruikerId', 'Id');
    }
}
