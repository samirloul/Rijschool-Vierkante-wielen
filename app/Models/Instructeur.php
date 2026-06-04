<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Instructeur extends Model
{
    use HasFactory;

    // Databasetabel en primary key
    protected $table = 'Instructeur';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    // Velden die ingevuld mogen worden
    protected $fillable = [
        'GebruikerId',
        'Rijbewijsnummer',
        'IndienstDatum',
        'IsActief',
        'Opmerkingen',
    ];

    // Type conversie voor velden
    protected $casts = [
        'IsActief' => 'boolean',
    ];

    // Relatie naar User model
    public function gebruiker()
    {
        return $this->belongsTo(User::class, 'GebruikerId', 'Id');
    }
}
