##Kmom10

###Krav 1: Struktur och innehåll
Det finns en produktsida - ‘Butik’ som visar alla produkter till salu. Det är enbart spel som satts till “displayed” som visas utåt mot kund, på denna sidan och förstasidan.

Nyhetssidan är en vanlig bloggsida med nyheter efter inläggningsdatum. Det finns 7 st inlagda nyhetsposter. Klickar man rubrik så kommer man till sida som visar enbart den nyhetsposten. Dessa skapas som administratör under Innehåll->lägg till innehåll och är av typen ‘post’. Dessa visas sedan även på första sidan. Men mer om den längre ner.

Om sidan visar kortfattad information kring folket bakom butiken och även kontaktinformation. Den är skapad som en typ ‘page’ och kan redigeras som administratör under länken Innehåll.

Det finns en gemensam header och footer. Navbaren finns i två varianter. En för kunden och en för administratören när den går in i det läget. Detta styrs via navbarens configfil och routern.

Footern innehåller information om mig, företaget och BTH samt vilken kursen är. Detta kommer från innehåll av typen block med namnen ‘leftfooter’, ‘middlefooter’ och ‘rightfooter’ och kan därmed ändras via admingränssnittet.

Det finns även annat innehåll av typen block, så som ‘checka ut’-info, ‘orderreview’, ‘fraktinformation’, ‘erbjudande’ samt ‘rekommenderade’.

Som administratör kan man via adminpage hantera innehåll; nyhetsblogg, block som är delar av en sida, page som är hela sidor samt lägga till och redigera produkter. Men även användarkonton och webshopen. Man har möjlighet att lägga till/ta bort användare/innehåll/användare. Man kan lägga till varor till lagret, se ordrar och fakturor. Sätta ordrar till skickade/ej skickade och fakturor till betalade/ej betalade.

När man lägger in innehåll har man möjlighet att förhandsgranska och därmed testa så man har rätt filter eller att man hanterar filterna på rätt sätt. Första gången man skall lägg till nytt innehåller kan man förhandsgranska utan att spara. Men att när man skall redigera ett redan inlagt innehåll behöver man klicka spara innan man kan förhandsgranska texten. Innehåll måste publiceras, efter att det skapats, via admingränssnittet innan det visas på sidan. Detta gäller alla tre typerna; post, block och page. Detta görs via Innehållstabellen i administratörsgränssnittet.

Det finns en makefil så att man kan generera dokumentation med phpdoc. Det finns även inlagt enhetstester med phpunit i samma omfattning som i kmom06.

Under kmom10/webpage/htdocs/sql/setup.sql finns hela upprättandet av databasen för webshopen. Där finns även ett ER-diagram samt en er.png för diagrammet för databasen.

###Krav 2: Skapa kundkonto
Som kund kan du skapa ett konto och via din kontolänk i navbaren få se dina uppgifter samt önskelista och orderhistorik. Här kan man även redigera delar av sina kontouppgifter, så som email, adressuppgifter, lösenord, för- och efternamn.

Användarnamnet och emailadressen måste vara unikt mot övriga användarkonton.

Konton sätts som default till ‘customer’ och den typen av konton kommer inte in i administratörsgränssnittet. Administratören kommer åt administratörsgränssnittet via sin kontosida.

Det finns inlagt bland annat kunden doe med lösenord doe och administratören admin med lösenord admin.

Vad gäller användarkontona så kan admin i administratörsgränssnittet redigera ett användarkontos uppgifter samt växla ett konto mellan kund och admin eller att blockera kontot från att användas.

###Krav 3: Sida - Produkter
Varje produkt tillhör minst en kategori. När en produkt läggs till tas hjälp av boardgamegeeks databas för spelets egenskaper. Mer om det under krav 6. Varje produkt har ett artikleid som baseras på titeln med bindestreck mellan orden. Spelet ‘Axis and Allies’ får artikelid ‘art-axis-and-allies’. Skulle ett annat spel med samma titel läggas in ser en metod till att artikleid förblir unikt och lägger till siffra på de produkter med samma titel; axis-and-allies-2 exempelvis.

När man lägger in kan man välja den eventuella bild som ges av boardgamegeek eller om man lägger in en egen. Man har möjlighet att testa bilden så det ser bra ut innan man bestämmer sig. Detta kan givetvis ändras efteråt.

I butiken visas mindre bilder upp tillsammans med pris, lagerstatus, Boardgamegeek-rating, lägga i kundvagn-knapp och lägga i önskelistan-knapp. Om man klickar en produkts titel eller bild kommer man till dess produktvy. Där finns beskrivning över spelet. Här ges mer omfattande information; rating, pris, kategorier, utgivningsår, antal produkter i lagret, antal spelare, rekommenderad ålder och speltid. Härifrån kan man lägga produkten i kundvagn eller i önskelistan. Det finns i både butik och produktvy länk till spelet på boardgamegeek.com.

Man kan söka bland spelen via titel eller beskrivningstexterna. Sortering kan göras via radioknappar för titel, pris och boardgamegeek-rating. Det finns paginering om det skulle vara fler produkter än vad som får plats i tabellen. Antalet som skall visas samtidigt kan justeras via en select.

