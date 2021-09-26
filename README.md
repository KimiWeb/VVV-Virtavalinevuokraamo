# VVV-Virtavalinevuokraamo

Tein koulutyöksi kuvitteellisen virtavälinevuokraamon etusivun ja tietojärjestelmän. Teknistä osuutta pääsee kokeilemaan Henkilökunta osiosta voit rekisteröityä tai käyttää tunnuksia= admin, admin.
Tietokanta suunniteltu työparin kanssa, verkkosivujen toteutuksen olen tehnyt itse.

ER-Kaavio:

SQL LAUSEET:
DROP TABLE Huolto;  
  
DROP TABLE Henkilökunta;  
 
DROP TABLE Laite;  
 
DROP TABLE Matka;  
 
DROP TABLE Maksukortti;  
 
DROP TABLE veloitus;  
 
DROP TABLE Asiakas;   

DROP TABLE Vikatyyppi; 
DROP TABLE users;
  
CREATE TABLE Henkilökunta(  
 
TyöntekijäID char(3) PRIMARY KEY NOT NULL ,  
 
Etunimi varchar(40) NOT NULL ,  
 
Sukunimi varchar(40) NOT NULL ,  
 
Puhelin varchar(40) NOT NULL,  
 
Lähiosoite varchar(40) NOT NULL,  
 
Posti_nro char(5) NOT NULL,  
 
Postitoimipaikka varchar(50) NOT NULL,  
 
Sähköposti varchar(40)  
 ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


 
CREATE TABLE Laite(  
 
LaiteID int PRIMARY KEY AUTO_INCREMENT NOT NULL,  
 
Latitude decimal(9,6),  
 
Longitude decimal(9,6),  
 
Toimintasäde varchar(40),  
 
Akku smallint,  
 
QRkoodi varchar(50) NOT NULL  
 
 ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

  
CREATE TABLE Vikatyyppi(
Vikatyyppi varchar(40) PRIMARY KEY NOT NULL
 ) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

  
 
CREATE TABLE Huolto(  
 
HuoltoID int PRIMARY KEY AUTO_INCREMENT NOT NULL,  
 
TyöntekijäID char(3) NOT NULL,  
 
LaiteID int NOT NULL,  
 
Vikatyyppi varchar(40),  
 
HuoltoPVM DATE,

  
FOREIGN KEY (TyöntekijäID) REFERENCES Henkilökunta(TyöntekijäID),  
 
FOREIGN KEY (LaiteID) REFERENCES Laite(LaiteID)
FOREIGN KEY (Vikatyyppi REFERENCES Vikatyyppi(Vikatyyppi)
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;
 
  
 
 
CREATE TABLE Maksukortti (   
 
MaksukorttiID int PRIMARY KEY NOT NULL,    
 
Kortinhaltija nvarchar(50),   
  
Kortinnumero nvarchar(25),   
   
VoimassaoloKK smallint,   
   
VoimassaoloVuosi smallint,     
 
Viimeisinmuutos DATETIME,  
  
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;
  

CREATE TABLE Asiakas (   
 
asiakasID int PRIMARY KEY AUTO_INCREMENT NOT NULL,   
 
etunimi varchar(40) NOT NULL,   
 
sukunimi varchar(40) NOT NULL,   
 
puh_nro varchar(15) NOT NULL,  
 
lähiosoite varchar(50) NOT NULL,  
 
posti_nro char(5) NOT NULL,  
 
postitoimipaikka varchar(50) NOT NULL,  
 
email varchar(40) NOT NULL,  
 
maksukorttiID int NOT NULL,   
 
FOREIGN KEY (MaksukorttiID) REFERENCES Maksukortti(MaksukorttiID)  
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

  
 
CREATE TABLE Matka(  
 
MatkaID int PRIMARY KEY AUTO_INCREMENT  NOT NULL,  
 
asiakasID int NOT NULL,  
 
LaiteID int NOT NULL,  
 
Matkankesto DATETIME NOT NULL,  
 
Alku_latitude decimal(9,6) NOT NULL,  
 
Alku_longitude decimal(9,6) NOT NULL,  
 
Loppu_latitude decimal(9,6) NOT NULL,  
 
Loppu_longitude decimal(9,6) NOT NULL,  
 
 
FOREIGN KEY (asiakasID) REFERENCES Asiakas(asiakasID),  
 
FOREIGN KEY (LaiteID) REFERENCES Laite(LaiteID)  
 )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

  
 
  
 
CREATE TABLE Veloitus (   
 
maksuID int PRIMARY KEY NOT NULL,   
 
asiakasID int NOT NULL,   
 
maksukorttiID int NOT NULL,   
 
avaushinta decimal(9,2) NOT NULL,  
 
minuuttihinta decimal(9,2) NOT NULL,  
 
avausmaara int NOT NULL,  
 
minuuttimaara decimal(6) NOT NULL,  
 
FOREIGN KEY (asiakasID) REFERENCES Asiakas(asiakasID),  
FOREIGN KEY (MaksukorttiID) REFERENCES Maksukortti(MaksukorttiID)
 )DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE users (   
Id PRIMARY KEY AUTO_INCREMENT NOT NULL,    
 
username nvarchar(25) NOT NULL, 
password varchar(50) NOT NULL)  
  
)DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


 INSERT INTO users (username, password) VALUES ('admin', 'admin’)

INSERT INTO Henkilökunta (TyöntekijäID, Etunimi, Sukunimi, Puhelin, Lähiosoite, Posti_nro, Postitoimipaikka, Sähköposti) VALUES   
 
('jka', 'Johan', 'Kalas', '0441214530','Konepajakatu 1c 65', '65100', 'Vaasa', 'johan.kalas1@gmail.com'),  
 
('jkr', 'Jeesus', 'Kristus', ' 0504113979', 'Kalliomäki 5', '65410', 'Sundom', 'Jeesus.kristu@evl.fi'),  
 
('mme', 'Matti', 'Meikäläinen', ' 0420276753', 'Jeesuksenkatu 2', '65110', 'Vaasa', 'matti.meikalaine@luukku.fi'),  
 
('khi', 'Kippo', 'Hippo', ' 0418987982', 'Hipitontie 3', '65100', 'Vaasa', 'hippo.kippo@gmail.com'),  
 
('sma', 'Siiri', 'Maatila', '0442116130', 'Konepajakatu 1q 62', '65100', 'Vaasa', 'siiri.maatila@vvv.fi');  

INSERT INTO Laite (Latitude, Longitude, Toimintasäde, Akku, QRkoodi) VALUES  
  
('63.02196', '26.21317','Vaasa', 43, 'https://www.qr-koodit.fi/generaattori'),  
 
('61.09612', '24.61579','Vaasa', 2, 'https://www.qr-koodit.fi/generaattori'),  
 
('64.12600', '23.91279','Vaasa', 100, 'https://www.qr-koodit.fi/generaattori'),  
 
('63.20006', '22.42578','Vaasa', 86, 'https://www.qr-koodit.fi/generaattori'),  
 
('65.10396', '25.34537','Vaasa', 100, 'https://www.qr-koodit.fi/generaattori'),  
 
('61.02196', '22.21317','Vaasa', 63, 'https://www.qr-koodit.fi/generaattori'),  
 
('63.20006', '23.42578','Vaasa', 36, 'https://www.qr-koodit.fi/generaattori'),  
 
('61.10396', '24.34537','Vaasa', 5, 'https://www.qr-koodit.fi/generaattori'),  
 
('63.02196', '26.21317','Vaasa', 13, 'https://www.qr-koodit.fi/generaattori');   
 
INSERT INTO Huolto (TyöntekijäID, LaiteID, Vikatyyppi, HuoltoPVM) VALUES   
 
('jkr', 0007, 'Perus huolto', '2020-8-11 01:20:10'),    
 
('jka', 0001, 'Akun vaihto', '2020-8-20 04:00:31'),   
 
('jkr', 0002, 'Renkaan vaihto', '2020-9-1 03:19:22'),   
 
('jkr', 0002, 'Perus huolto', '2020-9-20 01:10:01'),   
 
('jka', 0003, 'Perus huolto', '2020-9-25 01:24:57'),   
 
('jka', 0004, 'Perus huolto', '2020-9-10 01:41:51'),   
 
('sma', 0001, 'Tangonvaihto', '2020-10-10 05:13:34'),   
 
('jka', 0003, 'Akun vaihto', '2020-10-12 06:11:22'),   
 
('jka', 0001, 'Renkaan vaihto', '2020-10-11 02:10:01'),   
 
('jka', 0006, 'Perus huolto', '2020-10-13 02:17:33'),   
 
('sma', 0005, 'Perus huolto', '2020-10-13 00:40:21'),   
 
('sma', 0004, 'Perus huolto', '2020-10-13 01:10:34'),   
 
('sma', 0004, 'Renkaan vaihto', '2020-10-14 03:50:43'),   
 
('jka', 0003, 'Akun vaihto', '2020-10-15 04:31:22'),   
 
('jka', 0002, 'Tangonvaihto', '2020-10-18 03:10:11'),   
 
('jka', 0001, 'Perus huolto', '2020-10-18 00:53:21');  
 
 INSERT INTO Huolto (TyöntekijäID, LaiteID, Vikatyyppi, HuoltoPVM) VALUES   
 
('jkr', 0007, 'Perus huolto', '2020-8-11'),    
 
('jka', 0001, 'Akun vaihto', '2020-8-20'),   
 
('jkr', 0002, 'Renkaan vaihto', '2020-9-1'),   
 
('jkr', 0002, 'Perus huolto', '2020-9-20'),   
 
('jka', 0003, 'Perus huolto', '2020-9-25'),   
 
('jka', 0004, 'Perus huolto', '2020-9-10'),   
 
('sma', 0001, 'Tangonvaihto', NOW());      
  
 
INSERT INTO Maksukortti (MaksukorttiID, Kortinhaltija, Kortinnumero, VoimassaoloKK, VoimassaoloVuosi, Viimeisinmuutos) VALUES    
(1234, 'Pasi Veinä', '1234-1234-1234-1234', 06, 12, '2020-08-11 01:20'),  
(1235, 'Paasi Veini', '4234-1234-1234-1234', 06, 12, '2020-08-11 01:22'),  
(1236, 'Kasi Vehnä', '6234-1234-1234-1234', 06, 12, '2020-08-11 02:20'),  
(1237, 'Masi Keinä', '7234-1234-1234-1234', 06, 12, '2020-08-11 08:20'),  
(1238, 'Lasi Heinä', '1134-1234-1234-1234', 06, 12, '2020-08-11 11:20'), 
(1239, 'Aasi Veinä', '1234-1234-1234-1234', 06, 12, '2020-08-11 01:20'),  
(1240, 'Taasi Veini', '4234-1234-1234-1234', 06, 12, '2020-08-11 01:22'),  
(1241, 'Kaksi Vehnä', '6234-1234-1234-1234', 06, 12, '2020-08-11 02:20'),  
(1242, 'Maasi Keinä', '7234-1234-1234-1234', 06, 12, '2020-08-11 08:20'),  
(1243, 'Lasiili Heinä', '1134-1234-1234-1234', 06, 12, '2020-08-11 11:20'), 
(1244, 'Kesi Veinä', '1234-1234-1234-1234', 06, 12, '2020-08-11 01:20'),  
(1245, 'Waasi Veini', '4234-1234-1234-1234', 06, 12, '2020-08-11 01:22'),  
(1246, 'Gasi Vehnä', '6234-1234-1234-1234', 06, 12, '2020-08-11 02:20'),  
(1247, 'Keisi Keinä', '7234-1234-1234-1234', 06, 12, '2020-08-11 08:20'),  
(1248, 'Lasmi Heinä', '1134-1234-1234-1234', 06, 12, '2020-08-11 11:20');  
  
 
INSERT INTO Asiakas (etunimi, sukunimi, puh_nro, lähiosoite, posti_nro, postitoimipaikka, email, maksukorttiID) VALUES    
 
('Kimi', 'Öling', '0449916530', 'Konepajakatu 9d 65', '65200', 'Vaasa', 'kimbo@hotmail.fi', 1234),   
 
('Julius', 'Aaltonen', '0504113979', 'Kalliomäki 5', '65250', 'Vaasa', 'aaltonen.julius@hotmail.fi', 1235),   
 
('Matti', 'Meikäläinen', '0420276753', 'Jeesuksenkatu 2', '65230', 'Vaasa', 'masamei@hotmail.fi', 1236),   
 
('Kippo', 'Hippo', '0418987982', 'Hipitontie 3', '65220', 'Vaasa', 'hiphei@hotmail.fi', 1237),   
 
('Siiri', 'Maatila', '0449916530', 'Konepajakatu 1 c 62', '65200', 'Vaasa', 'siimaa@hotmail.fi', 1238),  
 
('Jimi', 'Noutaja', '0449916530', 'Konekujakatu 9 b 63', '62200', 'Vaasa', 'Jimbo53@hotmail.fi', 1239),   
 
('Jani', 'Nieminen', '0504123979', 'Kalliomäki 2', '62400', 'Vaasa', 'janinieminen@hotmail.fi', 1240),   
 
('Matti', 'Muukalainen', '0420242313', 'Jeesuksenkatu 6', '65200', 'Vaasa', 'masamuu@hotmail.fi', 1241),   
 
('Janne', 'Kataja', '0418922282', 'Katajakuja 5', '65500', 'Vaasa', 'janneka@hotmail.fi', 1242),   
 
('Pekka', 'Malinen', '0469923230', 'Boksikuja 1a 5', '65500', 'Vaasa', 'Malinenpeke@hotmail.fi', 1243),  
 
('Saara', 'Kataja', '046991330', 'Beerinne 4c 2', '65500', 'Vaasa', 'saarakataja@hotmail.fi', 1244),   
 
('Roope', 'Reinola', '0504141979', 'Revontulitie 7 b 2', '65200', 'Vaasa', 'roopeankka@hotmail.fi', 1245),   
 
('Eero', 'Reipas', '0420332344', 'Ahventie 2 b 2', '65200', 'Vaasa', 'reipaseero@hotmail.fi', 1246),  
 
('Aleksi', 'Jalli', '0418987982', 'Kiikarikiväärintie 13 e 7', '65200', 'Vaasa', 'enceallu@hotmail.fi', 1247),   
 
('Miikka', 'Kemppi', '0441333337', 'Pääosumakuja 4 b 2', '65500', 'Vaasa', 'ez4ence@hotmail.fi', 1248)  ;
 

INSERT INTO Matka (MatkaID, asiakasID, LaiteID, Matkankesto, Alku_latitude,  Alku_longitude, Loppu_latitude, Loppu_longitude) VALUES   
 
(0001, 0001, 0003, '2020-08-01 00:10:01', '63.09600', '21.63577', '61.23600', '22.61587'),  
 
(0002, 0004, 0002, '2020-09-01 00:05:21', '64.09600', '22.64577', '62.22600', '24.65677'),  
 
(0003, 0003, 0004, '2020-09-18 00:25:51', '61.09600', '23.65577', '63.21600', '26.65577'),  
 
(0004, 0002, 0005, '2020-10-11 00:13:01', '63.09600', '20.63577', '61.29400', '21.61177'),  
 
(0005, 0010, 0001, '2020-10-18 00:18:01', '64.09600', '25.62577', '65.25600', '24.62577'),   
 
(0006, 0002, 0010, '2020-10-18 00:10:01', '63.09600', '21.63577', '61.23600', '22.61587'),  
 
(0007, 0002, 0011, '2020-10-18 00:05:21', '63.09600', '22.64577', '62.22600', '24.65677'),  
 
(0008, 0004, 0014, '2020-10-19 00:25:51', '62.09600', '23.65577', '63.21600', '26.65577'),   
 
 (0009, 0005, 0003, '2020-10-19 00:13:01', '61.09600', '20.63577', '61.29400', '21.61177'),   
 
 (0010, 0010, 0003, '2020-10-19 00:10:01', '68.09600', '21.63577', '61.23600', '22.61587'),   
 
 (0011, 0011, 0010, '2020-10-19 00:05:21', '62.09600', '22.64577', '62.22600', '24.65677'),   
 
 (0012, 0015, 0011, '2020-10-19 00:25:51', '62.09600', '23.65577', '63.21600', '26.65577'),   
 
 (0013, 0009, 0005, '2020-10-20 00:13:01', '63.09600', '20.63577', '63.29400', '21.61177'),   
 
 (0014, 0010, 0006, '2020-10-20 00:10:01', '64.09600', '21.63577', '61.23600', '22.61587'),   
 
(0015, 0013, 0011, '2020-10-20 00:05:21', '66.09600', '22.64577', '61.22600', '24.65677'),   
 
(0016, 0004, 0010, '2020-10-20 00:25:51', '62.09600', '23.65577', '63.21600', '26.65577'),    
 
(0017, 0002, 0001, '2020-10-21 00:13:01', '63.09600', '20.63577', '61.29400', '21.61177');   
 
INSERT INTO Veloitus (maksuID, asiakasID, maksukorttiID, avaushinta, minuuttihinta, avausmaara, minuuttimaara) VALUES    
 
(000001, 0001, 1234, 1, '0.25', 5, '11.00'),   
 
(000002, 0002, 1235, 1, '0.25', 10, '22.00'),   
 
(000003, 0003, 1236, 1, '0.25', 7, '33.00'),   
 
(000004, 0004, 1237, 1, '0.25', 8, '44.00'),  
 
(000005, 0005, 1238, 1, '0.25', 6, '55.00'); 
