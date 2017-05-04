-- show databases;
use maaa16;

drop table if exists accounts;

create table if not exists accounts
(
id int(5) auto_increment primary key,
active char(5) default 'yes',
role char(20) not null,
username varchar(20) not null unique,
pass char(100) not null,
forname char(20) not null,
surname char(20) not null,
email varchar(50) not null,
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('admin', 'magand', '$2y$10$Gh3Im3MDUkXx8CAgR6TEZOR9J9hR08G8UMrI25qMvRV1iXNvslK0i', 'Magnus', 'Andersson', 'magnusandersson076@gmail.com'); -- pass
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'Kronan', '$2y$10$n8BQHjTCe.ltgViBMW5q0en2g3V8dupJmlWMJcgXn6MLteOJhAKgq', 'Daniel', 'Kronqvist', 'daniel.kronqvist@gmail.com'); -- kronan
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'bredsjoanna', '$2y$10$fi5RSMbrH5rCEqLkurf1SOI26U0AG2jgqhZn4nbYPfBO2t1V95ej.', 'Anna', 'Eriksson', 'bredsjoanna@gmail.com'); -- fisk
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mand75', '$2y$10$FZADp/m5yJjXOZVTf/0lFeqi3OAQR/jBxjc1T99z2gOmD8xXKzUTm', 'Maria', 'Nord', 'mand75@hotmail.com'); -- mand
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mromarboss', '$2y$10$UH8JF1OxvCJ5XmujzMUImewlvWRz2SZcPW861WNScdgILPBj7iYQS', 'Omar', 'Nuur', 'mrnomar_boss@gmail.com'); -- boss
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'tintin', '$2y$10$XgskhnGsTLIczYn4h2djMO1/twDaMXwCTJZFxO9amYykuNeBzGz2C', 'Martin', 'Karlsson', 'jktintin_88@hotmail.com'); -- tintin
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'kr_68', '$2y$10$zL07u41axnE.ei59x7Hrx.LP9hkl2qgUd44CfQEdsZZY0PtJBJMsq', 'Kristina', 'Ratcher', 'ratcher68@hotmail.com'); -- kristina
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mrsmiss', '$2y$10$fHsLBWbf6kdLs6tRKGfTF.octwVFB.40RHncXCS4LiqTUTDjftGx6', 'Liv', 'Alared', 'lalred83@gmail.com'); -- liv
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'helle', '$2y$10$/QqVJ2693qwjgMhXXMpEOOcykBn80OuBaNnZ4X7s5L1f7oD5/uCW.', 'Helen', 'Henriksson', 'helhaik65@yahoo.se'); -- helle
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'klara', '$2y$10$tTFc1b/FT8QOyMVIpcbZreOtKdiTc2/PGpZkmogGEA6fEZVDWm0Vm', 'Klara', 'Ericsson', 'bredsjoklara@gmail.com'); -- klara
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('admin', 'admin', '$2y$10$Ml94egY/SRVxswtwPlUXbeeoe.t8krAXcb7t0r6U74uXOMtooirBu', 'admin', 'admin', 'admin@admin.se'); -- admin
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'doe', '$2y$10$GRrdHbpyhiVVdVCRfTh4E.Og72bo8VPj/Fh4HAeapEiSSl10WoS.C', 'doe', 'doe', 'doe@doe.se'); -- doe


select * from accounts;

-- SELECT * FROM accounts where username LIKE 'magand' order by id asc limit 3;

-- select * from accounts where binary username = binary'Magand';

-- show tables;



--
-- Create table for Content
--
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content`
(
  `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `path` CHAR(120) UNIQUE,
  `slug` CHAR(120) UNIQUE,
  `title` VARCHAR(120),
  `data` TEXT,
  `type` CHAR(20),
  `filter` VARCHAR(80) DEFAULT NULL,
  `status` CHAR(20) DEFAULT 'notPublished',

  -- MySQL version 5.6 and higher
  -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 
  -- MySQL version 5.5 and lower
  `published` DATETIME DEFAULT NULL,
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,
  `deleted` DATETIME DEFAULT NULL

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `content` (`path`, `slug`, `type`, `title`, `data`, `filter`) VALUES
    ("hem", null, "page", "Hem", "Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", "bbcode,nl2br"),
    ("om", null, "page", "Om", "Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", "markdown"),
    ("blogpost-1", "valkommen-till-min-blogg", "post", "Välkommen till min blogg!", "Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", "link,nl2br"),
    ("blogpost-2", "nu-har-sommaren-kommit", "post", "Nu har sommaren kommit", "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.", "nl2br"),
    ("blogpost-3", "nu-har-hosten-kommit", "post", "Nu har hösten kommit", "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost", "nl2br");
     
