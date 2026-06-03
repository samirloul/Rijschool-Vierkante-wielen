DROP PROCEDURE IF EXISTS sp_get_leerlingen;
DELIMITER //
CREATE PROCEDURE sp_get_leerlingen()
BEGIN
    SELECT
         l.Id AS LeerlingId
        ,g.Id AS GebruikerId
        ,CONCAT(g.Voornaam, IFNULL(CONCAT(' ', g.Tussenvoegsel), ''), ' ', g.Achternaam) AS VolledigeNaam
        ,g.Email
        ,g.Telefoonnummer
        ,rc.Naam AS RijbewijsCategorie
        ,l.HeeftBeperking
        ,l.OmschrijvingBeperking
        ,l.IsActief
    FROM Leerling AS l
    JOIN Gebruiker AS g ON g.Id = l.GebruikerId
    JOIN Rijbewijscategorie AS rc ON rc.Id = l.RijbewijscategorieId
    WHERE g.IsActief = 1
    ORDER BY g.Achternaam, g.Voornaam;
END //
DELIMITER ;
