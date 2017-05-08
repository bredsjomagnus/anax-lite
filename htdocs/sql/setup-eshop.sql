use maaa16;


SET NAMES utf8;

-- ------------------------------------------------------------------------
--
-- Setup tables
--

DROP TABLE IF EXISTS `Prod2Cat`;
DROP TABLE IF EXISTS `ProdCategory`;
DROP TABLE IF EXISTS ShelfRow;
DROP TABLE IF EXISTS ShelfSection;
DROP TABLE IF EXISTS InventorySection;
DROP TABLE IF EXISTS Inventory;
DROP TABLE IF EXISTS `OrderRow`;
DROP TABLE IF EXISTS `InvoiceRow`;
DROP TABLE IF EXISTS `Invoice`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS CartRow;
DROP TABLE IF EXISTS Cart;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Customer;

DROP PROCEDURE IF EXISTS insertProduct;
DROP PROCEDURE IF EXISTS addToStorage;

DROP TRIGGER IF EXISTS UpdateOrderDatetime;
DROP TRIGGER IF EXISTS OrderToInvoice;

DROP VIEW IF EXISTS prod2CatView;
DROP VIEW IF EXISTS InventoryIsolatedView;
DROP VIEW IF EXISTS InventoryConcatedView;
DROP VIEW IF EXISTS OrderView;
DROP VIEW IF EXISTS InvoiceView;


-- ------------------------------------------------------------------------
--
-- Product and product category
--
CREATE TABLE ProdCategory (
	cat_id VARCHAR(20),
    category VARCHAR(20),

	PRIMARY KEY (cat_id)
);

CREATE TABLE Product (
	articleid VARCHAR(20),
    title VARCHAR(20),
    image VARCHAR(100) DEFAULT 'noproductimage',
    description VARCHAR(200),
    price DECIMAL(9,2),

	PRIMARY KEY (articleid)
);

CREATE TABLE Prod2Cat (
	id INTEGER AUTO_INCREMENT,
	prod_id VARCHAR(20),
	cat_id VARCHAR(20),

	PRIMARY KEY (id),
    FOREIGN KEY (prod_id) REFERENCES Product (articleid), 
    FOREIGN KEY (cat_id) REFERENCES ProdCategory (cat_id) 
);

-- ------------------------------------------------------------------------
--
-- Inventory and shelfs
--

CREATE TABLE Inventory 
(
	id VARCHAR(50),
    
    PRIMARY KEY (id)
);

CREATE TABLE InventorySection 
(
	id VARCHAR(50),
    description VARCHAR(20),
    inventory VARCHAR(50),
    
    PRIMARY KEY (id),
    FOREIGN KEY (inventory) REFERENCES Inventory (id)
);

CREATE TABLE ShelfSection 
(
	id VARCHAR(50),
    description VARCHAR(200) DEFAULT NULL,
    inventorysection VARCHAR(50),
    
    PRIMARY KEY (id),
    FOREIGN KEY (inventorysection) REFERENCES InventorySection (id)
);
CREATE TABLE ShelfRow
(
	id VARCHAR(50),
    shelfsection VARCHAR(50),
    product VARCHAR(20),
    items INTEGER DEFAULT 0,
    space INTEGER DEFAULT 50,
    
    PRIMARY KEY (id),
    FOREIGN KEY (shelfsection) REFERENCES ShelfSection (id),
    FOREIGN KEY (product) REFERENCES Product (articleid)
);


-- CREATE TABLE `InvenShelf` (
--     `shelf` CHAR(6),
--     `description` VARCHAR(40),
-- 
-- 	PRIMARY KEY (`shelf`)
-- );
-- 
-- CREATE TABLE `Inventory` (
-- 	`id` INT AUTO_INCREMENT,
--     `prod_id` VARCHAR(20),
--     `shelf_id` CHAR(6),
--     `items` INT,
-- 
-- 	PRIMARY KEY (`id`),
-- 	FOREIGN KEY (`prod_id`) REFERENCES `Product` (articleid),
-- 	FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
-- );