Det krävs att man är inloggad för att kunna lägga i kundvagnen. Är inte användaren inloggad när man försöker lägga produkt i kundvagn så dirigeras man till inloggningssidan.

Kundvagnen kan redigeras via inputfält eller om man helt vill radera via länk i tabellen (rött kryss). Det finns information hur många varor som finns i lagret och markeras med röd text om kundvagnen innehåller fler varor än vad som finns i lagret, annars grön text som talar om antalet av den produkten som finns i lagret.

Efter köp får kunden se sin order. Kunden kan även se orderhistoriken via sin kontosida. Där kan man även se fakturan för ordern.

Lagret ändras inte av varorna i kundvagnen utan uppdateras enbart när själva köpet görs. Då skapas även en faktura med förfallodatum 30 dagar framåt från köpdatum. Kundvagnen töms i samma veva. Det loggas även vilka köp som gjorts och i vilken kvantitet för att hålla ‘Hetast just nu’-tabellen korrekt uppdaterad på förstasidan.

Man kan sätta en produkt till ‘displayed’ eller ‘notDisplayed’. Detta avgör om produkten ‘lagts ut’ och syns i butiken eller inte. Man kan även ‘radera’ en produkt. Då markeras den som raderad. Men går att ta tillbaka om man skulle ångra sig.


###Krav 4: Förstasidan
Det finns en förstasida som samlar nyheter, det hetaste produkterna, nya produkter i butiken, rekommenderade produkter och ett kategorimoln.

De hetaste produkterna och senast inlagda produkterna baseras på tabeller i databasen som uppdateras när produkter köpts respektive lagts in i butiken. Det är enbart produkter som satts till ‘displayed’ som kommer att synas på förstasidan.

Det finns en senaste nytt lista som tar med de tre senaste nyhetsposterna och visar en lite del (50 tecken) från inlägget. Här jag har märkt att man får parera lite så att det inte bryts vid ett å, ä eller ö. Annars kommer inte teckenkodningen med. Klickar man titel kommer man till nyhetsposten.

Under denna lista finns ett kategorimoln som visar butikens kategorier där den vanligaste kategorin är större och den mer sällsynta kategorin är har mindre font-size. Dessa fungerar även som en länk, så att om man trycker på en kommer man till butiken med just den filtreringen.

Erbjudande och rekommendationer styr man via ett innehåll av typen block. Det finns under innehåll färdiga block med de tingade slugsen ‘erbjudande’ och ‘rekommenderade’ och i de blocken skriver man in artikelid för produkterna separerande med komma utan mellanslag. Exempelvis art-heroquest,art-pandemic,art-star-wars-rebellion, så kommer de tre spelen hamna i erbjudande- eller rekommenderadetabellen beroende på valt block.

###Krav 5: Produktkategorier
Varje produkt har alltid minst en kategori. Men av de inlagda spelen i setup.sql har spelen två kategorier eller fler. Man kryssar i ett spels kategorier när man lägger in en ny produkt och detta kan redigeras senare.

I butiken syns kategorierna i en lista till vänster med antalet kategorier som finns med bland de spel som för tillfället finns med i sökningen eller filtreringen. Det finns även en filtrering för antalet spelar, både minsta antalet och maxantalet spelare ett spel kan ha.

Man kan söka på flera filter samtidigt som då mer och mer gallrar ut spel ur butiken. När en filtrering gjorts ser man nya antalet av kategorier och antalet spelare i parenteserna för de spel som nu är kvar på skärmen . Är man exempelvis ute efter ett strategispel med fantasytema som kan spelas med 6 spelare så kan man klicka för de tre filtren (strategispel, fantasy, maxspelare 6st) för att se vilka spel som har just de egenskaperna. Finns det då fler kan man sortera dem efter boardgamegeekratingen eller pris och få ytterligare hjälp att hitta vad man söker.

###Krav 6: Extra
####Boardgamegeek
Jag har, som jag redan nämnt lite ovan, använt mig av boardgamegeeks databas för att underlätta inlägg av nya produkter, för att visa deras rating i butiken och för att kunden lätt skall kunna ta sig till sidan för just det spelet de är mer nyfikna på. Varje produkt har en länk till dess motsvarighet på boardgamegeek.com

Boardgamegeek är för spel vad IMDB är för filmer. Det är moderskeppet för brädspel och den givna sidan att gå till när man söker efter information om och kring spel. Databasen innehåller ca 100 000 spel och kommer i de allra flesta fall täcka upp när man lägger in en ny produkt. Vid sökning så får man upp en lista över träffarna i databasen och vilket publiseringsår titeln har. Om man hittar den man söker kan man välja den och klicka vidare. Annars, om man inte hittar titeln för att databasen inte går att nå eller för att titeln inte finns i den, får man besked om ‘Titeln matchar inget spel i Boardgamegeeks databas’ eller så kan man välja ‘Ingen av träffarna’’ utgå från en blank start istället.

