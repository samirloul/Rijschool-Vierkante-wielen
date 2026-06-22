DROP PROCEDURE IF EXISTS sp_lespakket_toevoegen;

DELIMITER //

CREATE PROCEDURE sp_lespakket_toevoegen(
    IN p_nummer INT UNSIGNED,
    IN p_naam VARCHAR(60),
    IN p_aantal_lessen SMALLINT UNSIGNED,
    IN p_prijs DECIMAL(8, 2),
    IN p_omschrijving VARCHAR(250)
)
BEGIN
    DECLARE v_bestaat INT DEFAULT 0;
    DECLARE v_bestaat_zelfde_gegevens INT DEFAULT 0;

    SELECT COUNT(*)
    INTO v_bestaat
    FROM Lespakket
    WHERE Id = p_nummer;

    IF v_bestaat > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Nummer is al in gebruik';
    END IF;

    SELECT COUNT(*)
    INTO v_bestaat_zelfde_gegevens
    FROM Lespakket
    WHERE Naam = p_naam
      AND AantalLessen = p_aantal_lessen
      AND Prijs = p_prijs
      AND COALESCE(Omschrijving, '') = COALESCE(p_omschrijving, '');

    IF v_bestaat_zelfde_gegevens > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Pakket met dezelfde gegevens bestaat al';
    END IF;

    INSERT INTO Lespakket (
        Id,
        Naam,
        AantalLessen,
        Prijs,
        Omschrijving,
        IsActief
    )
    VALUES (
        p_nummer,
        p_naam,
        p_aantal_lessen,
        p_prijs,
        p_omschrijving,
        1
    );
END //

DELIMITER ;
