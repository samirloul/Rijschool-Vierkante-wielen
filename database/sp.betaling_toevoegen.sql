USE Vierkante_Wielen;

DROP PROCEDURE IF EXISTS sp_betaling_toevoegen;

DELIMITER $$
CREATE PROCEDURE sp_betaling_toevoegen(
    IN p_factuur_id INT UNSIGNED,
    IN p_bedrag DECIMAL(8, 2),
    IN p_betaaldatum DATE,
    IN p_betaalmethode ENUM('Ideal', 'Creditcard', 'Contant', 'Overboeking'),
    IN p_referentie VARCHAR(50)
)
BEGIN
    DECLARE v_leerling_id INT UNSIGNED DEFAULT NULL;
    DECLARE v_bestaat_zelfde_periode INT DEFAULT 0;

    SELECT LeerlingId
    INTO v_leerling_id
    FROM Factuur
    WHERE Id = p_factuur_id
    LIMIT 1;

    IF v_leerling_id IS NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Geselecteerde factuur bestaat niet';
    END IF;

    SELECT COUNT(*)
    INTO v_bestaat_zelfde_periode
    FROM Betaling b
    INNER JOIN Factuur f ON f.Id = b.FactuurId
    WHERE b.IsActief = 1
      AND f.LeerlingId = v_leerling_id
      AND YEAR(b.Betaaldatum) = YEAR(p_betaaldatum)
      AND MONTH(b.Betaaldatum) = MONTH(p_betaaldatum);

    IF v_bestaat_zelfde_periode > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Er bestaat al een betaling voor deze leerling en periode';
    END IF;

    INSERT INTO Betaling (
        FactuurId,
        Bedrag,
        Betaaldatum,
        Betaalmethode,
        Referentie,
        IsActief
    )
    VALUES (
        p_factuur_id,
        p_bedrag,
        p_betaaldatum,
        p_betaalmethode,
        p_referentie,
        1
    );
END $$
DELIMITER ;
