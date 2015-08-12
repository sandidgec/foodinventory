DROP TABLE IF EXISTS productPermissions;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS movement;
DROP TABLE IF EXISTS productLocation;
DROP TABLE IF EXISTS finishedProduct;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS vendor;
DROP TABLE IF EXISTS alertLevel;
DROP TABLE IF EXISTS unitOfMeasure;
DROP TABLE IF EXISTS user;

CREATE TABLE user(
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	firstName VARCHAR(32) NOT NULL,
	lastName VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL,
	phoneNumber CHAR(10) NOT NULL,
	attention VARCHAR(64),
	addressLineOne VARCHAR(64) NOT NULL,
	addressLineTwo VARCHAR(64),
	city VARCHAR(64)NOT NULL,
	state CHAR(2) NOT NULL,
	zipCode VARCHAR(10)NOT NULL,
	root TINYINT UNSIGNED NOT NULL,
	salt CHAR(64) NOT NULL,
	hash CHAR(128) NOT NULL,
	UNIQUE(email),
	UNIQUE(hash),
	PRIMARY KEY (userId)
);

CREATE TABLE unitOfMeasure(
	unitId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	quantity DECIMAL(9,3),
	unitCode VARCHAR(2),
	PRIMARY KEY (unitId)
);

CREATE TABLE alertLevel(
	alertId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	alertCode VARCHAR(2) NOT NULL,
	alertFrequency VARCHAR(2) NOT NULL,
	alertOperator CHAR(1) NOT NULL,
	alertPoint DECIMAL(9,3) NOT NULL,
	PRIMARY KEY (alertId)
);

CREATE TABLE vendor(
	vendorId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	contactName VARCHAR(64),
	vendorEmail VARCHAR(128),
	vendorName VARCHAR(64) NOT NULL ,
	vendorPhoneNumber CHAR(10),
	INDEX (contactName),
	INDEX (vendorEmail),
	INDEX (vendorName),
	PRIMARY KEY (vendorId)
);

CREATE TABLE product(
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	vendorId INT UNSIGNED NOT NULL,
	description VARCHAR(128),
	leadTime INT UNSIGNED NOT NULL,
	sku VARCHAR(64),
	title VARCHAR(32) NOT NULL,
	INDEX (vendorId),
	INDEX (sku),
	INDEX (title),
	PRIMARY KEY (productId),
	FOREIGN KEY (vendorId) REFERENCES vendor(vendorId)
);

CREATE TABLE productAlert (
	productId INT UNSIGNED,
	alertId INT UNSIGNED,
	alertEnabled TINYTEXT,
	INDEX (alertEnabled),
	FOREIGN KEY (productId) REFERENCES product (productId),
	FOREIGN KEY (alertId) REFERENCES alertLevel (alertId)
);

CREATE TABLE location(
	locationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	description VARCHAR(128)NOT NULL,
	storageCode VARCHAR(2) NOT NULL,
	PRIMARY KEY (locationId)
);

CREATE TABLE finishedProduct(
	finishedProductId INT UNSIGNED NOT NULL,
	rawMaterialId INT UNSIGNED NOT NULL,
	rawQuantity DECIMAL(9,3) UNSIGNED NOT NULL,
	PRIMARY KEY (finishedProductId, rawMaterialId),
	FOREIGN KEY (finishedProductId) REFERENCES product(productId),
	FOREIGN KEY (rawMaterialId )REFERENCES product(productId)
);

CREATE TABLE productLocation(
	locationId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	unitId INT UNSIGNED NOT NULL,
	quantity DECIMAL(9,3),
	PRIMARY KEY (locationId, productId, unitId),
	FOREIGN KEY (locationId) REFERENCES location(locationId),
	FOREIGN KEY (productId) REFERENCES product(productId),
	FOREIGN KEY (unitId) REFERENCES unitOfMeasure(unitId)
);

CREATE TABLE movement(
	movementId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	fromLocationId INT UNSIGNED NOT NULL,
	toLocationId INT UNSIGNED NOT NULL,
	productId INT UNSIGNED NOT NULL,
	unitId INT UNSIGNED NOT NULL,
	userId INT UNSIGNED NOT NULL,
	cost DECIMAL (8,2) NOT NULL,
	movementDate DATETIME NOT NULL,
	movementType VARCHAR(2) NOT NULL,
	price DECIMAL (8,2) NOT NULL,
	INDEX (fromLocationId),
	INDEX (toLocationId),
	INDEX (productId),
	INDEX (unitId),
	INDEX (userId),
	PRIMARY KEY (movementId),
	FOREIGN KEY (fromLocationId) REFERENCES location(locationId),
	FOREIGN KEY (toLocationId) REFERENCES location(locationId),
	FOREIGN KEY (productId) REFERENCES product(productId),
	FOREIGN KEY (unitId)REFERENCES unitOfMeasure(unitId),
	FOREIGN KEY (userId)REFERENCES user(userId)
);

CREATE TABLE notification(
	notificationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	alertId INT UNSIGNED NOT NULL,
	emailStatus TINYINT UNSIGNED NOT NULL,
	notificationContent VARCHAR(10000),
	notificationDateTime DATETIME NOT NULL,
	notificationHandle VARCHAR(10),
	INDEX (alertId),
	INDEX (emailStatus),
	PRIMARY KEY (notificationId),
	FOREIGN KEY (alertId) REFERENCES alertLevel(alertId)
);