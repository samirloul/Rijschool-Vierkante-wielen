DROP PROCEDURE IF EXISTS sp_get_instructeurs;
DELIMITER //
CREATE PROCEDURE sp_get_instructeurs()
BEGIN
    SELECT
         i.Id AS InstructeurId
        ,g.Id AS GebruikerId
        ,CONCAT(g.Voornaam, IFNULL(CONCAT(' ', g.Tussenvoegsel), ''), ' ', g.Achternaam) AS VolledigeNaam
        ,g.Email
        ,g.Telefoonnummer
        ,i.Rijbewijsnummer
        ,i.IndienstDatum
        ,i.Opmerkingen
        ,i.IsActief
    FROM Instructeur AS i
    JOIN Gebruiker AS g ON g.Id = i.GebruikerId
    WHERE g.IsActief = 1
    ORDER BY g.Achternaam, g.Voornaam;
END //
DELIMITER ;