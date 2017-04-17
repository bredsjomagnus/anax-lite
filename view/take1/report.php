<div class="page">
    <div class="container">
        <h1>REDOVISNINGAR</h1>


        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#kmom01" aria-expanded="false" aria-controls="kmom01">
            Kmom01
        </a>
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#kmom02" aria-expanded="false" aria-controls="kmom02">
            Kmom02
        </a>
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#kmom03" aria-expanded="false" aria-controls="kmom03">
            Kmom03
        </a>

        <div class="collapse" id="kmom01">
            <div class="pillow-50">

            </div>
            <div class="well reportwell">
                <h2>Kmom01</h2>
                <p>Det var nog den största första uppgiften än så länge. Jag har enbart oophp och inte webapp då jag redan läst den kursen och tyckte det blev mycket att hinna med ändå.</p>

                <p>Mycket av tidspressen beror också på att jag ville få med så mycket av extrauppgifterna som möjligt. Jag gjorde några stycken av dem men inte alla. Det tog för lång tid.</p>

                <h3>Hur känns det att hoppa rakt in i klasser med PHP, gick det bra?</h3>
                <p>Det gick bra. Det gick rätt så snabbt att komma in i det igen. Men jag fick också lite flashbacks av anax och att jag tycker det är svårt att veta vad som händer under huven. Det är så mycket kod som jag inte kan och hur den funkar så det blir svårt att bygga vidare.</p>

                <h3>Berätta om dina reflektioner kring ramverk, anax-lite och din me-sida</h3>
                <p>Lite som jag nämnde ovan tycker jag det är svårt att arbeta med anax-lite då det finns så mycket som jag inte har koll på i koden. Det är ju många moduler som måste läggas till och strukturen är svårt att greppa. Hur kommer koden åt ditt eller datt tar mycket tid och det blir mest att testa sig fram tills man får något som funkar. Känns sådär.</p>

                <h3>Gick det bra att komma igång med MySQL, har du liknande erfarenheter sedan tidigare?</h3>
                <p>Det var intressant att få se och testa de andra klienterna. Workbench tog jag till mig och har mest använt den. Testade att koppla upp mig mot en egen vps med den och efter lite mek så funkade det bra. Ett väldigt bra verktyg.</p>

                <p>Jag gillade övningen och tyckte den gav mycket. Det är, för mig, inte trivialt när man skall till att joina tabeller eller liknande. Men att denna övningen rätade ut några av frågetecknen. Kul.</p>
            </div>
        </div>
        <!-- /kmom01 -->

        <!-- kmom02 -->
        <div class="collapse" id="kmom02">
            <div class="pillow-50">

            </div>
            <div class="well reportwell">
                <h2>Kmom02</h2>
                <h3>Hur känns det att skriva kod utanför och inuti ramverket, ser du fördelar och nackdelar med de olika sätten?</h3>
                <p>Måste erkänna att jag är lite osäker på vad som menas med utanför respektive innanför. Men antar att det syftar till skillnaden att lägga in den i $app så som gjordes med navbaren till skillnad från kalender?</p>

                <p>Jag var lite skeptisk först till nyttan av att lägga in navbaren i app och flytta ut delar till config. Men jag inser att det blev mycket renare och man får känslan av att ha lite mer ordning och reda och kontroll. Även om jag inte var helt oäven förut så poängterade uppgiften för mig att det är mödan värt att lägga tid och kraft på struktur. Bra.</p>

                <p>I dagsläget tror jag min filosofi är att enbart lägga in grunden i ramverket - det som krävs för innehållet. Medan man låter kalender liknande få ligga utanför. Detta bygger dock blott och enbart på en idé om att det “känns mer rätt så”.</p>

                <h3>Hur väljer du att organisera dina vyer?</h3>
                <p>Jag har, som det ser ut nu, delat upp det i header, navbar, byline och footer. Däremellan kommer sidans innehåll, så som exemeplvis home, about, calender.</p>

                <p>Vyerna är inte rensade från php som sig kanske bör. Framför allt inte i calender. Men jag har försökt hålla så mycket av koden i klasserna som möjligt.</p>

                <h3>Berätta om hur du löste integreringen av klassen Session.</h3>
                <p>Det enda jag gjorde var att lägga in den i app - $app->session. Kan i detta nu inte se vad jag vinner med detta mot att istället bara köra $session->metod istället för $app->session->metod. Kanske att jag förstod uppgiften fel eller att det får ta lite mer tid innan jag ser nyttan.</p>

                <h3>Berätta om hur du löste uppgiften med Tärningsspelet 100/Månadskalendern, hur du tänkte, planerade och utförde uppgiften samt hur du organiserade din kod?</h3>
                <p>Jag lade rätt så mycket krut på att få till en kalender som hade rätt röda dagar, helgdagar, flaggdagar och liknande.</p>

                <p>Själva organisationen av koden är att jag har klassen Calendar som i huvudsak generarar html och bild för en månad. Men Calendar används även för att bearbeta json som hämtas från api.dryg.net/dagar/v2.1/år/månad. Objekten görs i slutändan om till en associativ array för att lättare kunna hitta informationen kring varje enskild dag. Det kändes bättre att ha en metod för bearbetning som sker en gång i början, än att låta koden harva igenom jsonfilen för varje dag som skall tas fram.</p>

                <p>Men det hela hängde nu på att api.dryg.net kan leverera och för att inte helt förlita sig på detta valde jag att spara ner en del av informationen istället. Det blev en möjlig variant eftersom att informationen inte kommer förändras.</p>

                <p>För det ändamålet återanvänds ett bashscript från linuxkursen som med små justeringar klarade den delen på ett smidigt sätt. Med ./update-dateinfo <år> sparas jsonfilerna som månad-år.json för det året man valt. Det finns nu information om dagarna för åren 2015-2019, alltså två år framåt och bakåt från idag.</p>

                <p>Jag försökte få det så att om man inte hittade jsonfilen, det vill säga om man exempelvis ville se kalendern för 2020 mars, skulle koden köra shell_exec(./update-dateinfo <år>) för att på så sätt hela tiden uppdatera jsonfilbanken. Men jag fick det tyvärr inte att fungera. Det fick bli ett anrop till api.dryg.net, utan nedladdning, som utväg ifall inte jsonfilerna existerade.</p>

                <h3>Några tankar kring SQL så här långt?</h3>
                <p>Jag gjorde hela sql-delen förra kmom och tycker att det var en mycket bra övning. Skulle gärna få mer SQL-uppgifter och övningar för att slipa på de kunskaperna ytterligare.</p>

                <p>Som en parentes har jag för övrigt haft mycket nytta av vad SQL-artikeln, övningen och uppgiften gav. Jag håller alltmer på att gå över som ansvarig för skolans datorer och i ambitionen att göra en adminsida har jag lagt in elever och datorer i databas via Workbench (som jag inte kände till förut) och joinat tabeller och skapat views. Mycket smidigt och dessutom extra kul när så tydligt ser nyttan av vunnen kunskap i ett verkligt projekt.</p>
            </div>
        </div>
        <!-- /kmom02 -->

        <!-- kmom03 -->
        <div class="collapse" id="kmom03">
            <div class="pillow-50">

            </div>
            <div class="well reportwell">
                <h2>Kmom03</h2>


                <h3>Hur kändes det att jobba med PHP PDO, SQL och MySQL?</h3>
                <p>Det känns både bekant och nytt samtidigt. Det är mycket att ta in. Men kul samtidigt. Mycket matnyttigt, så att säga.</p>


                <h3>Reflektera kring koden du skrev för att lösa uppgifterna, klasser, formulär, integration Anax Lite?</h3>
                <p>Det tillkom tre ny klasser detta kursmoment - Cookie, DBTable och Gravatar. Den sistnämnda har jag inte kodat själv utan var en klass öppen för fri användning till den som ville använda Gravatar-avatarer.</p>

                <p>Av dessa är det bara Cookie som är integrerad i ramverket av den anledningen att de andra mer är som tillägg till innehållet och inte en del av strukturen.</p>

                <p>Jag ville ha en klass för så renodlad funktion som möjligt så att man lättare kan återanvända dem. Därför har jag inte en klass som speciellt sköter inloggningen utan ville att Database skulle ta hand om den biten så att all databashantering är samlad på ett ställe genom så få metoder som möjligt.</p>

                <p>DBTable tar hand om tabellernas sökning, sortering, paginering och generering till HTML med hjälp av parametrarna [antal rader per sida, kolumnnamn som skall sorteras efter, asc/desc, kolumn att söka på, söksträng]. Denna används för att få fram alla tabeller, både för avläsning och editering av databas. Jag försökte injecta $app i DBTable, så som gjorts i exempelvis navbar. Men det lät sig inte göras, så i nuläget skickar jag med $app som argument. Får se om jag kan komma tillrätta med det längre fram.</p>

                <p>Delar av vyerna har mycket PHP i sig. Detta för att jag ville hantera formulären på plats vid vissa tillfällen. Medan jag i övriga fall valt att förlägga processerna separat. </p>


                <h3>Känner du dig hemma i ramverket, dess komponenter och struktur?</h3>
                <p>Mycket mer nu än i början. Men jag är fortfarande osäker på vissa saker. Antar att min variant på lösning av att lägga in en stil inte är vad man egentligen skall göra. Jag lägger in sökvägen som en variabel till headern. Det är inte optimalt när man har olika djupa folders att skicka ifrån då jag måste lägga ytterligaren en dirname() runt pathen. Men det var ett sätt att få till något som sen blivit kvar. Hur skall man göra egentligen?</p>

                <p>Men när det kommer till hur $app kan fungera och användas samt olika sätt att lägga till klasser så börjar jag få lite koll.</p>

                <p>Det känns bra att dimmorna har börjat skingras lite. Även om det finns bitar kvar som jag inte skulle kunna förklara hur eller varför för en oinvigd.</p>


                <h3>Hur bedömer du svårighetsgraden på kursens inledande kursmoment, känner du att du lär dig något/bra saker?</h3>
                <p>Tycker nog inte det varit så mycket svårare än andra kurser. Det vill säga, en hel del utmaningar, men som löser sig om man ger sig attans på det (ibland med hjälp ifrån Gitter).</p>

                <p>Däremot har det varit väldigt mycket. Det har känts som små projektarbeten i hur mycket som skall lämnas in. Det är tur det varit påsklov för min del, så jag hunnit sitta med plugget mer än vanligt. Så länge det inte blir alltför mycket ser jag det dock inte som ett problem. Jag vill få ut så mycket jag bara kan av kurserna och skulle bli besviken om det inte gavs rejäla uppgifter och utmaningar.</p>

                <p>Tycker jag fått med mig mycket bra så här långt i kursen. Framför allt sqldelen och, för min del, mycket mer klarhet i cookies och sessions.. Men även ramverket faktiskt. Jag ser allt mer tjusningen att arbete i ett och inser att jag kommer vilja använda det även fortsättningsvis. Behöver bara få lite mer kläm på alla delar bara.</p>

            </div>
        </div>
        <!-- /kmom03 -->

    </div>
</div>