------------------------------------------------------------------------
--
-- Customer
--
CREATE TABLE Customer
(
id INTEGER(5) AUTO_INCREMENT,
active CHAR(5) DEFAULT 'yes',
role CHAR(20) NOT NULL,
username VARCHAR(20) NOT NULL UNIQUE,
pass CHAR(100) NOT NULL,
forname CHAR(20) NOT NULL,
surname CHAR(20) NOT NULL,
email VARCHAR(50) NOT NULL,
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

PRIMARY KEY(id)
);

SELECT * FROM Customer;
-- ------------------------------------------------------------------------
--
-- Cart
--
CREATE TABLE Cart
(
	id INTEGER AUTO_INCREMENT,
    customer INTEGER,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated DATETIME DEFAULT NULL,
    deleted DATETIME DEFAULT NULL,
    
    PRIMARY KEY (id),
    FOREIGN KEY (customer) REFERENCES Customer (id)
);

CREATE TABLE CartRow
(
	id INTEGER AUTO_INCREMENT,
    cart INTEGER,
    product VARCHAR(20),
    items INTEGER,
    
    PRIMARY KEY (id),
    FOREIGN KEY (cart) REFERENCES Cart (id),
    FOREIGN KEY (product) REFERENCES Product (articleid)
);


-- ------------------------------------------------------------------------
--
-- Order
--
CREATE TABLE `Order` (
	`id` INT AUTO_INCREMENT,
    `customer` INT,
    `status` VARCHAR(20) DEFAULT 'notDelivered',
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`updated` DATETIME DEFAULT NULL,
	`deleted` DATETIME DEFAULT NULL,
	`delivery` DATETIME DEFAULT NULL,
    
	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `OrderRow` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `product` VARCHAR(20),
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (articleid)
);

-- ------------------------------------------------------------------------
--
-- Invoice
--
CREATE TABLE `Invoice` (
	`id` INTEGER,
    invoicestatus VARCHAR(20) DEFAULT 'notPayed',
    `order` INT,
    `customer` INT,
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payed DATETIME DEFAULT NULL,
    
	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `InvoiceRow` (
	`id` INT AUTO_INCREMENT,
    `invoice` INT,
    `product` VARCHAR(20),
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`invoice`) REFERENCES `Invoice` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (articleid)
);

-- ------------------------------------------------------------------------
--
-- SETTING UP PRODUCTS AND CATEGORIES
--
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Rollspel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Figurspel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Brädspel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Barnspel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Klassiskt')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Strategispel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Kortspel')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Eurogaming')
);
INSERT INTO ProdCategory
	(cat_id)
VALUES
(
	('Familjespel')
);



-- TRANSACTION AND PROCEDUR FOR ADDING NEW PRODUCTS
DELIMITER //

