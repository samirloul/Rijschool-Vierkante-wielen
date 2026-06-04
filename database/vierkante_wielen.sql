CREATE DATABASE IF NOT EXISTS Vierkante_Wielen;

USE Vierkante_Wielen;

DROP TABLE IF EXISTS Betaling;

DROP TABLE IF EXISTS Factuur;

DROP TABLE IF EXISTS Melding;

DROP TABLE IF EXISTS Opmerking;

DROP TABLE IF EXISTS Examen;

DROP TABLE IF EXISTS Rijles;

DROP TABLE IF EXISTS Ziekmelding;

DROP TABLE IF EXISTS LespakketPerLeerling;

DROP TABLE IF EXISTS Lespakket;

DROP TABLE IF EXISTS Voertuig;

DROP TABLE IF EXISTS Instructeur;

DROP TABLE IF EXISTS Leerling;

DROP TABLE IF EXISTS Gebruiker;

DROP TABLE IF EXISTS Adres;

DROP TABLE IF EXISTS Rijbewijscategorie;

CREATE TABLE
     Rijbewijscategorie (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          Naam VARCHAR(10) NOT NULL,
          Omschrijving VARCHAR(100) NOT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Rijbewijscategorie (Naam, Omschrijving)
VALUES
     ('B', 'Personenauto (standaard rijbewijs)'),
     ('B-E', 'Personenauto met aanhanger'),
     ('AM', 'Bromfiets / snorfiets');

CREATE TABLE
     Adres (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          Straat VARCHAR(60) NOT NULL,
          Huisnummer VARCHAR(10) NOT NULL,
          Postcode VARCHAR(10) NOT NULL,
          Stad VARCHAR(40) NOT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Adres (Straat, Huisnummer, Postcode, Stad)
VALUES
     ('Hoofdstraat', '1', '5141AB', 'Waalwijk'),
     ('Molenstraat', '12', '5141BC', 'Waalwijk'),
     ('Kerkstraat', '3', '5141CD', 'Waalwijk'),
     ('Dorpsweg', '7', '5141DE', 'Waalwijk'),
     ('Lindelaan', '22', '5141EF', 'Waalwijk'),
     ('Parallelweg', '5', '5141FG', 'Waalwijk'),
     ('Schoolstraat', '19', '5141GH', 'Waalwijk'),
     ('Veldweg', '4', '5141HI', 'Waalwijk'),
     ('Kastanjelaan', '8', '5141IJ', 'Waalwijk'),
     ('Beatrixstraat', '14', '5141JK', 'Waalwijk');

CREATE TABLE
     Gebruiker (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          Voornaam VARCHAR(50) NOT NULL,
          Tussenvoegsel VARCHAR(20) NULL DEFAULT NULL,
          Achternaam VARCHAR(60) NOT NULL,
          Email VARCHAR(100) NOT NULL,
          WachtwoordHash VARCHAR(255) NOT NULL,
          Telefoonnummer VARCHAR(20) NULL DEFAULT NULL,
          Geboortedatum DATE NULL DEFAULT NULL,
          Rol ENUM ('Leerling', 'Instructeur', 'Administrator') NOT NULL,
          AdresId INT UNSIGNED NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          UNIQUE KEY UQ_Gebruiker_Email (Email),
          CONSTRAINT FK_Gebruiker_AdresId FOREIGN KEY (AdresId) REFERENCES Adres (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Gebruiker (
          Voornaam,
          Tussenvoegsel,
          Achternaam,
          Email,
          WachtwoordHash,
          Telefoonnummer,
          Geboortedatum,
          Rol,
          AdresId
     )
VALUES
     (
          'Pieter',
          NULL,
          'Janssen',
          'admin@vierkantewielen.nl',
          '$2b$12$adminHashVoorbeeld000000000000000000000000000000000000',
          '06-10000001',
          '1975-03-15',
          'Administrator',
          1
     ),
     (
          'Lars',
          NULL,
          'de Vries',
          'lars.devries@vierkantewielen.nl',
          '$2b$12$instrHashVoorbeeld000000000000000000000000000000000001',
          '06-10000002',
          '1985-06-20',
          'Instructeur',
          2
     ),
     (
          'Sanne',
          NULL,
          'Bakker',
          'sanne.bakker@vierkantewielen.nl',
          '$2b$12$instrHashVoorbeeld000000000000000000000000000000000002',
          '06-10000003',
          '1990-09-11',
          'Instructeur',
          3
     ),
     (
          'Kevin',
          'van',
          'den Berg',
          'kevin.vdberg@vierkantewielen.nl',
          '$2b$12$instrHashVoorbeeld000000000000000000000000000000000003',
          '06-10000004',
          '1988-12-01',
          'Instructeur',
          4
     ),
     (
          'Fatima',
          NULL,
          'El Amrani',
          'fatima.elamrani@vierkantewielen.nl',
          '$2b$12$instrHashVoorbeeld000000000000000000000000000000000004',
          '06-10000005',
          '1992-04-22',
          'Instructeur',
          5
     ),
     (
          'Tim',
          NULL,
          'Willems',
          'tim.willems@student.nl',
          '$2b$12$leerHashVoorbeeld000000000000000000000000000000000005',
          '06-20000001',
          '2005-01-10',
          'Leerling',
          6
     ),
     (
          'Emma',
          NULL,
          'Smit',
          'emma.smit@student.nl',
          '$2b$12$leerHashVoorbeeld000000000000000000000000000000000006',
          '06-20000002',
          '2006-07-18',
          'Leerling',
          7
     ),
     (
          'Daan',
          'van',
          'der Laan',
          'daan.vdlaan@student.nl',
          '$2b$12$leerHashVoorbeeld000000000000000000000000000000000007',
          '06-20000003',
          '2005-11-03',
          'Leerling',
          8
     ),
     (
          'Sophie',
          NULL,
          'Peters',
          'sophie.peters@student.nl',
          '$2b$12$leerHashVoorbeeld000000000000000000000000000000000008',
          '06-20000004',
          '2007-02-14',
          'Leerling',
          9
     ),
     (
          'Noah',
          NULL,
          'Mulder',
          'noah.mulder@student.nl',
          '$2b$12$leerHashVoorbeeld000000000000000000000000000000000009',
          '06-20000005',
          '2006-09-30',
          'Leerling',
          10
     );

CREATE TABLE
     Instructeur (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          GebruikerId INT UNSIGNED NOT NULL,
          Rijbewijsnummer VARCHAR(20) NOT NULL,
          IndienstDatum DATE NOT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          UNIQUE KEY UQ_Instructeur_GebruikerId (GebruikerId),
          CONSTRAINT FK_Instructeur_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Instructeur (GebruikerId, Rijbewijsnummer, IndienstDatum)
VALUES
     (2, 'NL-RB-20100234', '2020-03-01'),
     (3, 'NL-RB-20150567', '2021-06-15'),
     (4, 'NL-RB-20120891', '2019-09-01'),
     (5, 'NL-RB-20181123', '2023-01-10');

CREATE TABLE
     Leerling (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          GebruikerId INT UNSIGNED NOT NULL,
          RijbewijscategorieId INT UNSIGNED NOT NULL,
          HeeftBeperking BIT NOT NULL DEFAULT 0,
          OmschrijvingBeperking VARCHAR(250) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          UNIQUE KEY UQ_Leerling_GebruikerId (GebruikerId),
          CONSTRAINT FK_Leerling_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker (Id),
          CONSTRAINT FK_Leerling_RijbewijscategorieId FOREIGN KEY (RijbewijscategorieId) REFERENCES Rijbewijscategorie (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Leerling (
          GebruikerId,
          RijbewijscategorieId,
          HeeftBeperking,
          OmschrijvingBeperking
     )
VALUES
     (
          6,
          1,
          1,
          'Beperkte mobiliteit rechterhand, handauto vereist'
     ),
     (
          7,
          1,
          1,
          'Visuele beperking (gecorrigeerd), extra lestijd nodig'
     ),
     (8, 1, 0, NULL),
     (
          9,
          1,
          1,
          'Gehoorbeperking, visuele signalering gewenst'
     ),
     (10, 1, 0, NULL);

CREATE TABLE
     Voertuig (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          Merk VARCHAR(40) NOT NULL,
          Type VARCHAR(40) NOT NULL,
          Kenteken VARCHAR(10) NOT NULL,
          Bouwjaar YEAR NOT NULL,
          IsElektrisch BIT NOT NULL DEFAULT 0,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          UNIQUE KEY UQ_Voertuig_Kenteken (Kenteken)
     ) ENGINE = InnoDB;

INSERT INTO
     Voertuig (Merk, Type, Kenteken, Bouwjaar, IsElektrisch)
VALUES
     ('Volkswagen', 'ID.3', 'VW-001-X', 2023, 1),
     ('Tesla', 'Model 3', 'TS-002-Y', 2022, 1),
     ('Opel', 'Astra (HB)', 'OP-003-Z', 2021, 0);

CREATE TABLE
     Lespakket (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          Naam VARCHAR(60) NOT NULL,
          AantalLessen SMALLINT UNSIGNED NOT NULL,
          Prijs DECIMAL(8, 2) NOT NULL,
          Omschrijving VARCHAR(250) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Lespakket (Naam, AantalLessen, Prijs, Omschrijving)
VALUES
     (
          'Kennismakingspakket',
          5,
          225.00,
          '5 lessen voor beginners'
     ),
     (
          'Standaardpakket',
          10,
          420.00,
          '10 lessen inclusief theorie-begeleiding'
     ),
     (
          'Intensiefpakket',
          20,
          780.00,
          '20 lessen, snel rijbewijs halen'
     ),
     (
          'Maatwerkpakket',
          1,
          49.50,
          'Losse les, flexibel bij te kopen'
     );

CREATE TABLE
     LespakketPerLeerling (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          LeerlingId INT UNSIGNED NOT NULL,
          LespakketId INT UNSIGNED NOT NULL,
          AantalLessenResterend SMALLINT UNSIGNED NOT NULL,
          DatumAankoop DATE NOT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_LPL_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling (Id),
          CONSTRAINT FK_LPL_LespakketId FOREIGN KEY (LespakketId) REFERENCES Lespakket (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     LespakketPerLeerling (
          LeerlingId,
          LespakketId,
          AantalLessenResterend,
          DatumAankoop
     )
VALUES
     (1, 2, 8, '2026-05-01'),
     (2, 1, 3, '2026-05-10'),
     (3, 3, 18, '2026-04-20'),
     (4, 2, 10, '2026-05-15'),
     (5, 4, 1, '2026-05-28');

CREATE TABLE
     Ziekmelding (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          InstructeurId INT UNSIGNED NOT NULL,
          DatumVanaf DATE NOT NULL,
          DatumTem DATE NULL DEFAULT NULL,
          Reden VARCHAR(250) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Ziekmelding_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Ziekmelding (InstructeurId, DatumVanaf, DatumTem, Reden)
VALUES
     (2, '2026-05-20', '2026-05-22', 'Griep');

CREATE TABLE
     Rijles (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          LeerlingId INT UNSIGNED NOT NULL,
          InstructeurId INT UNSIGNED NOT NULL,
          VoertuigId INT UNSIGNED NULL DEFAULT NULL,
          DatumTijd DATETIME NOT NULL,
          DuurMinuten SMALLINT UNSIGNED NOT NULL DEFAULT 60,
          OphaaladresId INT UNSIGNED NULL DEFAULT NULL,
          Lesdoel VARCHAR(250) NULL DEFAULT NULL,
          TeBehandelenOnderwerp VARCHAR(250) NULL DEFAULT NULL,
          Status ENUM ('Gepland', 'Gegeven', 'Geannuleerd') NOT NULL DEFAULT 'Gepland',
          AnnuleringsReden VARCHAR(250) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Rijles_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling (Id),
          CONSTRAINT FK_Rijles_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur (Id),
          CONSTRAINT FK_Rijles_VoertuigId FOREIGN KEY (VoertuigId) REFERENCES Voertuig (Id),
          CONSTRAINT FK_Rijles_OphaaladresId FOREIGN KEY (OphaaladresId) REFERENCES Adres (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Rijles (
          LeerlingId,
          InstructeurId,
          VoertuigId,
          DatumTijd,
          DuurMinuten,
          OphaaladresId,
          Lesdoel,
          TeBehandelenOnderwerp,
          Status
     )
VALUES
     (
          1,
          1,
          1,
          '2026-06-02 09:00:00',
          60,
          6,
          'Stadsrijden',
          'Voorrang en kruispunten',
          'Gepland'
     ),
     (
          2,
          2,
          2,
          '2026-06-02 10:30:00',
          60,
          7,
          'Snelweg invoegen',
          'Snel rijden en afstand houden',
          'Gepland'
     ),
     (
          3,
          3,
          3,
          '2026-06-03 08:00:00',
          60,
          8,
          'Parkeren',
          'Inparkeren en uitparkeren',
          'Gepland'
     ),
     (
          4,
          1,
          1,
          '2026-06-03 11:00:00',
          60,
          9,
          'Gevaarherkenning',
          'Kwetsbare verkeersdeelnemers',
          'Gepland'
     ),
     (
          5,
          4,
          2,
          '2026-06-04 14:00:00',
          60,
          10,
          'Intro rijles',
          'Basis rijvaardigheid',
          'Gepland'
     ),
     (
          1,
          1,
          1,
          '2026-05-26 09:00:00',
          60,
          6,
          'Basisrijvaardigheid',
          'Optrekken en remmen',
          'Gegeven'
     ),
     (
          2,
          2,
          2,
          '2026-05-27 10:30:00',
          60,
          7,
          'Rotondes',
          'Verkeersregels rotonde',
          'Gegeven'
     );

CREATE TABLE
     Examen (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          LeerlingId INT UNSIGNED NOT NULL,
          InstructeurId INT UNSIGNED NULL DEFAULT NULL,
          Soort ENUM ('Theorie', 'Praktijk') NOT NULL,
          DatumTijd DATETIME NULL DEFAULT NULL,
          Locatie VARCHAR(100) NULL DEFAULT NULL,
          Status ENUM ('Aangevraagd', 'Afgerond', 'Gezakt', 'Geslaagd') NOT NULL DEFAULT 'Aangevraagd',
          Resultaat VARCHAR(250) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Examen_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling (Id),
          CONSTRAINT FK_Examen_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Examen (
          LeerlingId,
          InstructeurId,
          Soort,
          DatumTijd,
          Locatie,
          Status,
          Resultaat
     )
VALUES
     (
          1,
          1,
          'Theorie',
          '2026-06-10 10:00:00',
          'CBR Tilburg',
          'Aangevraagd',
          NULL
     ),
     (
          3,
          3,
          'Praktijk',
          '2026-06-20 13:00:00',
          'CBR Tilburg',
          'Aangevraagd',
          NULL
     );

CREATE TABLE
     Opmerking (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          RijlesId INT UNSIGNED NOT NULL,
          GebruikerId INT UNSIGNED NOT NULL,
          Tekst VARCHAR(500) NOT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Opmerking_RijlesId FOREIGN KEY (RijlesId) REFERENCES Rijles (Id),
          CONSTRAINT FK_Opmerking_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Opmerking (RijlesId, GebruikerId, Tekst)
VALUES
     (
          6,
          2,
          'Tim optrok soepel; remmen nog iets eerder anticiperen.'
     ),
     (
          6,
          6,
          'Ik vond het een goede les, voelde me zeker!'
     ),
     (
          7,
          3,
          'Emma beheerst rotondes goed. Volgende les snelweg.'
     ),
     (
          7,
          7,
          'Spannend maar ik deed het goed, blij met de feedback.'
     );

CREATE TABLE
     Melding (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          AfzenderId INT UNSIGNED NOT NULL,
          Titel VARCHAR(100) NOT NULL,
          Inhoud VARCHAR(1000) NOT NULL,
          Doelrol ENUM ('Leerling', 'Instructeur', 'Administrator') NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Melding_AfzenderId FOREIGN KEY (AfzenderId) REFERENCES Gebruiker (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Melding (AfzenderId, Titel, Inhoud, Doelrol)
VALUES
     (
          1,
          'Welkom bij Vierkante Wielen!',
          'Vanaf 1 juni zijn wij officieel gestart. Welkom allemaal!',
          NULL
     ),
     (
          1,
          'Nieuwe auto beschikbaar',
          'De Tesla Model 3 is nu ingepland voor lessen. Spreek dit af met uw instructeur.',
          'Leerling'
     ),
     (
          1,
          'Vergadering instructeurs 5 juni',
          'Op 5 juni om 17:00 is er een teamoverleg. Locatie: lesruimte rijschool.',
          'Instructeur'
     );

CREATE TABLE
     Factuur (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          LeerlingId INT UNSIGNED NOT NULL,
          Factuurnummer VARCHAR(20) NOT NULL,
          Factuurdatum DATE NOT NULL,
          Vervaldatum DATE NOT NULL,
          BedragExclBTW DECIMAL(8, 2) NOT NULL,
          BTWPercentage DECIMAL(5, 2) NOT NULL DEFAULT 21.00,
          BedragInclBTW DECIMAL(8, 2) NOT NULL,
          Status ENUM ('Concept', 'Verstuurd', 'Betaald', 'Vervallen') NOT NULL DEFAULT 'Concept',
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          UNIQUE KEY UQ_Factuur_Factuurnummer (Factuurnummer),
          CONSTRAINT FK_Factuur_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Factuur (
          LeerlingId,
          Factuurnummer,
          Factuurdatum,
          Vervaldatum,
          BedragExclBTW,
          BTWPercentage,
          BedragInclBTW,
          Status
     )
VALUES
     (
          1,
          'VW-2026-0001',
          '2026-05-01',
          '2026-05-15',
          347.11,
          21.00,
          420.00,
          'Betaald'
     ),
     (
          2,
          'VW-2026-0002',
          '2026-05-10',
          '2026-05-24',
          185.95,
          21.00,
          225.00,
          'Verstuurd'
     ),
     (
          3,
          'VW-2026-0003',
          '2026-04-20',
          '2026-05-04',
          644.63,
          21.00,
          780.00,
          'Betaald'
     ),
     (
          4,
          'VW-2026-0004',
          '2026-05-15',
          '2026-05-29',
          347.11,
          21.00,
          420.00,
          'Concept'
     ),
     (
          5,
          'VW-2026-0005',
          '2026-05-28',
          '2026-06-11',
          40.91,
          21.00,
          49.50,
          'Verstuurd'
     );

CREATE TABLE
     Betaling (
          Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
          FactuurId INT UNSIGNED NOT NULL,
          Bedrag DECIMAL(8, 2) NOT NULL,
          Betaaldatum DATE NOT NULL,
          Betaalmethode ENUM ('Ideal', 'Creditcard', 'Contant', 'Overboeking') NOT NULL,
          Referentie VARCHAR(50) NULL DEFAULT NULL,
          IsActief BIT NOT NULL DEFAULT 1,
          Opmerkingen VARCHAR(250) NULL DEFAULT NULL,
          DatumAangemaakt DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
          DatumGewijzigd DATETIME (6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
          PRIMARY KEY (Id),
          CONSTRAINT FK_Betaling_FactuurId FOREIGN KEY (FactuurId) REFERENCES Factuur (Id)
     ) ENGINE = InnoDB;

INSERT INTO
     Betaling (
          FactuurId,
          Bedrag,
          Betaaldatum,
          Betaalmethode,
          Referentie
     )
VALUES
     (
          1,
          420.00,
          '2026-05-14',
          'Ideal',
          'iDEAL-20260514-001'
     ),
     (
          3,
          780.00,
          '2026-05-03',
          'Overboeking',
          'OVB-20260503-003'
     );