INSERT INTO content (path, slug, type, title, data, filter, status, published) VALUES ('fiska', 'fiska', 'page', 'Nattfiske','Att fiska i natten\n-------------\nDenna sida handlar om nattfiske\n\nDet finns gott om fisk att fånga om man har rätt utrustning och teknik.\n\n####Utrusting\n* Drag\n* Klädsel', 'markdown', 'Published', NOW());
INSERT INTO content (path, slug, type, title, data, filter, status, published) VALUES ('ardennerpost', 'enemy-action-ardenner', 'post', 'Enemy Action - Ardennes','###Tabletop simulator\n\nNu har jag äntligen fått klart en tabletopsimulatormodul för EA - Ardennes. Dock inte alla tre spellägena. Allierad solo kvarstår.\n\n![ardenner](http://i.imgur.com/0HUJNGT.png "Logo Title Text 1")', 'markdown', 'Published', NOW());
INSERT INTO content (path, slug, type, title, data, filter, status, published) VALUES ('tagluffpost', 'tagluff', 'post', 'Tågluff','###Tågluffa i Europa\n\nDet är mycket jobb innan, med planering och bokningar. Men det är samtidigt ett äventyr. Framför allt för barnen.\n\nI sommar bär det iväg.', 'markdown', 'Published', NOW());
INSERT INTO content (path, slug, title, data, type, filter, status, published) VALUES ('', 'info', 'info', '####Textblock\r\n\r\n###INFORMATION\r\n\r\nFrån [url=https://sv.wikipedia.org/wiki/Information]Wikipedia[/url]:\r\n\r\n[b]Information[/b] uttrycker [kunskap](https://sv.wikipedia.org/wiki/Kunskap) eller budskap i en konkret form, och består ofta men inte alltid av en samling [fakta](https://sv.wikipedia.org/wiki/Faktum). Information utgör substans[innehållet](https://sv.wikipedia.org/wiki/Inneh%C3%A5ll) i de meddelanden som överförs vid [kommunikation](https://sv.wikipedia.org/wiki/Kommunikation) och utgör också substansinnehållet i olika typer av lager av kunskap och budskap, som en [bok](https://sv.wikipedia.org/wiki/Bok) eller [databas](https://sv.wikipedia.org/wiki/Databas).\r\n\r\nInformation återfinns som substansinnehållet vid användning av [tal](https://sv.wikipedia.org/wiki/Tal_(spr%C3%A5k)), [skrift](https://sv.wikipedia.org/wiki/Skrift), [symboler](https://sv.wikipedia.org/wiki/Symbol), [bilder](https://sv.wikipedia.org/wiki/Bild) och som kodat [data](https://sv.wikipedia.org/wiki/Data_(representation)) anpassat för specifika media som [datorer](https://sv.wikipedia.org/wiki/Dator).\r\n\r\nOrdagrant härstammar ordet från latinets informare vilket skulle ge betydelsen ”att ge form (åt)” eller ”utforma”.', 'block', 'markdown,bbcode', 'Published', NOW());
INSERT INTO content (path, slug, title, data, type, filter, status, published) VALUES (NULL, 'lista', 'dbmodelleringslista', '####Listblock\r\n\r\nDatabasmodelleringens 10 steg\r\n\r\n1. [b]Konceputell[/b]\r\n  * Beskriv databasen i ett textstycke.\r\n  * Skriv ned alla entiteter.\r\n  * Skriv ned alla relationer och visa i matris.\r\n  * Rita enkelt ER-diagram med entiteter och relationer.\r\n  * Komplettera ER-diagram med kardinalitet.\r\n  * Komplettera ER-diagram med alla attribut samt kandidatnycklar.\r\n2. [b]Logisk[/b]\r\n  * Modifiera ER-diagram enligt relationsmodellen.\r\n  * Utöka ER-diagram med primära/främmande nycklar samt kompletterande attribut.\r\n3. [b]Fysisk[/b]	\r\n  * Skapa SQL DDL för tabellerna.\r\n  * Lista funktioner som databasen skall stödja (API).', 'block', 'markdown,bbcode', 'Published', NOW());
INSERT INTO content (path, slug, title, data, type, filter, status, published) VALUES (NULL, 'progbild', 'progbild', '####Bildblock\r\n\r\n![size_50](https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSdzQks1G8Lp2Pfqt8d8UkU2nuoeWZWO0KYHyoP8csmBx7T6jatog)\r\n\r\n[i]Bild som är fri att användas.[/i]', 'block', 'markdown,bbcode', 'Published', NOW());
INSERT INTO content (path, slug, title, data, type, filter, status, published) VALUES (NULL, 'kmom04', 'Redovisning kmom04', '##Kmom04\r\n\r\nNu är jag helt slut. Detta var ännu en mastodontuppgift. Familjen börjar undra var jag tagit vägen.\r\n\r\nMen det har varit ett kul och utmanande kursmoment och jag hoppas att jag fick med allt och lite till.\r\n\r\n###Finns något att säga kring din klass för textfilter, eller rent allmänt om formattering och filtrering av text som sparas i databasen av användaren?\r\nDetta var en rolig och utmanande del att göra och utan regex101 till hjälp hade jag nog gått bet.\r\n\r\nAnvändaren får möjlghet att lägga in text via bloggen. Då kan användaren välja filter via checkbox, men inte ordning. Detta för att få den bästa ordningen av de valen som gjorts. Man kan även förhandsgranska för att se vad de valda filtren gör med texten.\r\n\r\n###Berätta hur du tänkte när du strukturerade klasserna och databasen för webbsidor och bloggposter?\r\nJag gjorde en klass som har hjälpfunktioner till detta - Content. Den ser till att slug alltid är unikt genom att lägga till -2, -3 eller vad som krävs efter slugnamnet om så behövs. Den ser även till att kontrollera path att den sätts till null om så behövs.\r\n\r\nDet är en admin som har kontrollen via adminsidan och kan lägga till, redigera eller ta bort. Det är bara admin som kan skapa nya sidor och block. Medan både användaren och admin kan skapa bloggposter.\r\n\r\nJag valde att lägga till möjlighet för admin att publisera eller ickepublicera en post, page eller block. Det kommer inte synas för en användare om det inte är publiserat. Default läget när användaren lägger till en bloggpost är att det är publiserat. Men admin måste publisera efter tillägg för att det skall synas. Admin har däremot möjlighet att se pages även om de inte är publiserade via adminsidan.\r\n\r\n\r\n###Förklara vilka routes som används för att demonstrera funktionaliteten för webbsidor och blogg (så att en utomstående kan testa).\r\nRouten för page är helt enkelt page och för blog är det blog. Man kan se hur blocks fungerar via routen blocktest. Men allt finns även i dropdown-menyn \'Uppgifter\'.\r\n\r\n###Hur känns det att dokumentera databasen så här i efterhand?\r\nGillade verkligen hur smidigt det var att få till diagrammet med reverse engineering. Förstår att det finns stor vinning med detta när det börjar bli stort och invecklat och även efter att det gått viss tid och man vill få kolla på läget igen. \r\n\r\nDäremot ville det sig inte helt med data exporten av koden. Fick skumma felmeddelanden i sql-filen.\r\n\r\n###Om du är självkritisk till koden du skriver i Anax Lite, ser du förbättringspotential och möjligheter till alternativ struktur av din kod?\r\nJa, absolut. Framför allt vet jag att mitt sätt att få till stilen inte är optimal. Men det är det bästa jag kommit på så här långt. Nu skickar jag med path via route till headern för varje route som skapas. Blir lite omständigt och jag märker att det ställer till det med att bilder inte alltid syns i vissa lägen.\r\n\r\nSen finns det säker mer. Men det är vad jag kan komma på på rak arm.\r\n', 'block', 'markdown,bbcode', 'Published', '2017-04-23 17:30:26');

SELECT * FROM content;



-- ------------------------------------------------------------------------
--
-- ESHOP
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
