<?php

if (isset($_GET['month']) && isset($_GET['year'])) {
    $calendar = new Maaa16\Calendar\Calendar();
    if ($_GET['month'] > 0 && $_GET['month'] < 13) {
        $month = intval($_GET['month']);
    } else {
        $month = date('m');
    }
    // $month = intval($_GET['month']);
    $year = intval($_GET['year']);
    $monthtext = date('M', mktime(0, 0, 0, $month, 1, $year));

    // Hämtar och bearbetar information om $month och $year
    $monthInfoJSON = file_get_contents("http://api.dryg.net/dagar/v2.1/". $year ."/". $month);
    $monthInfoArray = json_decode($monthInfoJSON);
    $monthInfo = $calendar->extractMonthInfo($monthInfoArray);

    // Genererar kalender och bild för $month och $year
    $calHTML = $calendar->generateCalendar($month, $year, $monthInfo);
    $calImage = $calendar->generateImage($month);
} else {
    // är inte parametrar satt så skapa en Calender
    $calendar = new Maaa16\Calendar\Calendar();

    // ta fram dagens månad och år
    $month = intval(date('m'));
    $monthtext = date('M');
    $year = intval(date('Y'));

    // Hämtar och bearbetar information om $month och $year
    $monthInfoJSON = file_get_contents("http://api.dryg.net/dagar/v2.1/". $year ."/". $month);
    $monthInfoArray = json_decode($monthInfoJSON);
    $monthInfo = $calendar->extractMonthInfo($monthInfoArray);

    $d = $calendar->getDayInfo(14, $monthInfo);

    // Genererar kalender och bild för $month och $year
    $calHTML = $calendar->generateCalendar($month, $year, $monthInfo);
    $calImage = $calendar->generateImage($month);
}

?>

<div class="page">



    <div class="row">
        <div class="col-md-offset-1">
            <h1>KALENDER</h1><br />
        </div>
    </div>
    <div class="row">

        <div class="col-md-offset-1 col-md-2">
            <a name="calenderanchor"></a>
            <form action="#" method="GET">
                <div class="form-group">
                    <label for="month">Välj månad och år:</label>
                    <select class="form-control" name="month">
                        <option value="-" selected="">-Månad-</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Mars</option>
                        <option value="4">April</option>
                        <option value="5">Maj</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Augusti</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select class="form-control" name="year">
                        <option value="-">-År-</option>
                        <option value=<?= intval(date('Y')-5) ?>><?= intval(date('Y')-5) ?></option>
                        <option value=<?= intval(date('Y')-4) ?>><?= intval(date('Y')-4) ?></option>
                        <option value=<?= intval(date('Y')-3) ?>><?= intval(date('Y')-3) ?></option>
                        <option value=<?= intval(date('Y')-2) ?>><?= intval(date('Y')-2) ?></option>
                        <option value=<?= intval(date('Y')-1) ?>><?= intval(date('Y')-1) ?></option>
                        <option value=<?= intval(date('Y')) ?> selected><?= intval(date('Y')) ?></option>
                        <option value=<?= intval(date('Y')+1) ?>><?= intval(date('Y')+1) ?></option>
                        <option value=<?= intval(date('Y')+2) ?>><?= intval(date('Y')+2) ?></option>
                        <option value=<?= intval(date('Y')+3) ?>><?= intval(date('Y')+3) ?></option>
                        <option value=<?= intval(date('Y')+4) ?>><?= intval(date('Y')+4) ?></option>
                        <option value=<?= intval(date('Y')+5) ?>><?= intval(date('Y')+5) ?></option>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" name="calenderselectbtn" value="GÅ TILL MÅNAD">
            </form>
        </div>
    </div>


    <div class="row">

        <div class="pillow-50">

        </div>
        <div class="col-md-2 col-md-offset-1">
            <?php
            // echo "<h2 class='calendarheader'>". $year ." ". $monthtext ."</h2>";

            $prevmonth = $month -1;
            if ($prevmonth < 1) {
                $prevmonth = 12;
                $prevyear = $year - 1;
            } else {
                $prevyear = $year;
            }
            $prevurl = "calendar?month=". $prevmonth ."&year=".$prevyear."#calenderanchor";

            $nextmonth = $month + 1;
            if ($nextmonth > 12) {
                $nextmonth = 1;
                $nextyear = $year + 1;
            } else {
                $nextyear = $year;
            }
            $nexturl = "calendar?month=". $nextmonth ."&year=".$nextyear."#calenderanchor";
            echo "<span class='calendarheader'><a href={$prevurl}><span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span></a>&nbsp;&nbsp;&nbsp;". $year ." ". $monthtext ." &nbsp;&nbsp;&nbsp;<div class='right calnextarrow'><a href={$nexturl}><span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span></a></div></span>";
            ?>
        </div>
        <div class="col-md-offset-2 col-md-1 idagbtndiv">
            <?php $thismonthurl = "calendar?month=". date('m') ."&year=". date('Y'); ?>
            <a name="today" class='idagbtn btn btn-default' href=<?= $thismonthurl ?>>IDAG</a>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <?= $calHTML; ?>

        </div>
        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
            <div class="calendarimagediv">
                <?= $calImage; ?>
            </div>

        </div>
    </div>
</div>
