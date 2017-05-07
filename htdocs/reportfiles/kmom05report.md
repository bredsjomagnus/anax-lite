##Kmom05
###Gick det bra att komma igång med det vi kallar programmering av databas, med transaktioner, lagrade procedurer, triggers, funktioner?
Ja, det tycker jag. Boken och exemplen var till god hjälp för att få till delarna i sqlsciptet. Däremot var det inte helt lätt att sedan använda CALL i php för att få nytta av prodecuren. Det tog många timmar innan jag fick det att fungera.

###Hur är din syn på att programmera på detta viset i databasen?
Jag gillar idén att låta databasen sköta de delarn som är möjligt självmant. Så som jag gjorde att när status för en order ändras från notDelivered till delivered så skapas en faktura baserat på ordern.

Jag tycker också om möjligheten att kunna, via procedurer, slå samman förlopp och att man kan göra flera steg säkert pga commit/rollback. Använder detta för att, när man skapar en ny produkt, koppla samman produkt och katalog. Därmed räcker det med ett CALL för att kunna skapa produkt som inte finns med kategori som är ny, till att lägga till produkt som existerar fast med ny kategori. Har man väl gjort jobbet att fixa en bra procedur kan man ha mycket vinning av det senare.

###Några reflektioner kring din kod för backenden till webbshopen?
Jag använde exempelkoden som grund och har sedan ändrat och lagt till. Ville gärna ha fått med en kundvagn också. Men tiden rinner iväg och jag valde att begränsa mig lite för att få till ett bra gränssnitt till de andra delarna istället.

Tror jag börjar förstå hur det hela kan hänga ihop med relationer mellan tabeller. Valde att ha ett lager uppdelat i lagersektioner, hyllsektioner och hyllrader. Mest för att se om jag kunde fixa det och om jag verkligen förstått. Tycker att det blev rätt så överblickbart och kom att passa väl in i gränssnittet när man skall placera ut produkter på en hyllrad. Kul och lärorikt.

Som det är nu kan man inte lägga till kunder eller skapa ny order. Tänker att det är sådant som görs av kunden självt.


###Något du vill säga om koden generellt i och kring Anax Lite?
Bara att det blivit väldigt mycket och att man lätt kan se vinsten av uppdelning när det växer sig stort. Det blir extra viktigt att ha ordning på allt då, såklart.
