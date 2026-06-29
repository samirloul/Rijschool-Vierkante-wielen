DROP PROCEDURE IF EXISTS sp_rijles_store;

DELIMITER //

CREATE PROCEDURE sp_rijles_store(
    IN p_leerling_id    INT UNSIGNED,
    IN p_instructeur_id INT UNSIGNED,
    IN p_voertuig_id    INT UNSIGNED,
    IN p_datum_tijd     DATETIME,
    IN p_duur_minuten   SMALLINT UNSIGNED,
    IN p_ophaaladres_id INT UNSIGNED
)
BEGIN
    IF p_datum_tijd <= NOW() THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Lessen kunnen niet in het verleden plaatsvinden';
    END IF;

    INSERT INTO Rijles (
         LeerlingId
        ,InstructeurId
        ,VoertuigId
        ,DatumTijd
        ,DuurMinuten
        ,OphaaladresId
        ,Status
    )
    VALUES (
         p_leerling_id
        ,p_instructeur_id
        ,p_voertuig_id
        ,p_datum_tijd
        ,p_duur_minuten
        ,p_ophaaladres_id
        ,'Gepland'
    );

    -- Geef het nieuw aangemaakte ID terug
    SELECT LAST_INSERT_ID() AS NieuwId;
END //

DELIMITER ;
