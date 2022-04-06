##CREATED BY: Andre Freeman##
##Date created: Jan 1st 2018##
##LAST Modified: Jan 24th 2018##
##St. Kitts and Nevis Government SCHEMA##

CREATE DATABASE GOVN;

USE GOVN;

CREATE TABLE GOVNOFFICES(
    GID INT AUTO_INCREMENT,     #Governemnt Office ID
    Name VARCHAR(75),           #Government Office Name
    Island VARCHAR(25),         #Government Office Location
    PRIMARY KEY (GID)
);
#########################################################################
CREATE TABLE DEPTYPE(
    TID INT AUTO_INCREMENT,   #Division Type ID
    Type VARCHAR(25) UNIQUE,           #Division Type
    PRIMARY KEY (TID) 
);
#########################################################################
CREATE TABLE DEPARTMENT(
    DID INT AUTO_INCREMENT,     #Division ID
    GID INT,                    #Governmet office the Division is in
    Name VARCHAR(25) UNIQUE,    #Division Name
    Type INT,                   #DIVISION TYPE ID
    Address VARCHAR(25),        #Division Loaction
    Street VARCHAR (25),        #Division Loaction
    City VARCHAR(25),           #Division Loaction
    Parish VARCHAR(25),         #Division Loaction
    Island VARCHAR(25),         #Division Loaction
    Tel INT (7),
    PRIMARY KEY(DID),       
    FOREIGN KEY(GID) REFERENCES GOVNOFFICES(GID) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT,
    FOREIGN KEY (Type) REFERENCES DEPTYPE(TID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);
########################################################################################
CREATE TABLE PAYMENTLIST(
    PID VARCHAR(5),
    Amt DECIMAL(15,2) UNIQUE,
    PRIMARY KEY(PID)
);
########################################################################################
CREATE TABLE HUMAN(
    HID INT AUTO_INCREMENT,
    Fname VARCHAR(25),          #First Name
    Mname VARCHAR(25),          #Middle Name
    Lname VARCHAR(25),          #Last Name
    Oname VARCHAR(25),          #Other Name
    Gender VARCHAR(1),          #Gender M for Male
    DOB DATE,                   #Date Of Birth
    Height INT,                 #
    Race VARCHAR(25),           #
    Eye_Color VARCHAR(25),      #
    BType VARCHAR (2),          #BLOOD TYPE
    POB VARCHAR(25),            #Place of Birth
    PRIMARY KEY(HID)
);

CREATE TABLE ADULT(
    HID INT,
    SSN INT UNIQUE,             #Social Security Number
    NID INT UNIQUE,             #National Identification Number
    Address VARCHAR(25),       #Home Address
    Street VARCHAR (25),        #Home Street
    City VARCHAR(25),           #Home City/Village
    Parish VARCHAR(25),         #Home Parish
    Island VARCHAR(25),         #Home Island
    H_Tel INT(7),               #Home Telephone Number
    C_Tel INT(7),               #Cel Telephone Number
    Email VARCHAR(100),         #Email Address
    PRIMARY KEY(HID),
    FOREIGN KEY (HID) REFERENCES HUMAN(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
###############################################################################
CREATE TABLE PARENTOF(
    HID INT,                    #Parent ID
    CID INT,                    #Child ID
    Relationship VARCHAR(25),   #Type of relationship - (Adopted) Son/Daughter
    PRIMARY KEY (HID,CID),
    FOREIGN KEY(HID) REFERENCES ADULT(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (CID) REFERENCES HUMAN(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
###############################################################################



####################################################################################
CREATE TABLE SPOUSE(
    HID INT,
    SID INT UNIQUE,
    PRIMARY KEY(HID),
    FOREIGN KEY (HID) REFERENCES ADULT(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (SID) REFERENCES ADULT(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
####################################################################################
CREATE TABLE EMPLOYEE(
    EID INT AUTO_INCREMENT UNIQUE,      #Employee ID
    HID INT,                            #HUman ID
    PID VARCHAR(5),                     #Payment ID
    Super_ID INT,                       #Supervisor ID
    Type VARCHAR(50),                   #Employee Type/Position
    Since DATE,                         #Empolyee Start Work date
    PRIMARY KEY(HID),
    FOREIGN KEY (HID) REFERENCES ADULT(HID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (PID) REFERENCES PAYMENTLIST(PID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    FOREIGN KEY (Super_ID) REFERENCES EMPLOYEE(EID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);
###################################################################################
##CREDENTIALS##
CREATE TABLE CREDENTIALS(
    EID INT,
    Uname VARCHAR(50),                  #Username
    Pass VARCHAR(50),                   #Password
    Type INT,                           #0-Highest Level of access 4-Lowest
    PRIMARY KEY(EID),
    FOREIGN KEY (EID) REFERENCES EMPLOYEE(EID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
##CREDENTIALS##
###################################################################################
CREATE TABLE QUALIFICATION(
    QID INT,                        #Qualification ID
    EID INT,                        #Employee ID
    Qname VARCHAR(25),              #Degree name
    Qlevel VARCHAR(25),             #Degree 
    Qyear INT,                      #Year degree completed
    Qschool VARCHAR(100),           #School in which degree was done at
    PRIMARY KEY(QID),
    FOREIGN KEY(EID) REFERENCES EMPLOYEE(EID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);
####################################################################################
###SUB CLASSES OF EMPLOYEE###
 CREATE TABLE GovOFFICERS(
     EID INT,
     OID INT UNIQUE AUTO_INCREMENT,         #Officer ID
     APNT TINYINT(1) DEFAULT NULL,          #0-Appointed  1-Elected
     GID INT,                        #Govenment Office allocated
     PRIMARY KEY (EID),
     FOREIGN KEY (EID) REFERENCES EMPLOYEE(EID)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
     FOREIGN KEY(GID) REFERENCES GOVNOFFICES(GID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
 );
CREATE TABLE DepOFFICERS(
    EID INT,
    OID INT UNIQUE AUTO_INCREMENT,                  #Officer ID
    DID INT,                                        #Division ID
    PRIMARY KEY (EID),
    FOREIGN KEY (DID) REFERENCES DEPARTMENT(DID)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    FOREIGN KEY (EID) REFERENCES EMPLOYEE(EID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
 ); 
####################################################################################
##VEIEWS##
CREATE VIEW GOFFICES AS
SELECT GOVNOFFICES.GID, GOVNOFFICES.Name AS "G_Office",(SELECT HUMAN.Fname FROM HUMAN,EMPLOYEE,GovOFFICERS WHERE EMPLOYEE.HID=HUMAN.HID AND EMPLOYEE.EID=GovOFFICERS.EID AND GovOFFICERS.GID=GOVNOFFICES.GID AND EMPLOYEE.Type LIKE "%Minister%") AS "M_Fname",(SELECT HUMAN.Lname FROM HUMAN,EMPLOYEE,GovOFFICERS WHERE EMPLOYEE.HID=HUMAN.HID AND EMPLOYEE.EID=GovOFFICERS.EID AND GovOFFICERS.GID=GOVNOFFICES.GID AND EMPLOYEE.Type LIKE "%Minister%")AS "M_Lname",(SELECT HUMAN.Fname FROM HUMAN,EMPLOYEE,GovOFFICERS WHERE EMPLOYEE.HID=HUMAN.HID AND EMPLOYEE.EID=GovOFFICERS.EID AND GovOFFICERS.GID=GOVNOFFICES.GID AND EMPLOYEE.Type="Permanent Secretary") AS "PS_Fname",(SELECT HUMAN.Lname FROM HUMAN,EMPLOYEE,GovOFFICERS WHERE EMPLOYEE.HID=HUMAN.HID AND EMPLOYEE.EID=GovOFFICERS.EID AND GovOFFICERS.GID=GOVNOFFICES.GID AND EMPLOYEE.Type="Permanent Secretary")AS "PS_Lname",GOVNOFFICES.Island FROM GOVNOFFICES;
 
CREATE VIEW DWView AS
SELECT DEPARTMENT.Name AS "Department",DEPTYPE.Type AS "DType",E.EID,H.Fname,H.Lname,E.Type AS "Position",PAYMENTLIST.Amt AS "Salary",E.Since,SH.Fname AS "S_Fname",SH.Lname AS "S_Lname",S.Type AS "S_Position" FROM DEPARTMENT,HUMAN AS H,EMPLOYEE AS E, EMPLOYEE AS S,HUMAN AS SH,DEPTYPE,DepOFFICERS,PAYMENTLIST WHERE H.HID=E.HID AND E.PID=PAYMENTLIST.PID AND DEPARTMENT.DID=DepOFFICERS.DID AND DepOFFICERS.EID=E.EID AND DEPARTMENT.Type=DEPTYPE.TID AND S.EID=E.Super_ID AND S.HID=SH.HID
UNION 
SELECT DEPARTMENT.Name AS "Department",DEPTYPE.Type AS "DType",E.EID,H.Fname,H.Lname,E.Type AS "Position",PAYMENTLIST.Amt AS "Salary",E.Since,NULL,NULL,NULL FROM DEPARTMENT,HUMAN AS H,EMPLOYEE AS E,HUMAN AS SH,DEPTYPE,DepOFFICERS,PAYMENTLIST WHERE H.HID=E.HID AND E.PID=PAYMENTLIST.PID AND DEPARTMENT.DID=DepOFFICERS.DID AND DepOFFICERS.EID=E.EID AND DEPARTMENT.Type=DEPTYPE.TID AND E.Super_ID IS NULL;
 
CREATE VIEW GWView AS
SELECT GOVNOFFICES.Name AS "G_Office",EMPLOYEE.EID, HUMAN.Fname,HUMAN.Lname,EMPLOYEE.Type AS "Position",PAYMENTLIST.Amt AS "Salary",EMPLOYEE.Since FROM GOVNOFFICES,HUMAN,EMPLOYEE,GovOFFICERS,PAYMENTLIST WHERE HUMAN.HID=EMPLOYEE.HID AND EMPLOYEE.PID=PAYMENTLIST.PID AND EMPLOYEE.EID=GovOFFICERS.EID AND GOVNOFFICES.GID=GovOFFICERS.GID;

CREATE VIEW EmpPI AS
SELECT EMPLOYEE.EID,HUMAN.Fname,HUMAN.Mname,HUMAN.Lname,HUMAN.Oname,HUMAN.Gender,HUMAN.Eye_Color,HUMAN.Race,HUMAN.BType,HUMAN.Height,HUMAN.DOB,HUMAN.POB,ADULT.Street,ADULT.Address,ADULT.City,ADULT.Parish,ADULT.Island,ADULT.H_Tel,ADULT.C_Tel,ADULT.Email,EMPLOYEE.Since FROM ADULT,HUMAN, EMPLOYEE WHERE HUMAN.HID=ADULT.HID AND ADULT.HID=EMPLOYEE.HID; 


##################################################################################
 ##Server Connect EDIT##
 DROP USER IF EXISTS 'lgReq'@'localhost';
 CREATE USER 'lgReq'@'localhost' IDENTIFIED BY 'LG0SKN';
 GRANT INSERT ON GOVN.CREDENTIALS TO 'lgReq'@'localhost';
 GRANT SELECT ON GOVN.CREDENTIALS TO 'lgReq'@'localhost';
 GRANT SELECT ON GOVN.HUMAN TO 'lgReq'@'localhost';
 GRANT SELECT ON GOVN.EMPLOYEE TO 'lgReq'@'localhost';
 GRANT SELECT ON GOVN.ADULT TO 'lgReq'@'localhost';
 GRANT SELECT ON GOVN.DepOFFICERS TO 'lgReq'@'localhost';
 
 DROP USER IF EXISTS 'TUser'@'localhost';
 CREATE USER 'TUser'@'localhost' IDENTIFIED BY 'SKNG1234KNA';
 GRANT  SELECT ON GOVN.DWView TO 'TUser'@'localhost';
 GRANT  SELECT ON GOVN.GWView TO 'TUser'@'localhost';
 GRANT SHOW VIEW ON GOVN.* TO 'TUser'@'localhost';
GRANT SELECT ON GOVN.EmpPI TO 'TUser'@'localhost';
GRANT SELECT ON GOVN.CREDENTIALS TO 'TUser'@'localhost';
 
 DROP USER IF EXISTS 'SUser'@'localhost';
 CREATE USER 'SUser'@'localhost' IDENTIFIED BY 'S0998KNA';
 GRANT UPDATE ON GOVN.EMPLOYEE TO 'SUser'@'localhost';
 GRANT UPDATE ON GOVN.HUMAN TO 'SUser'@'localhost';
 GRANT UPDATE ON GOVN.GovOFFICERS TO 'SUser'@'localhost';
 GRANT UPDATE ON GOVN.DepOFFICERS TO 'SUser'@'localhost';
 GRANT  SELECT ON GOVN.EMPLOYEE TO 'SUser'@'localhost'; 
 GRANT  SELECT ON GOVN.HUMAN TO 'SUser'@'localhost'; 
 GRANT  SELECT ON GOVN.DWView TO 'SUser'@'localhost';
 GRANT  SELECT ON GOVN.GWView TO 'SUser'@'localhost';
 GRANT SELECT ON GOVN.EmpPI TO 'SUser'@'localhost';
 GRANT SHOW VIEW ON GOVN.* TO 'SUser'@'localhost';
 GRANT SELECT ON GOVN.CREDENTIALS TO 'SUser'@'localhost';
 
DROP USER IF EXISTS 'PUser'@'localhost';
 CREATE USER 'PUser'@'localhost' IDENTIFIED BY 'P6345SKN';
 GRANT ALL ON GOVN.* TO 'PUser'@'localhost';
 GRANT INSERT ON GOVN.* TO 'PUser'@'localhost';
 GRANT SHOW VIEW ON GOVN.* TO 'PUser'@'localhost';
 GRANT UPDATE ON GOVN.* TO 'PUser'@'localhost';
 GRANT DELETE ON GOVN.* TO 'PUser'@'localhost';
 GRANT SELECT ON GOVN.EmpPI TO 'PUser'@'localhost';
 GRANT SELECT ON GOVN.CREDENTIALS TO 'PUser'@'localhost';
 
 DROP USER IF EXISTS 'AUserSKNGOV'@'localhost';
 CREATE USER 'AUserSKNGOV'@'localhost' IDENTIFIED BY 'AKNAGov7492';
 GRANT ALL ON GOVN.* TO 'AUserSKNGOV'@'localhost';
 GRANT GRANT OPTION ON GOVN.* TO 'AUserSKNGOV'@'localhost';


######################################################################################
## INITIALIZATION (TEST) DATA##
 INSERT INTO GOVNOFFICES (Name,Island) VALUES
("Governor General Office","St. Christopher"),
("Prime Minister Office","St. Christopher"),
("Justice And Legal Affairs","St. Christopher"),
("Agriculuture, Cooperative, Fisheries","St. Christopher"),
("Finance","St. Christopher"),
("Lands and Housing","St. Christopher"),
("Consumer Affairs","St. Christopher"),
("Information","St. Christopher"),
("Tourism and International Transport","St. Christopher"),
("National Security","St. Christopher"),
("Health","St. Christopher"),
("Public Works, Energy and Public Utilities","St. Christopher"),
("Education","St. Christopher"),
("Social ANd Community Development, Culture and Gender Affairs","St. Christopher"),
("Foreign Affairs","St. Christopher"),
("Premier's Ministry","Nevis"),
("Agriculuture, Cooperative, Fisheries, Lands and Housing","Nevis"),
("Public Works, Utilities, Transport and Ports","Nevis"),
("Education and Human Resources","Nevis"),
("Finance","Nevis"),
("Tourism","Nevis"),
("Police","Nevis");
 
 INSERT INTO PAYMENTLIST(PID,Amt) VALUES
 ("K1",1040),   ## K1 TO K47 Scale
 ("K2",1207),   ## + 167
 ("K3",1374),("K4",1541),("K5",1708), ("K6",1875),("K7",2042),("K8",2209),("K9",2376),("K10",2543),("K11",2710),("K12",2877),("K13",3044),("K14",3211),("K15",3378),("K16",3545),("K17",3712),("K18",3879),("K19",4046),("K20",4213),("K21",4380),("K22",4547),("K23",4714),("K24",4881),("K25",5048),("K26",5215),("K27",5382),("K28",5549),("K29",5716),("K30",5883),("K31",6050),("K32",6217),("K33",6384),("K34",6551),("K35",6718),("K36",6885),("K37",7052),("K38",7219),("K39",7386),("K40",7553),("K41",7720),("K42",7887),("K43",8054),("K44",8221),("K45",8388),("K46",8555),("K47",8722);
 
 INSERT INTO DEPTYPE(Type) VALUES
 ("Airport"),
 ("Secondary School"),
 ("Office"),
 ("Primary School"),
 ("Customs");
 
 INSERT INTO DEPARTMENT (GID, Name,Type, Address, Street, City, Parish, Island, Tel) VALUES
 (8,"RLB Int'l Airport",1,NULL,NULL,"Basseterre","St. Goerges","St. Christopher",4658472),
 (13,"Saddlers Secondary School",2,NULL,"Upper Project","Saddlers","St. John","St. Christopher",4668493),
 (13,"Cayon Secondary School",2,"Big Drain","Gadwin Street","Cayon","St. Mary","St. Christopher",4650098);
 
INSERT INTO HUMAN (Fname, Mname, Lname, Oname, Gender, DOB, Height, Race, Eye_Color, BType, POB) VALUES
("Andre","Urban","Freeman",NULL,"M","1994:06:21",180,"Black","Brown","A+","St. Christopher"),
("Djavan","Kayode","Martin",NULL,"M","1992:08:11",176,"Black","Brown","0+","St. Christopher"),
("Ramon","Orlando","Perez","Liantaud","M","1993:11:11",170,"Latin","Brown","B-","Cuba"),
("Evan","Catner","Gruber",NULL,"M","1997:04:20",187,"Caucasion","Blue","AB+","Kingdom of Swaziland"),
("Verno","Banana","Federick","Patrick","M","1990:01:01",167,"Black","Brown","B-","St. Lucia");

INSERT INTO ADULT (HID, SSN, NID, Address, Street, City, Parish, Island, H_Tel, C_Tel, Email) VALUES
(1,231232,565434,NULL,"Edward Street","Saddlers","St. John","St. Christopher",4656932,6606580,"andre_freeman@live.com"),
(2,4554645,6453434,"No. 46","God-Wing Street","Frigate Bay","St. George","St. Christopher",4655331,6625364,"dkm@gmail.com"),
(3,64564,456324,"No. 24","Airport Road","Newtown","St. Goerge","St. Christopher",4663433,6603434,"ramonl@aol.com"),
(4,23234,552323,"Sands Complex","High Way #27","Sandy Point","St. Anne","St. Christopher",4655869,6643492,"gruber92@live.com"),
(5,49343,96563,"Main Street","Upper Project","Cayon","St. Mary","St. Chirstopher",4659999,6603943,"VF@yahoo.com");

INSERT INTO EMPLOYEE (HID, PID, Super_ID,Type,Since) VALUES
(1,"K25",NULL,"Computer Technition","2017:12:1"),
(2,"K47",NULL,"Prime Minister","2010:01:01"),
(3,"K30",2,"Head Teacher","2018:01:01"),
(4,"K20",NULL,"Permanent Secretary","2016:05:19"),
(5,"K25",NULL,"Air Traffic Controller","2015:09:11");

INSERT INTO GovOFFICERS (EID,APNT,GID) VALUES
(2,1,8),
(4,0,8);

INSERT INTO DepOFFICERS (EID, DID) VALUES
(3,2),
(5,1);

INSERT INTO CREDENTIALS (EID,Uname,Pass,Type) VALUES
(1,"Dre","1234",0),
(3,"Rayray","rrrr",2),
(4,"Evan","EEEE",3);