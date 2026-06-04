CREATE DATABASE IF NOT EXISTS Vierkante_Wielen2;
USE Vierkante_Wielen2;

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

CREATE TABLE Rijbewijscategorie (
     Id                INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     Naam              VARCHAR(10)      NOT NULL,
     Omschrijving      VARCHAR(100)     NOT NULL,
     IsActief          BIT              NOT NULL DEFAULT 1,
     Opmerkingen       VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt   DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd    DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id)
) ENGINE=InnoDB;

CREATE TABLE Adres (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     Straat           VARCHAR(60)      NOT NULL,
     Huisnummer       VARCHAR(10)      NOT NULL,
     Postcode         VARCHAR(10)      NOT NULL,
     Stad             VARCHAR(40)      NOT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id)
) ENGINE=InnoDB;

CREATE TABLE Gebruiker (
     Id                INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     Voornaam          VARCHAR(50)      NOT NULL,
     Tussenvoegsel     VARCHAR(20)      NULL DEFAULT NULL,
     Achternaam        VARCHAR(60)      NOT NULL,
     Email             VARCHAR(100)     NOT NULL,
     WachtwoordHash    VARCHAR(255)     NOT NULL,
     Telefoonnummer    VARCHAR(20)      NULL DEFAULT NULL,
     Geboortedatum     DATE             NULL DEFAULT NULL,
     Rol               ENUM('Leerling','Instructeur','Administrator') NOT NULL,
     AdresId           INT UNSIGNED     NULL DEFAULT NULL,
     IsActief          BIT              NOT NULL DEFAULT 1,
     Opmerkingen       VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt   DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd    DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     UNIQUE KEY UQ_Gebruiker_Email (Email),
     CONSTRAINT FK_Gebruiker_AdresId FOREIGN KEY (AdresId) REFERENCES Adres(Id)
) ENGINE=InnoDB;

CREATE TABLE Instructeur (
     Id                  INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     GebruikerId         INT UNSIGNED     NOT NULL,
     Rijbewijsnummer     VARCHAR(20)      NOT NULL,
     IndienstDatum       DATE             NOT NULL,
     IsActief            BIT              NOT NULL DEFAULT 1,
     Opmerkingen         VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt     DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd      DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     UNIQUE KEY UQ_Instructeur_GebruikerId (GebruikerId),
     CONSTRAINT FK_Instructeur_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

CREATE TABLE Leerling (
     Id                       INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     GebruikerId              INT UNSIGNED     NOT NULL,
     RijbewijscategorieId     INT UNSIGNED     NOT NULL,
     HeeftBeperking           BIT              NOT NULL DEFAULT 0,
     OmschrijvingBeperking    VARCHAR(250)     NULL DEFAULT NULL,
     IsActief                 BIT              NOT NULL DEFAULT 1,
     Opmerkingen              VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt          DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd           DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     UNIQUE KEY UQ_Leerling_GebruikerId (GebruikerId),
     CONSTRAINT FK_Leerling_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id),
     CONSTRAINT FK_Leerling_RijbewijscategorieId FOREIGN KEY (RijbewijscategorieId) REFERENCES Rijbewijscategorie(Id)
) ENGINE=InnoDB;

CREATE TABLE Voertuig (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     Merk             VARCHAR(40)      NOT NULL,
     Type             VARCHAR(40)      NOT NULL,
     Kenteken         VARCHAR(10)      NOT NULL,
     Bouwjaar         YEAR             NOT NULL,
     IsElektrisch     BIT              NOT NULL DEFAULT 0,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     UNIQUE KEY UQ_Voertuig_Kenteken (Kenteken)
) ENGINE=InnoDB;

CREATE TABLE Lespakket (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     Naam             VARCHAR(60)      NOT NULL,
     AantalLessen     SMALLINT UNSIGNED NOT NULL,
     Prijs            DECIMAL(8,2)     NOT NULL,
     Omschrijving     VARCHAR(250)     NULL DEFAULT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id)
) ENGINE=InnoDB;

CREATE TABLE LespakketPerLeerling (
     Id                    INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     LeerlingId           INT UNSIGNED     NOT NULL,
     LespakketId          INT UNSIGNED     NOT NULL,
     AantalLessenResterend SMALLINT UNSIGNED NOT NULL,
     DatumAankoop         DATE             NOT NULL,
     IsActief             BIT              NOT NULL DEFAULT 1,
     Opmerkingen          VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt      DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd       DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_LPL_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling(Id),
     CONSTRAINT FK_LPL_LespakketId FOREIGN KEY (LespakketId) REFERENCES Lespakket(Id)
) ENGINE=InnoDB;

CREATE TABLE Ziekmelding (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     InstructeurId    INT UNSIGNED     NOT NULL,
     DatumVanaf       DATE             NOT NULL,
     DatumTem         DATE             NULL DEFAULT NULL,
     Reden            VARCHAR(250)     NULL DEFAULT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Ziekmelding_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur(Id)
) ENGINE=InnoDB;

