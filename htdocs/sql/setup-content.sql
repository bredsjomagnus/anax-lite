-- CREATE DATABASE IF NOT EXISTS kmom04;
use maaa16;

-- show tables;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

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