CREATE PROCEDURE insertProduct
(
	articleidinput VARCHAR(20),
    titleinput VARCHAR(20),
    descriptioninput VARCHAR(200),
    imageinput VARCHAR(100),
    priceinput DECIMAL(9,2),
	
	categoryinput VARCHAR(20)

)
BEGIN
	-- variabler
    DECLARE prodCategoryCount INTEGER;
    DECLARE prodAndCatCount INTEGER;
    DECLARE articleidCount INTEGER;
	
	-- TRANSACTION
	START TRANSACTION;
    
    -- sätter variabler
    SET prodCategoryCount = (SELECT COUNT(*) FROM ProdCategory WHERE cat_id = categoryinput);
    SET prodAndCatCount = (SELECT COUNT(*) FROM Prod2Cat WHERE prod_id = articleidinput AND cat_id = categoryinput);
    SET articleidCount = (SELECT COUNT(*) FROM Product WHERE articleid = articleidinput);
    -- SELECT articleidinput, categoryinput, articleidCount, prod2CatArticleCount, prodCategoryCount;
    -- ------------------------------------------------------------------------
	--
	-- OM kategorin finns i 'ProdCategory'
	-- 	OM produkten redan är inlagd i 'Product'	
	-- 	  OM Produkten och kategorin redan finns i 'Prod2Cat'
    -- 		ROLLBACK
    -- 	  ANNARS
    -- 		Sätt in articleid och cat_id i 'Prod2Cat
    -- 	ANNARS
    --   Sätt in artikel i 'Product' och i 'Prod2Cat'
    -- ANNARS
    --  ROLLBACK;
    
    IF prodCategoryCount > 0 THEN
		IF articleidCount > 0 THEN
			IF prodAndCatCount > 0 THEN
				ROLLBACK;
			ELSE
				INSERT INTO Prod2Cat
				(prod_id, cat_id)
				VALUES
				(
					articleidinput,
					categoryinput
				);
			COMMIT;
			END IF;
		ELSE
        
			INSERT INTO Product
				(articleid, title, image, description, price)
			VALUES
			(
				articleidinput,
                titleinput,
                imageinput,
				descriptioninput,
                priceinput
			);
			INSERT INTO Prod2Cat
				(prod_id, cat_id)
			VALUES
			(
				articleidinput,
				categoryinput
			);
        
        
        COMMIT;
        END IF;
        
	ELSE
		ROLLBACK;
		
	END IF;
END

//

DELIMITER ;


CALL insertProduct('art-schack', 'Schack', 'Det klassiska schacket som funnits med sedan tusentals år tillbaka.', 'chess128x128.jpg', 128.00, 'Brädspel');
CALL insertProduct('art-western', 'Western', 'Ett svenskt rollspel som hängt med sedan 80-talet. Är nu ute i sin 4:e version och utgåva.', 'noproductimage', 325.90, 'Rollspel');
CALL insertProduct('art-blood-bowl', 'Blood Bowl','Denna gamla klassiker har nu kommit i ny utgåva. I spelet ingår figurer för två lag - alver och orcher', 'noproductimage', 789.50, 'Figurspel');
CALL insertProduct('art-schack', 'Schack', 'Det klassiska schacket som funnits med sedan tusentals år tillbaka.', 'chess128x128.jpg', 128.00, 'Klassiskt');
CALL insertProduct('art-blood-bowl', 'Blood Bowl','Denna gamla klassiker har nu kommit i ny utgåva. I spelet ingår figurer för två lag - alver och orcher', 'noproductimage', 789.50,'Rollspel');
CALL insertProduct('art-memory', 'Memory', 'Det perfekta klassiska spelet där du inte behöver göra dig för att barent skall vinna.', 'noproductimage', 79.90,'Barnspel');
CALL insertProduct('art-memory', 'Memory', 'Det perfekta klassiska spelet där du inte behöver göra dig för att barent skall vinna.', 'noproductimage', 79.90, 'Klassiskt');
CALL insertProduct('art-xcom', 'XCOM', 'Ett intensivt spel som kräver stresståligt samarbete. Förbered dig på en utmanande kamp mot aliens.', 'xcom128x128.jpg', 689.00, 'Strategispel');

-- set profiling=1;
-- CALL insertProduct('art-monopoly', 'Schack', 'Det klassiska schacket som funnits med sedan tusentals år tillbaka.', 'chess128x128.jpg', 128.00, 'Brädspel');
-- show profiles;

-- SELECT * FROM Prod2Cat;
-- SELECT * FROM Product;

CREATE VIEW prod2CatView AS
SELECT
	P.articleid,
    P.image,
    P.title,
    P.description,
    P.price,
    GROUP_CONCAT(PC.cat_id) AS category
FROM Product AS P
	INNER JOIN Prod2Cat AS P2C
		ON P.articleid = P2C.prod_id
	INNER JOIN ProdCategory AS PC
		ON PC.cat_id = P2C.cat_id
