CREATE TABLE racers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rugnummer INT,
    voornaam VARCHAR(255),
    achternaam VARCHAR(255),
    geslacht ENUM('M', 'V'),
    geboortejaar INT,
    categorie ENUM('U8', 'U10', 'U12', 'U14', 'U16', 'U18', 'U21')
);

CREATE TABLE races (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255),
    wedstijd_format ENUM('1', '2', '3'),
    datum DATE
);

CREATE TABLE race_racers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    race_id INT,
    racer_id INT,
    run_num INT,
    tijd DECIMAL(5, 2),
    status ENUM('DSQ', 'OK')
);
