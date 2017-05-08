##Kmom06

Det känns verkligen att kursen tagit med mycket och gått både på djupet och på bredden. Det var skönt att äntligen kunna lämna in redovisningen för sista kursmomentet och mentalt börja ladda för sista stora uppgiften.

###Vad du bekant med begreppet index i databaser sedan tidigare?
Inte på det sättet som vi använt det nu. Kände inte till att man kunde kolla hur stor sökningen var och att man med EXPLAIN kunde få ner sökningsområdet och optimera.

###Berätta om hur du jobbade i uppgiften om index och vilka du valde att lägga till och skillnaden före/efter.
Jag valde att lägga index i tre tabeller; content (som innehåller posts, pages och block), accounts (som har användarna) och ShelfSection (som är en hyllsektion i lagret). Två av dem, ShelfSection och content valde jag att indexera en kolmn, description (beskrivning/namnet på hyllsectionen) respektive title (titel på content). Båda dessa sänkte antalet rader från full tabellsökning till enbart en rad. I den tredje tabellen, accounts, skapades ett unique index på email då dessa inte skall kunna vara dubbletter. Därmed gick sökning på email i accounts från full tabellsökning till en rad.

###Har du tidigare erfarenheter av att skriva kod som testar annan kod?
Litegran sedan tidigare kurser - i Python. Men inte mer än så.

###Hur ser du på begreppet enhetstestning och att skriva testbar kod?
Det är en trygghet att kunna testa så att det fungerar som tänkt och är något som jag kommer att ha med mig i fortsättningen när jag skriver klasser. Att se till att få med bitar som gör det lätt att via phpunit kontrollera funktionaliteten.

###Hur gick det att hitta testbar kod bland dina klasser i Anax Lite?
Det gick bra. Valde dock att bara skriva test för en av klasserna. Dels för att det mest var en klass som kändes klockren för ändamålet. Det var Textfilterklassen, som jag tidigare tänkt, skulle vara toppen om man kunde testa. När jag skrev den klassen innan valde jag att kunna förhandsgranska hur det blev i browsern. Men att man med phpunit lättare och mer effektivare kan få fram allt man vill testa istället.
