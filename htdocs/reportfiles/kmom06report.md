##Kmom06

Det är tydligt att phpunit och Cygwin inte riktigt går ihop. Hade strul att få det att fungera, när jag skulle testa i Anax-lite. Men tillslut löste det sig och även testernna kom på plats.

Det känns verkligen att kursen tagit med mycket och gått både på djupet och på bredden. Det var skönt att äntligen kunna lämna in redovisningen för sista kursmomentet och mentalt börja ladda för kmom07/10.

###Vad du bekant med begreppet index i databaser sedan tidigare?
Inte på det sättet som vi använt det nu. Kände inte till att man kunde kolla hur stor sökningen var och att man med EXPLAIN kunde få ner sökningsområdet och optimera. Det ver inte alls dumt att få se och lära om det här. Det blir ju väldigt viktigt när databasen är stor - att få den så snabbarbetad som möjligt.

###Berätta om hur du jobbade i uppgiften om index och vilka du valde att lägga till och skillnaden före/efter.
Jag valde att lägga index i tre tabeller; content (som innehåller posts, pages och block), accounts (som har användarna) och ShelfSection (som är en hyllsektion i lagret). Två av dem, ShelfSection och content valde jag att indexera en kolumn i vardera; description (beskrivning/namnet på hyllsectionen) respektive title (titel på content). Båda dessa sänkte antalet rader från full tabellsökning till enbart en rad. I den tredje tabellen, accounts, skapades ett unique index på email då dessa inte skall kunna vara dubbletter. Därmed gick sökning på email i accounts från full tabellsökning till en rad.

Jag tyckte index på dessa ställen var rimliga då det kan vara vanliga kolumnet att söka i och vad gäller email kändes det naturligt att begränsa till unique även för att det inte skall gå att lägga in två konton med samma email.

###Har du tidigare erfarenheter av att skriva kod som testar annan kod?
Lite grann sedan tidigare kurser - i Python. Men inte mer än så.

###Hur ser du på begreppet enhetstestning och att skriva testbar kod?
Det är en trygghet att kunna testa så att det fungerar som tänkt och är något som jag kommer att ha med mig i fortsättningen när jag skriver klasser. Att se till att få med bitar som gör det lätt att via phpunit kontrollera funktionaliteten.

Kan tänka mig att man som utvecklare inte använder sin produkt på samma vis som användaren alla gånger. Därmed riskerar fel att följa med som inte upptäckts på grund av det. Med tester kan man säkerligen komma åt fler av dem än man gjort annars.

###Hur gick det att hitta testbar kod bland dina klasser i Anax Lite?
Att göra testen för makeGuess var inga större problem. Men när jag skulle till att testa i Anax-lite så ville det inte längre. Jag kunde, på grund av Cygwin, inte använda make-kommandot vilket gjode det lite rörigt. Sen fick jag kostiga fel, som att den klagade på en fil som inte ens testades.

När jag väl fick det att fungera blev det test skrivet för enbart en av klasserna. Men kodtäckningen för den klassen blev 100%.

Klassen jag valde var Textfilterklassen, som jag tidigare tänkt, skulle vara toppen om man kunde testa. När jag skrev den klassen valde jag att i brist på annat att kunna förhandsgranska hur det blev i browsern. Så, i och med detta, kändes det som ett naturligt val. Med phpunit blir det så mycket lättare och mer effektivare att testa klassen. Inte heller helt fel att kunna lägga in fler delar efterhand i testmetoderna, efterhand som man kommer på nytt eller lägger till fler delar som skall testa.
