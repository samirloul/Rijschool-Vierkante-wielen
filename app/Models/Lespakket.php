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
        // LEFT JOIN met LespakketPerLeerling om per pakket direct het aantal gekoppelde leerlingen mee te geven.
            ->leftJoin('LespakketPerLeerling', function ($join) {
                $join->on('Lespakket.Id', '=', 'LespakketPerLeerling.LespakketId')
                    ->where('LespakketPerLeerling.IsActief', '=', 1);
            })
            ->select([
                'Lespakket.Id',
                'Lespakket.Naam',
                'Lespakket.AantalLessen',
                'Lespakket.Prijs',
                'Lespakket.Omschrijving',
                DB::raw('COUNT(LespakketPerLeerling.Id) AS AantalGekoppeldeLeerlingen'),
            ])
            ->where('Lespakket.IsActief', 1)
            ->groupBy(
                'Lespakket.Id',
                'Lespakket.Naam',
                'Lespakket.AantalLessen',
                'Lespakket.Prijs',
                'Lespakket.Omschrijving'
            )
            ->orderBy('Lespakket.AantalLessen')
            ->orderBy('Lespakket.Naam')
            // We gebruiken get() om de resultaten op te halen als een collectie van objecten, en vervolgens all() om deze te converteren naar een array van objecten die kan worden gebruikt in de controller en view.
            ->get()
            ->all();
    }

    public static function bestaatNummer(int $pakketNummer): bool // Deze methode controleert of er al een rijlespakket bestaat met het opgegeven pakketnummer. We gebruiken de exists() methode om efficiënt te controleren op het bestaan van een record zonder daadwerkelijk de gegevens op te halen.
    {
        return DB::table('Lespakket')
            ->where('Id', $pakketNummer)
            ->exists();
    }// Deze methode controleert of er al een rijlespakket bestaat met dezelfde naam, aantal lessen, prijs en omschrijving. We gebruiken de exists() methode om efficiënt te controleren op het bestaan van een record zonder daadwerkelijk de gegevens op te halen. We vergelijken de naam, aantal lessen, prijs en omschrijving om te bepalen of er al een pakket bestaat met dezelfde gegevens, wat belangrijk is om dubbele pakketten te voorkomen.
    // We gebruiken number_format voor de prijs om ervoor te zorgen dat we een consistente notatie van de prijs hebben bij het vergelijken, aangezien kleine verschillen in decimalen kunnen leiden tot onverwachte resultaten bij het vergelijken van floats. Door de prijs te formatteren naar 2 decimalen, zorgen we ervoor dat we een nauwkeurige vergelijking maken die overeenkomt met hoe prijzen meestal worden opgeslagen en weergegeven.

    public static function bestaatDubbeleGegevens(
        string $naam,
        int $aantalLessen,
        float $prijs,
        ?string $omschrijving
    ): bool {// We gebruiken COALESCE in de whereRaw om ervoor te zorgen dat we null waarden in de Omschrijving-kolom correct vergelijken. Als de omschrijving null is, zullen we deze vergelijken met een lege string, wat overeenkomt met hoe we omgaan met null waarden in de validatie en invoer van het formulier. Dit zorgt ervoor dat we geen dubbele pakketten toestaan die alleen verschillen in het al dan niet hebben van een omschrijving.
        return DB::table('Lespakket')
            ->where('Naam', $naam)
            ->where('AantalLessen', $aantalLessen)
            ->where('Prijs', number_format($prijs, 2, '.', ''))
            ->whereRaw('COALESCE(Omschrijving, "") = ?', [$omschrijving ?? ''])
            ->exists();
    }
// Deze methode voegt een nieuw rijlespakket toe aan de database via een stored procedure. We geven de benodigde parameters door aan de stored procedure, en we vertrouwen erop dat de stored procedure zelf de nodige validatie en foutafhandeling doet. Als er een fout optreedt bij het uitvoeren van de stored procedure, zal er een exception worden gegooid die kan worden afgehandeld in de controller.
    public static function toevoegenViaStoredProcedure(
        int $pakketNummer,
        string $naam,
        int $aantalLessen,
        float $prijs,
        ?string $omschrijving
    ): void {
        DB::statement(// We roepen de stored procedure sp_lespakket_toevoegen aan met de opgegeven parameters. We gebruiken een parameterized query om SQL-injectie te voorkomen en ervoor te zorgen dat de gegevens correct worden doorgegeven aan de stored procedure.
            'CALL sp_lespakket_toevoegen(?, ?, ?, ?, ?)',
            [
                $pakketNummer,
                $naam,
                $aantalLessen,
                $prijs,
                $omschrijving,
            ]
        );
    }
}
