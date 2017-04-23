##Kmom04

Nu är jag helt slut. Detta var ännu en mastodontuppgift. Familjen börjar undra var jag tagit vägen.

Men det har varit ett kul och utmanande kursmoment och jag hoppas att jag fick med allt och lite till.

###Finns något att säga kring din klass för textfilter, eller rent allmänt om formattering och filtrering av text som sparas i databasen av användaren?
Detta var en rolig och utmanande del att göra och utan regex101 till hjälp hade jag nog gått bet.

Användaren får möjlghet att lägga in text via bloggen. Då kan användaren välja filter via checkbox, men inte ordning. Detta för att få den bästa ordningen av de valen som gjorts. Man kan även förhandsgranska för att se vad de valda filtren gör med texten.

###Berätta hur du tänkte när du strukturerade klasserna och databasen för webbsidor och bloggposter?
Jag gjorde en klass som har hjälpfunktioner till detta - Content. Den ser till att slug alltid är unikt genom att lägga till -2, -3 eller vad som krävs efter slugnamnet om så behövs. Den ser även till att kontrollera path att den sätts till null om så behövs.

Det är en admin som har kontrollen via adminsidan och kan lägga till, redigera eller ta bort. Det är bara admin som kan skapa nya sidor och block. Medan både användaren och admin kan skapa bloggposter.

Jag valde att lägga till möjlighet för admin att publisera eller ickepublicera en post, page eller block. Det kommer inte synas för en användare om det inte är publiserat. Default läget när användaren lägger till en bloggpost är att det är publiserat. Men admin måste publisera efter tillägg för att det skall synas. Admin har däremot möjlighet att se pages även om de inte är publiserade via adminsidan.


###Förklara vilka routes som används för att demonstrera funktionaliteten för webbsidor och blogg (så att en utomstående kan testa).
Routen för page är helt enkelt page och för blog är det blog. Man kan se hur blocks fungerar via routen blocktest. Men allt finns även i dropdown-menyn 'Uppgifter'.

###Hur känns det att dokumentera databasen så här i efterhand?
Gillade verkligen hur smidigt det var att få till diagrammet med reverse engineering. Förstår att det finns stor vinning med detta när det börjar bli stort och invecklat och även efter att det gått viss tid och man vill få kolla på läget igen.

Däremot ville det sig inte helt med data exporten av koden. Fick skumma felmeddelanden i sql-filen.

###Om du är självkritisk till koden du skriver i Anax Lite, ser du förbättringspotential och möjligheter till alternativ struktur av din kod?
Ja, absolut. Framför allt vet jag att mitt sätt att få till stilen inte är optimal. Men det är det bästa jag kommit på så här långt. Nu skickar jag med path via route till headern för varje route som skapas. Blir lite omständigt och jag märker att det ställer till det med att bilder inte alltid syns i vissa lägen.

Sen finns det säker mer. Men det är vad jag kan komma på på rak arm.
