DROP PROCEDURE IF EXISTS sp_rijles_index;

DELIMITER //

CREATE PROCEDURE sp_rijles_index()
BEGIN
    SELECT
        rl.Id,
        rl.DatumTijd,
        rl.DuurMinuten,
        rl.Lesdoel,
        rl.TeBehandelenOnderwerp,
        rl.Status,
        rl.AnnuleringsReden,

        CONCAT(
            gl.Voornaam,
            IF(gl.Tussenvoegsel IS NOT NULL, CONCAT(' ', gl.Tussenvoegsel, ' '), ' '),
            gl.Achternaam
        ) AS LeerlingNaam,

        CONCAT(
            gi.Voornaam,
            IF(gi.Tussenvoegsel IS NOT NULL, CONCAT(' ', gi.Tussenvoegsel, ' '), ' '),
            gi.Achternaam
        ) AS InstructeurNaam,

        CONCAT(v.Merk, ' ', v.Type) AS VoertuigNaam,
        v.Kenteken,

        CONCAT(a.Straat, ' ', a.Huisnummer, ', ', a.Stad) AS Ophaaladres

    FROM Rijles rl

    INNER JOIN Leerling l  ON l.Id  = rl.LeerlingId
    INNER JOIN Gebruiker gl ON gl.Id = l.GebruikerId

    INNER JOIN Instructeur i  ON i.Id  = rl.InstructeurId
    INNER JOIN Gebruiker gi   ON gi.Id = i.GebruikerId

    LEFT JOIN Voertuig v ON v.Id = rl.VoertuigId

    LEFT JOIN Adres a ON a.Id = rl.OphaaladresId

    WHERE rl.IsActief = 1

    ORDER BY rl.DatumTijd ASC;
END //

DELIMITER ;


DROP PROCEDURE IF EXISTS sp_rijles_show;

DELIMITER //

CREATE PROCEDURE sp_rijles_show(IN p_id INT UNSIGNED)
BEGIN
    SELECT
        rl.Id,
        rl.DatumTijd,
        rl.DuurMinuten,
        rl.Lesdoel,
        rl.TeBehandelenOnderwerp,
        rl.Status,
        rl.AnnuleringsReden,
        rl.Opmerkingen,

        l.Id AS LeerlingId,
        CONCAT(
            gl.Voornaam,
            IF(gl.Tussenvoegsel IS NOT NULL, CONCAT(' ', gl.Tussenvoegsel, ' '), ' '),
            gl.Achternaam
        ) AS LeerlingNaam,
        gl.Email AS LeerlingEmail,
        gl.Telefoonnummer AS LeerlingTelefoon,

        i.Id AS InstructeurId,
        CONCAT(
            gi.Voornaam,
            IF(gi.Tussenvoegsel IS NOT NULL, CONCAT(' ', gi.Tussenvoegsel, ' '), ' '),
            gi.Achternaam
        ) AS InstructeurNaam,
        gi.Email AS InstructeurEmail,

        v.Merk AS VoertuigMerk,
        v.Type AS VoertuigType,
        v.Kenteken,
        v.IsElektrisch,

        a.Straat AS OphaalStraat,
        a.Huisnummer AS OphaalHuisnummer,
        a.Postcode AS OphaalPostcode,
        a.Stad AS OphaalStad

    FROM Rijles rl

    INNER JOIN Leerling l   ON l.Id  = rl.LeerlingId
    INNER JOIN Gebruiker gl ON gl.Id = l.GebruikerId

    INNER JOIN Instructeur i  ON i.Id  = rl.InstructeurId
    INNER JOIN Gebruiker gi   ON gi.Id = i.GebruikerId

    LEFT JOIN Voertuig v ON v.Id = rl.VoertuigId

    LEFT JOIN Adres a ON a.Id = rl.OphaaladresId

    WHERE rl.Id = p_id
      AND rl.IsActief = 1

    LIMIT 1;
END //

DELIMITER ;
