DROP TABLE IF EXISTS productPermissions;
DROP TABLE IF EXISTS productLocation;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS alertLevel;
DROP TABLE IF EXISTS movement;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS unitOfMeasure;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	email VARCHAR(128) NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	lastName VARCHAR(32) NOT NULL,
	phoneNumber CHAR(10) NOT NULL,
	attention VARCHAR(64),
	addressLineOne VARCHAR(64) NOT NULL,
	addressLIneTwo VARCHAR(64),
	city VARCHAR(64)NOT NULL,
	state CHAR(2) NOT NULL,
	zip VARCHAR(10)NOT NULL,
	salt CHAR(64) NOT NULL,
	hash CHAR(128) NOT NULL,
	UNIQUE(email),
	UNIQUE(hash),
	PRIMARY KEY (userId)
);

CREATE TABLE unitOfMeasure(
	unitId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	unitCode VARCHAR(2),
	quantity DECIMAL(9,3),
	PRIMARY KEY (unitId)
);

CREATE TABLE product(
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	description VARCHAR(128),
	PRIMARY KEY (productId)
);

CREATE TABLE location(
	locationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	description VARCHAR(128)NOT NULL,
	storageCode VARCHAR(2) NOT NULL,
	PRIMARY KEY (locationId)
);

CREATE TABLE movement(
	movementId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	toLocationId INT UNSIGNED NOT NULL,
	fromLocationId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	userId INT UNSIGNED NOT NULL,
	unitId INT UNSIGNED NOT NULL,
	movementType VARCHAR(2),
	movementDate DATETIME NOT NULL,
	price DECIMAL (8,2) NOT NULL,
	cost DECIMAL (8,2) NOT NULL,
	INDEX (productId),
	INDEX (toLocationId),
	INDEX (fromLocationId),
	INDEX (unitId),
	INDEX (userId),
	FOREIGN KEY(productId) REFERENCES product(productId),
	FOREIGN KEY(toLocationId) REFERENCES location(locationId),
	FOREIGN KEY (fromLocationId) REFERENCES location(locationId),
	FOREIGN KEY (unitId)REFERENCES unitOfMeasure(unitId),
	FOREIGN KEY (userId)REFERENCES user(userId),
	PRIMARY KEY (movementId)
);

CREATE TABLE alertLevel(
	alertId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	alertCode VARCHAR(2) NOT NULL,
	alertLevel DECIMAL(9,3) NOT NULL ,
	alertFrequency VARCHAR(2)NOT NULL,
	alertOperator CHAR(1) NOT NULL ,
	PRIMARY KEY (alertId)
);

CREATE TABLE notification(
	notificationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	alertId INT UNSIGNED NOT NULL,
	twilioId CHAR(34),
	twilioStatus CHAR(1),
	notificationHandle VARCHAR(10),
	notificationDateTime DATETIME NOT NULL,
	notificationContent VARCHAR(160),
	INDEX (twilioId),
	INDEX (alertId),
	INDEX (twilioStatus),
	FOREIGN KEY(alertId) REFERENCES alertLevel(alertId),
	PRIMARY KEY (notificationId)
);

CREATE TABLE productLocation(
	locationId INT UNSIGNED NOT NULL,
	unitId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	quantity DECIMAL(9,3),
	INDEX(locationId),
	INDEX (unitId),
	INDEX (productId),
	FOREIGN KEY (locationId)REFERENCES location(locationId),
	FOREIGN KEY (unitId)REFERENCES unitOfMeasure(unitId),
	FOREIGN KEY (productId)REFERENCES product(productId),
	PRIMARY KEY (locationId, unitId, productId)
);

CREATE TABLE productPermissions(
	userId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	accessLevel CHAR(1) NOT NULL ,
	PRIMARY KEY (userId, productId)
);