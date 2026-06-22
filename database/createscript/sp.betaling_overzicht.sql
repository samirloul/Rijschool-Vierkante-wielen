USE Vierkante_Wielen;

DROP PROCEDURE IF EXISTS sp_betaling_overzicht;

DELIMITER $$
CREATE PROCEDURE sp_betaling_overzicht(
    IN p_vanaf DATE,
    IN p_tot DATE
)
BEGIN
    SELECT
        f.Factuurnummer,
        CONCAT(g.Voornaam, ' ', IFNULL(g.Tussenvoegsel, ''), ' ', g.Achternaam) AS LeerlingNaam,
        g.Email,
        b.Bedrag,
        b.Betaaldatum,
        b.Betaalmethode,
        b.Referentie
    FROM Betaling b
    INNER JOIN Factuur f ON f.Id = b.FactuurId
    INNER JOIN Leerling l ON l.Id = f.LeerlingId
    INNER JOIN Gebruiker g ON g.Id = l.GebruikerId
    WHERE b.IsActief = 1
      AND (p_vanaf IS NULL OR b.Betaaldatum >= p_vanaf)
      AND (p_tot IS NULL OR b.Betaaldatum <= p_tot)
    ORDER BY b.Betaaldatum DESC, b.Id DESC;
END $$
DELIMITER ;