Boardgamegeek ger fri tillgång till sitt innehåll för icke kommersiella syften, vilket detta i strikt mening är. Skulle det varit skarpt läge blir skillnaden att man använt egen bild och, lite beroende på texten, skrivit om beskrivningen av spelet. Men i övrigt skulle man haft fortsatt stor nytta av all information kring produkten så som antalet spelare, speltid, ålder mm. Sådant som kan tillskrivas egenskaper hos spelet. Dessutom skulle man fortfarande kunna knyta spelen till databasen för rating och direktlänk till spelet på boardgamegeek.com.

Med detta som hjälp har jag haft mer tid att lägga själva webbutiken och hur den skall hantera produkter som är fyllda med detaljer och information.

####Önskelista
Det finns även möjlighet för användaren att bygga upp sin önskelista. Detta gör man genom att klicka på hjärtat vid produkten i butiken eller i produktvyn. Det har ju hänt att man som kund velat ha mer än man haft råd med för tillfället eller att man av annan anledning sett något intressant men inte klickat köpknappen, än. Då är det smidigt att kunna lägga produkten önskelistan, så att den finns lättillgänglig till nästa gång man kommer på besök. Önskelistan hittas sen under kontosidan och kan redigeras användaren. Önskelistan är byggs upp av två tabeller i databasen och liknar i mångt och mycket kundvagnen. Fast utan att ta hänsyn till antalet. Den begränsar så att varje produkt i önskelistan är unik.

####Poäng
Känns lite konstigt att resonera kring hur många poäng det är värt. Men jag gör ett försök.

Av de tio poäng som kan fås för extrauppgiften tycker jag dessa två delar borde ge alla tio poäng Det är framför allt kopplingen till Boardgamegeek som är huvuddelen av de poängen. Responsen var i XML och inte i JSON. Vilket gjorde att jag fick med mig en del nytt i och med detta. Det har dessutom varit till stor hjälp vid uppbyggandet av butiken och skulle vara fortsatt bra för butikens service och funktionalitet mot kunden.

Önseklistan är en mindre del. Men att en önskelista är en funktion som passar väl in i en webbutik. Det är en funktion som ligger utöver och borde ge några poäng under krav 6.

###Allmänt
Det har varit ett kul och lärorikt projekt. Jag har länge lekt med tanken att ha en egen webbutik för just spel av olika slag. Så det var kul att nu få testa de nyvunna kunskaperna och försöka göra en. Det passar väl in med kursen och knyter ihop de olika momenten på ett bra sätt. Skulle sen gärna vilja veta och lära mig mer om hur man kan hantera betalningsbiten. Den lösningen chansar man sig inte fram till.

Som vanligt så har det gått lite upp och ner under arbetets gång. Det fanns många stopp som gick svårare än jag hoppats. Men de stora hindren på resan visade sig bli filterna, kundvagnen och processen att ta bort från lagret vid köp.

Jag var från början inställd på att få till filterna och att kunna filtrera på många samtidigt. Blev inspirerad av SFbokhandelns sätt att hantera detta. Skulle gärna velat kunna filtrera även på åldersrekommendation men kände att jag fick bryta, för tidens skull.
Jag fick även kompromissa med kundvagnen. Den hade jag helst velat kunna fylla innan man loggar in. Jag kan själv irritera mig på sidor där jag måste skapa konto för att kunna börja handla. Helst skall man kunna checka ut utan att ens behöva skapa konto, om jag fick bestämma.

Jag påbörjade en sådan lösning för kravlös kundvagn. Men fick inte riktigt ihop det.  Bestämde mig därför för att göra inloggningskrav först och om tiden tillät gå tillbaka och fixa den kravlöst varianten. Men så långt kom jag tyvärr inte. Nu dirigeras du istället till inloggningssidan om du försöker lägga något i kundvagnen utan att var inloggad.

När jag skulle ta bort varor ur lagret så blev det rätt så mycket bökigare att jag tillåter att man kan ha samma vara på olika hyllor. Denna delen var en typisk sådan där jag tänker att det går snabbt, enkelt och smidigt att fixa och sen sitter jag i två dagar från och till innan jag är klar. Tror jag fick börja om tre gånger innan lösningen var på plats.

###Avslutande tankar
Som sagt så tycker jag det varit en bra kurs. Det har varit innehållsmässigt bra kursmoment. Det har varit väldigt mycket. Men det har också gett mycket.

Tycker verkligen om Gitter chatten. Den kommer oftast till ens räddning när man sitter i kläm. Likaså är hangoutsen väldigt värdefulla när inget annat hjälper. Tycker också om litteraturen Databasteknik, även om jag kan tycka de tramsar lite väl mycket kring exemplen och sådant. Men den fyller sin funktion.

Jag skall fundera mer kring kursen och dess innehåll delge de synpunkterna, om några dykt upp, på kursutvärderingen.

Det har varit en av de mer intensiva kurserna så här långt. Det var som jag skrev i någon av redovisningarna - mina nära och kära undrar nog vart jag tagit vägen. Så blev det givetvis också under projektarbetet.

Programmering är kul. Men nu skall det bli trevligt att få lite tid över till familjen.

Jag skulle kunna rekommendera kursen till vänner. Betyg på kursen blir en 8.
