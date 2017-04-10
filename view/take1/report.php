<div class="page">
    <div class="container">
        <h1>REDOVISNINGAR</h1>
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#kmom01" aria-expanded="false" aria-controls="kmom01">
            Kmom01
        </a>
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#kmom02" aria-expanded="false" aria-controls="kmom02">
            Kmom02
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

    </div>
</div>