CREATE TABLE Rijles (
     Id                   INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     LeerlingId           INT UNSIGNED     NOT NULL,
     InstructeurId        INT UNSIGNED     NOT NULL,
     VoertuigId           INT UNSIGNED     NULL DEFAULT NULL,
     DatumTijd            DATETIME         NOT NULL,
     DuurMinuten          SMALLINT UNSIGNED NOT NULL DEFAULT 60,
     OphaaladresId        INT UNSIGNED     NULL DEFAULT NULL,
     Lesdoel              VARCHAR(250)     NULL DEFAULT NULL,
     TeBehandelenOnderwerp VARCHAR(250)    NULL DEFAULT NULL,
     Status               ENUM('Gepland','Gegeven','Geannuleerd') NOT NULL DEFAULT 'Gepland',
     AnnuleringsReden     VARCHAR(250)     NULL DEFAULT NULL,
     IsActief             BIT              NOT NULL DEFAULT 1,
     Opmerkingen          VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt      DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd       DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Rijles_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling(Id),
     CONSTRAINT FK_Rijles_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur(Id),
     CONSTRAINT FK_Rijles_VoertuigId FOREIGN KEY (VoertuigId) REFERENCES Voertuig(Id),
     CONSTRAINT FK_Rijles_OphaaladresId FOREIGN KEY (OphaaladresId) REFERENCES Adres(Id)
) ENGINE=InnoDB;

CREATE TABLE Examen (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     LeerlingId       INT UNSIGNED     NOT NULL,
     InstructeurId    INT UNSIGNED     NULL DEFAULT NULL,
     Soort            ENUM('Theorie','Praktijk') NOT NULL,
     DatumTijd        DATETIME         NULL DEFAULT NULL,
     Locatie          VARCHAR(100)     NULL DEFAULT NULL,
     Status           ENUM('Aangevraagd','Afgerond','Gezakt','Geslaagd') NOT NULL DEFAULT 'Aangevraagd',
     Resultaat        VARCHAR(250)     NULL DEFAULT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Examen_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling(Id),
     CONSTRAINT FK_Examen_InstructeurId FOREIGN KEY (InstructeurId) REFERENCES Instructeur(Id)
) ENGINE=InnoDB;

CREATE TABLE Opmerking (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     RijlesId         INT UNSIGNED     NOT NULL,
     GebruikerId      INT UNSIGNED     NOT NULL,
     Tekst            VARCHAR(500)     NOT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Opmerking_RijlesId FOREIGN KEY (RijlesId) REFERENCES Rijles(Id),
     CONSTRAINT FK_Opmerking_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

CREATE TABLE Melding (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     AfzenderId       INT UNSIGNED     NOT NULL,
     Titel            VARCHAR(100)     NOT NULL,
     Inhoud           VARCHAR(1000)    NOT NULL,
     Doelrol          ENUM('Leerling','Instructeur','Administrator') NULL DEFAULT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Melding_AfzenderId FOREIGN KEY (AfzenderId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

CREATE TABLE Factuur (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     LeerlingId       INT UNSIGNED     NOT NULL,
     Factuurnummer    VARCHAR(20)      NOT NULL,
     Factuurdatum     DATE             NOT NULL,
     Vervaldatum      DATE             NOT NULL,
     BedragExclBTW    DECIMAL(8,2)     NOT NULL,
     BTWPercentage    DECIMAL(5,2)     NOT NULL DEFAULT 21.00,
     BedragInclBTW    DECIMAL(8,2)     NOT NULL,
     Status           ENUM('Concept','Verstuurd','Betaald','Vervallen') NOT NULL DEFAULT 'Concept',
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     UNIQUE KEY UQ_Factuur_Factuurnummer (Factuurnummer),
     CONSTRAINT FK_Factuur_LeerlingId FOREIGN KEY (LeerlingId) REFERENCES Leerling(Id)
) ENGINE=InnoDB;

CREATE TABLE Betaling (
     Id               INT UNSIGNED     NOT NULL AUTO_INCREMENT,
     FactuurId        INT UNSIGNED     NOT NULL,
     Bedrag           DECIMAL(8,2)     NOT NULL,
     Betaaldatum      DATE             NOT NULL,
     Betaalmethode    ENUM('Ideal','Creditcard','Contant','Overboeking') NOT NULL,
     Referentie       VARCHAR(50)      NULL DEFAULT NULL,
     IsActief         BIT              NOT NULL DEFAULT 1,
     Opmerkingen      VARCHAR(250)     NULL DEFAULT NULL,
     DatumAangemaakt  DATETIME(6)      NOT NULL DEFAULT NOW(6),
     DatumGewijzigd   DATETIME(6)      NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
     PRIMARY KEY (Id),
     CONSTRAINT FK_Betaling_FactuurId FOREIGN KEY (FactuurId) REFERENCES Factuur(Id)
) ENGINE=InnoDB;