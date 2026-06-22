-- Stored Procedure to get all available vehicles
DROP PROCEDURE IF EXISTS sp_GetBeschikbareVoertuigen;

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
     
     UPDATE Voertuig SET IsActief = 0;
