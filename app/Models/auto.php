<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class auto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Voertuig';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Merk',
        'Type',
        'Kenteken',
        'Bouwjaar',
        'IsElektrisch',
        'IsActief',
        'Opmerkingen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the transmission type based on IsElektrisch flag.
     *
     * @return string
     */
    public function getTransmissie(): string
    {
        return $this->IsElektrisch ? 'Automatisch (elektrisch)' : 'Handgeschakeld';
    }

    /**
     * Get the availability status.
     *
     * @return string
     */
    public function getBeschikbaarheid(): string
    {
        return $this->IsActief ? 'Beschikbaar' : 'Niet beschikbaar';
    }
}