GROUP BY P.articleid
;

-- SELECT * FROM prod2CatView;
-- SELECT * FROM Prod2Cat;
-- SELECT * FROM Product;


-- ------------------------------------------------------------------------
--
-- SETTING UP INVENTORY
--

INSERT INTO Inventory
	(id)
VALUES
(
	'mainstorage'
);
INSERT INTO InventorySection
	(id, description, inventory)
VALUES
(
	'storagesection_A',
    'A',
    'mainstorage'
);

INSERT INTO InventorySection
	(id, description, inventory)
VALUES
(
	'storagesection_B',
    'B',
    'mainstorage'
);

INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_A1',
    'A1',
    'storagesection_A'
);
INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_A2',
    'A2',
    'storagesection_A'
);
INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_A3',
    'A3',
    'storagesection_A'
);
INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_B1',
    'B1',
    'storagesection_B'
);
INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_B2',
    'B2',
    'storagesection_B'
);
INSERT INTO ShelfSection
	(id, description, inventorysection)
VALUES
(
	'shelfsection_B3',
    'B3',
    'storagesection_B'
);

-- TRANSACTION AND PROCEDUR FOR PUTTING ITEMS IN STORAGE
DELIMITER //

CREATE PROCEDURE addToStorage
(
    shelfsectioninput VARCHAR(50),
    shelfrowinput VARCHAR(200),
    articleidinput VARCHAR(20),
    itemsinput VARCHAR(100)

)
BEGIN
	-- variabler
	DECLARE shelfRowItemsStored INTEGER;
    DECLARE shelfRowSpace INTEGER;
    DECLARE shelfRowSpaceLeft INTEGER;
    DECLARE shelfRowCount INTEGER;
    DECLARE shelfrowproduct VARCHAR(50);
    
    -- set variables
    SET shelfRowItemsStored = (SELECT items FROM ShelfRow WHERE id = shelfrowinput);
	-- SELECT shelfRowSpaceLeft;
    
    SET shelfRowSpace = (SELECT space FROM ShelfRow WHERE id = shelfrowinput);
    -- SELECT shelfRowSpace;
    
    SET shelfRowSpaceLeft = (shelfRowSpace - itemsinput);
    -- SELECT shelfRowSpaceLeft;
    
    SET shelfRowCount = (SELECT COUNT(*) FROM ShelfRow WHERE id = shelfrowinput);
    -- SELECT shelfRowCount;
    
    SET shelfrowproduct = (SELECT product FROM ShelfRow WHERE id = shelfrowinput);
    -- SELECT shelfrowproduct;
    
    
	-- TRANSACTION
	START TRANSACTION;
    
    IF shelfRowCount = 0 THEN
		INSERT INTO ShelfRow
			(id, shelfsection, product, items)
		VALUES
		(
			shelfrowinput,
			shelfsectioninput,
			articleidinput,
			itemsinput
		);
        
        COMMIT;
	ELSE
		IF shelfrowproduct = articleidinput THEN
			UPDATE ShelfRow
			SET
				items = items + itemsinput
			WHERE
				id = shelfrowinput;
			
            COMMIT;
		ELSE
			ROLLBACK;
		END IF;
	END IF;
END

//

DELIMITER ;

-- , ShelfSection.id, ShelfRow.id, Prouduct.articleid, ShelfRow.items
CALL addToStorage('shelfsection_B2', 'B2-002', 'art-xcom', 12); 
CALL addToStorage('shelfsection_B2', 'B2-002', 'art-xcom', 8); 
CALL addToStorage('shelfsection_A1', 'A1-010', 'art-xcom', 8);
CALL addToStorage('shelfsection_A1', 'A1-010', 'art-xcom', 2); 
CALL addToStorage('shelfsection_A2', 'A2-002', 'art-xcom', 2);
CALL addToStorage('shelfsection_A1', 'A1-009', 'art-schack', 15);
CALL addToStorage('shelfsection_A2', 'A2-001', 'art-western', 11);

