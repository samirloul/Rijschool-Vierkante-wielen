-- Stored Procedure to get all available vehicles
DROP PROCEDURE IF EXISTS sp_GetBeschikbareVoertuigen;

-- Normalize old schema naming so all scripts can safely use Merk.
SET @has_database_merk := (
     SELECT COUNT(*)
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'Voertuig'
          AND COLUMN_NAME = 'DatabaseMerk'
);

SET @has_merk := (
     SELECT COUNT(*)
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'Voertuig'
          AND COLUMN_NAME = 'Merk'
);

SET @rename_sql := IF(
     @has_database_merk = 1 AND @has_merk = 0,
     'ALTER TABLE Voertuig CHANGE COLUMN DatabaseMerk Merk VARCHAR(40) NOT NULL',
     'SELECT 1'
);

PREPARE stmt_rename_merk FROM @rename_sql;
EXECUTE stmt_rename_merk;
DEALLOCATE PREPARE stmt_rename_merk;

DELIMITER $$

CREATE PROCEDURE sp_GetBeschikbareVoertuigen()
BEGIN
     SELECT
          Id,
          Merk,
          Type,
          Kenteken,
          Bouwjaar,
          IsElektrisch,
          IsActief,
          Opmerkingen,
          DatumAangemaakt,
          DatumGewijzigd
     FROM Voertuig
     WHERE IsActief = 1
     ORDER BY Merk ASC, Type ASC;
END $$

DROP PROCEDURE IF EXISTS sp_VoegAutoToe $$

CREATE PROCEDURE sp_VoegAutoToe(
     IN pMerk VARCHAR(40),
     IN pType VARCHAR(40),
     IN pIsElektrisch BIT,
     IN pIsActief BIT
)
BEGIN
     DECLARE vKenteken VARCHAR(10);

     IF pMerk IS NULL OR TRIM(pMerk) = ''
          OR pType IS NULL OR TRIM(pType) = ''
          OR pIsElektrisch IS NULL
          OR pIsActief IS NULL THEN
          SIGNAL SQLSTATE '45000'
               SET MESSAGE_TEXT = 'Vul alle verplichte velden in.';
     END IF;

     SET vKenteken = UPPER(CONCAT('VW', SUBSTRING(REPLACE(UUID(), '-', ''), 1, 8)));

     INSERT INTO Voertuig (
          Merk,
          Type,
          Kenteken,
          Bouwjaar,
          IsElektrisch,
          IsActief,
          Opmerkingen
     )
     VALUES (
          TRIM(pMerk),
          TRIM(pType),
          vKenteken,
          YEAR(CURDATE()),
          pIsElektrisch,
          pIsActief,
          NULL
     );
END $$

DELIMITER ;

SET FOREIGN_KEY_CHECKS=0;
DELETE FROM Voertuig;
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO Voertuig (Merk, Type, Kenteken, Bouwjaar, IsElektrisch, Opmerkingen)
VALUES
     ('Volkswagen', 'ID.3', 'VW-001-X', 2023, 1, 'Volledig elektrisch, groot display'),
     ('Tesla', 'Model 3', 'TS-002-Y', 2022, 1, 'Premium elektrisch voertuig'),
     ('Opel', 'Astra (HB)', 'OP-003-Z', 2021, 0, 'Handgeschakelde hatchback'),
     ('Toyota', 'Yaris', 'TY-004-A', 2022, 0, 'Compact en betrouwbaar'),
     ('Hyundai', 'i30', 'HY-005-B', 2023, 0, 'Moderne hatchback met veel comfort'),
     ('BMW', 'i4', 'BM-006-C', 2023, 1, 'Sportieve elektrische auto'),
     ('Renault', 'Twingo E-Tech', 'RN-007-D', 2024, 1, 'Compacte stadse elektro'),
     ('Ford', 'Fiesta', 'FD-008-E', 2021, 0, 'Vriendelijke beginner-auto'),
     ('Honda', 'Civic', 'HD-009-F', 2022, 0, 'Betrouwbare sedan');