CREATE VIEW InventoryConcatedView AS
SELECT
	Inv.id AS inventory,
	GROUP_CONCAT(InvS.description ORDER BY InvS.description ASC SEPARATOR ', ') AS storagesection,
    GROUP_CONCAT(SS.description ORDER BY SS.description ASC SEPARATOR ', ') AS shelfsection,
	GROUP_CONCAT(SR.id ORDER BY SR.id ASC SEPARATOR ', ') AS shelfrowid,
	GROUP_CONCAT(SR.items SEPARATOR ', ') AS items,
    P.articleid,
    P.title
FROM ShelfRow AS SR
	INNER JOIN ShelfSection AS SS
		ON SR.shelfsection = SS.id
	INNER JOIN InventorySection AS InvS
		ON SS.inventorysection = InvS.id
	INNER JOIN Inventory AS Inv
		ON InvS.inventory = Inv.id
    INNER JOIN Product AS P
		ON SR.product = P.articleid
GROUP BY P.title
ORDER BY shelfrowid ASC
;

CREATE VIEW InventoryIsolatedView AS
SELECT
	Inv.id AS inventory,
	InvS.description AS storagesection,
    SS.description AS shelfsection,
	SR.id AS shelfrowid,
	SR.items AS items,
    P.articleid,
    P.title
FROM ShelfRow AS SR
	INNER JOIN ShelfSection AS SS
		ON SR.shelfsection = SS.id
	INNER JOIN InventorySection AS InvS
		ON SS.inventorysection = InvS.id
	INNER JOIN Inventory AS Inv
		ON InvS.inventory = Inv.id
    INNER JOIN Product AS P
		ON SR.product = P.articleid
ORDER BY shelfrowid ASC
;

-- Lägger till kunder
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'Kronan', '$2y$10$n8BQHjTCe.ltgViBMW5q0en2g3V8dupJmlWMJcgXn6MLteOJhAKgq', 'Daniel', 'Kronqvist', 'daniel.kronqvist@gmail.com'); -- kronan
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'bredsjoanna', '$2y$10$fi5RSMbrH5rCEqLkurf1SOI26U0AG2jgqhZn4nbYPfBO2t1V95ej.', 'Anna', 'Eriksson', 'bredsjoanna@gmail.com'); -- fisk
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'mand75', '$2y$10$FZADp/m5yJjXOZVTf/0lFeqi3OAQR/jBxjc1T99z2gOmD8xXKzUTm', 'Maria', 'Nord', 'mand75@hotmail.com'); -- mand
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'mromarboss', '$2y$10$UH8JF1OxvCJ5XmujzMUImewlvWRz2SZcPW861WNScdgILPBj7iYQS', 'Omar', 'Nuur', 'mrnomar_boss@gmail.com'); -- boss
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'tintin', '$2y$10$XgskhnGsTLIczYn4h2djMO1/twDaMXwCTJZFxO9amYykuNeBzGz2C', 'Martin', 'Karlsson', 'jktintin_88@hotmail.com'); -- tintin
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'kr_68', '$2y$10$zL07u41axnE.ei59x7Hrx.LP9hkl2qgUd44CfQEdsZZY0PtJBJMsq', 'Kristina', 'Ratcher', 'ratcher68@hotmail.com'); -- kristina
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'mrsmiss', '$2y$10$fHsLBWbf6kdLs6tRKGfTF.octwVFB.40RHncXCS4LiqTUTDjftGx6', 'Liv', 'Alared', 'lalred83@gmail.com'); -- liv
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'helle', '$2y$10$/QqVJ2693qwjgMhXXMpEOOcykBn80OuBaNnZ4X7s5L1f7oD5/uCW.', 'Helen', 'Henriksson', 'helhaik65@yahoo.se'); -- helle
INSERT INTO Customer (role, username, pass, forname, surname, email) VALUES ('customer', 'klara', '$2y$10$tTFc1b/FT8QOyMVIpcbZreOtKdiTc2/PGpZkmogGEA6fEZVDWm0Vm', 'Klara', 'Ericsson', 'bredsjoklara@gmail.com'); -- klara


CREATE TRIGGER UpdateOrderDatetime
	AFTER INSERT ON OrderRow
    FOR EACH ROW
    UPDATE `Order` SET updated = NOW() WHERE id = NEW.order;

-- DELIMITER //
-- CREATE TRIGGER OrderToInvoice   
-- ON `Order`   
-- AFTER UPDATE AS  
-- /*Check whether columns 7, have been updated. If any or all  
--  columns 2, 3 or 4 have been changed, create an audit record. The   
-- bitmask is: power(2,(7-1) = 64. To test   
-- whether all columns 2, 3, and 4 are updated, use = 14 instead of >0  
--  (below).*/  
-- 
-- 	IF (COLUMNS_UPDATED() & 64) = 64  
-- 	/*Use IF (COLUMNS_UPDATED() & 64) = 64 to see whether column 7 are updated.*/  
-- 	
-- 	BEGIN  
-- 		INSERT INTO Invoice (`order`, customer) VALUES (OLD.id, OLD.customer);
--    END;  
-- DELIMITER ;


DELIMITER //

CREATE TRIGGER OrderToInvoice   
AFTER UPDATE ON `Order` FOR EACH ROW

BEGIN
	DECLARE oldstatus VARCHAR(20);
    DECLARE newstatus VARCHAR(20);
    DECLARE invoiceid INTEGER;
    SELECT OLD.status INTO oldstatus;
    SELECT NEW.status INTO newstatus;
    IF oldstatus = 'notDelivered' AND newstatus = 'delivered' THEN
		INSERT INTO Invoice (id, `order`, customer) VALUES (OLD.id, OLD.id, OLD.customer);
        INSERT INTO InvoiceRow (invoice, product, items) SELECT `order` AS Invoice, product, items FROM OrderRow WHERE `order` = OLD.id;
    END IF;
END
//
DELIMITER ;


-- NY ORDER för customer 2
INSERT INTO `Order`
(
	customer
)
VALUES
(
	2
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	1,
    'art-schack',
    1
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	1,
    'art-memory',
    3
);

-- NY ORDER för customer 3
INSERT INTO `Order`
(
	customer
)
VALUES
(
	3
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	2,
    'art-blood-bowl',
    1
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	2,
    'art-xcom',
    1
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	2,
    'art-western',
    1
);

-- NY ORDER FÖR CUSTOMER 4
INSERT INTO `Order`
(
	customer
)
VALUES
(
	4
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	3,
    'art-blood-bowl',
    1
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	3,
    'art-xcom',
    1
);

-- NY ORDER FÖR CUSTOMER 4
INSERT INTO `Order`
(
	customer
)
VALUES
(
	4
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	4,
    'art-memory',
    1
);
INSERT INTO OrderRow
(
	`order`,
    product,
    items
)
VALUES
(
	4,
    'art-western',
    1
);

SELECT * FROM `Order`;
UPDATE `Order` SET `status` = 'delivered', delivery = NOW() WHERE id = 3;
-- UPDATE Invoice SET invoicestatus = 'payed', payed = NOW() WHERE id = 3;

CREATE VIEW OrderView AS
SELECT
	O.id AS orderid,
    O.status AS orderstatus,
    GROUP_CONCAT(ORow.product SEPARATOR ', ') AS product,
    GROUP_CONCAT(P.title SEPARATOR ', ') AS producttitle,
    GROUP_CONCAT(ORow.items SEPARATOR ', ') AS items,
    GROUP_CONCAT(P.price SEPARATOR ', ') AS productprice,
    O.customer AS customerid,
    C.forname AS firstname,
    C.surname AS surname,
    C.email AS email,
    O.created AS created,
    O.updated AS updated,
    O.delivery AS delivered
FROM OrderRow AS ORow
	INNER JOIN `Order` AS O
		ON ORow.order = O.id
	INNER JOIN Customer AS C
		ON O.customer = C.id
	INNER JOIN Product AS P
		ON ORow.product = P.articleid
GROUP BY orderid
;

EXPLAIN OrderView;
EXPLAIN SELECT * FROM OrderView;


CREATE VIEW InvoiceView AS
SELECT
	I.id AS invoiceid,
    I.invoicestatus AS invoicestatus,
    GROUP_CONCAT(IRow.product SEPARATOR ', ') AS product,
    GROUP_CONCAT(P.title SEPARATOR ', ') AS producttitle,
    GROUP_CONCAT(IRow.items SEPARATOR ', ') AS items,
    GROUP_CONCAT(P.price SEPARATOR ', ') AS productprice,
    I.customer AS customerid,
    C.forname AS firstname,
    C.surname AS surname,
    C.email AS email,
    I.created AS created,
    I.payed AS payed
FROM InvoiceRow AS IRow
	INNER JOIN Invoice AS I
		ON IRow.invoice = I.id
	INNER JOIN Customer AS C
		ON I.customer = C.id
	INNER JOIN Product AS P
		ON IRow.product = P.articleid
GROUP BY invoiceid
;

SELECT * FROM OrderView;
SELECT * FROM InvoiceView;

-- INSERT INTO InvoiceRow SELECT id, `order` AS invoice, product items FROM OrderRow WHERE `order` = 1;

-- SELECT * FROM InvoiceRow WHERE `order` = 3;


-- SELECT * FROM Customer;
-- SELECT * FROM ShelfSection;
-- SELECT * FROM ShelfRow WHERE items = 0;
-- SELECT * FROM InventoryConcatedView;
-- SELECT * FROM InventoryConcatedView WHERE storagesection LIKE '%A%';
-- SELECT shelfrowid, articleid FROM InventoryIsolatedView WHERE shelfsection = 'A1';

-- SELECT articleid FROM Product;
-- InventoryIsoladedView ger möjlighet att ta ut enbart delar av inventoryt. Speciellt om man kör concat på sökfrågan.
-- SELECT GROUP_CONCAT(shelfsection), GROUP_CONCAT(shelfrowid), title, GROUP_CONCAT(items) FROM InventoryIsolatedView WHERE storagesection = 'A' GROUP BY title;
-- SELECT GROUP_CONCAT(shelfsection), GROUP_CONCAT(shelfrowid), title, GROUP_CONCAT(items) FROM InventoryIsolatedView GROUP BY title;


-- ----------------------- 
-- Indexering 
-- -----------------------
-- - se index
-- SHOW INDEX FROM Course;

-- - likvärdiga varianter att skapa unique index
-- ALTER TABLE Course ADD CONSTRAINT nick_unique UNIQUE (nick);
-- CREATE UNIQUE INDEX nick_unique ON Course (nick);

-- - skapa index
-- CREATE INDEX index_name ON Course(name);
-- ta bort index
-- DROP INDEX nick_unique ON Course;

-- - fulltext index
-- CREATE FULLTEXT INDEX full_name ON Course(name);
-- - sökning av fulltext index
-- SELECT name, MATCH(name) AGAINST ("Program* web*" IN BOOLEAN MODE) AS score FROM Course ORDER BY score DESC;
-- - ta bort fulltext index
-- DROP INDEX fulltext_name ON Course;

-- - hur skapas tabell. Lägg till \G om skriver i cli
-- SHOW CREATE TABLE Course



-- SHELFSECTION
-- - Utan index ger sökning på ShelfSection description en full tabellsökning.
EXPLAIN SELECT * FROM ShelfSection WHERE description = 'A1';

-- - Med unique index söktes bara en rad
CREATE UNIQUE INDEX unique_description ON ShelfSection (description);


