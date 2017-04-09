<?php
namespace Maaa16\Calendar;

class Calendar
{
    private $images = array('image/januari.jpg?w=775', 'image/februari.jpg?w=775', 'image/mars.jpg?w=775','image/april.jpg?w=775', 'image/maj.jpg?w=775', 'image/juni.jpg?w=775', 'image/juli.jpg?w=775', 'image/augusti.jpg?w=775', 'image/september.jpg?w=775', 'image/oktober.jpg?w=775', 'image/november.jpg?w=775', 'image/december.jpg?w=775');
    private $weekdays = array('Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag','Söndag');
    private $currentday;
    private $currentmonth;
    private $currentyear;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->currentday = date('d');
        $this->currentmonth = date('m');
        $this->currentyear = date('Y');
    }

    public function generateCalendar($month, $year, $monthInfo)
    {
        /*
        * $thismonth används för att identifiera om $month är dagens månad eller ej.
        * Är det dagens månad så skall dagens datum markeras i kalendern
        */
        $thismonth = false;
        if ($year == $this->currentyear) {
            if ($month == $this->currentmonth) {
                $thismonth = true;
            }
        }



        // Antalet dagar denna $month och $year
        $numbDaysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));

        // Dag när månaden startar int 1-7, där mån = 1, tis = 2, ..., sön = 7
        $monthStartDay = date('N', mktime(0, 0, 0, $month, 1, $year));

        // Table börjar
        $calendar = "<table class='calendar'>";

        // Rubrikrad med måndag, tisdag, ..., söndag
        $calendar .= "<thead>";
        $calendar.= '<tr class="calrow"><th></th><th class="calday-head">'.implode('</th><th class="calday-head">', $this->weekdays).'</th></tr>';
        $calendar .= "</thead>";

        // Skriver ut de tomma rutorna innan $month börjar
        $calendar .= "<tr>";
        $week = intval(date('W', mktime(0, 0, 0, $month, 1, $year)));
        $calendar .= "<td class='calweek'>". $week ."</td>";
        for ($d = 1; $d < $monthStartDay; $d += 1) {
            $calendar .= "<td class='caldayempty'></td>";
        }

        // Sätter dagen som genereringen är på ($thisday) lika med startdag för månaden ($monthStartDay)
        $thisDay = $monthStartDay;

        /*
        * Skriver ut de dagar som finns i $month
        * Man fortsätter från där man slutade $thisDay = $monthStartDay.
        * Antalet dagar framåt är antalet dagar i månaden + från den dag man startar.
        *
        * Är $thisDay jämnt delbart med 7 vet man att man är på en söndag och gammal rad skall avslutas och ny rad skall börjas.
        */
        for ($thisDay; $thisDay < ($numbDaysInMonth + $monthStartDay); $thisDay += 1) {
            $datum = $thisDay-$monthStartDay+1;
            if ($thisDay%7 == 0) {
                $dayInfo = $this->getDayInfo($datum, $monthInfo);
                // $calendar .= $this->printTd($thismonth, $datum, "caldivred");
                $calendar .= $this->printTd($thismonth, $datum, $dayInfo);
                $calendar .= "</tr>";
                $calendar .= "<tr>";

                // Nytt veckonummer skrivs ut på nästa rad så länge det finns dagar kvar att skriva ut.
                if (($numbDaysInMonth - $datum) > 0) {
                    $week = date('W', mktime(0, 0, 0, $month, $datum, $year)) + 1;
                    $calendar .= "<td class='calweek'>". $week ."</td>";
                }
            } else {
                $dayInfo = $this->getDayInfo($datum, $monthInfo);
                $calendar .= $this->printTd($thismonth, $datum, $dayInfo);
            }
        }

        /*
        * De avslutande rutorna.
        * Om man inte vid detta läge är vid en söndag skall resterande veckan fyllas i med tomma rutor.
        */
        $thisDay = $thisDay - 1;
        if ($thisDay%7 != 0) {
            for ($thisDay; $thisDay%7 != 0; $thisDay += 1) {
                $calendar .= "<td class='caldayempty'></td>";
            }
        }

        // Avslutar sista raden och tabellen
        $calendar .= "</tr>";
        $calendar .= "</table>";

        return $calendar;
    }

    public function getDayInfo($datum, $monthInfo)
    {
        /*
        *  $day byggs till en associativ array med
        * informationen om dagen.
        * Ex. $day['röd dag'] = 'Ja', $day['flaggdag'] = 'Påskdagen'... osv
        */
        $day = [];
        foreach ($monthInfo[0][$datum-1] as $key => $value) {
                $day[$key] = $value;
        }
        return $day;
    }

    public function extractMonthInfo($monthInfoResponse)
    {

        /*
        * Tar ut objekten ur $monthInfoResponse och gör en två-dimensionell array av det.
        * $monthInfo = [$dayInfo, $dayInfo, ..., $dayInfo] där
        * $dayInfo = ['datum': 2017-04-01, 'veckodag' = 'Lördag', 'röd dag': 'nej', ...]
        * De nycklar som alltid finns i $dayInfo:
        *    - datum
        *    - veckodag
        *    - arbetsfri dag
        *    - röd dag
        *    - vecka
        *    - dag i veckan
        *    - flaggdag
        * De nycklar som kan finnas i $dayInfo:
        *   - helgdagsafton
        *   - helgdag
        *   - namnsdag
        *
        *   För att komma åt informationen i $monthInfo för datum x:
        *    foreach ($monthInfo[0][x-1] as $key => $value) {
        *            $day[$key] = $value;
        *
        *    }
        */

        $monthInfo = [];
        $dayArray = [];
        foreach ($monthInfoResponse as $key => $value) {
            if ($key == 'dagar') {
                foreach ($value as $dag => $info) {
                    $dag;
                    $dagdel = [];
                    foreach ($info as $dagkey => $dagInfo) {
                        $dagdel[$dagkey] = $dagInfo;
                    }
                    array_push($dayArray, $dagdel);
                }
                array_push($monthInfo, $dayArray);
            }
        }
        return $monthInfo;
    }

    public function printTd($thismonth, $datum, $dayInfo)
    {
        /*
        * Är det dagens datum skall td:n få class thisday för att ge den en blå ram.
        *
        * Som avslutning läggs delarna helger, aftnar, flaggdagar samt namnsdagar till
        */
        if ($thismonth && $datum == $this->currentday) {
            if ($dayInfo['röd dag'] == 'Ja') {
                $calendar = "<td class='thisday'><div class='caldivthisred'>".$datum."</div>";
            } else {
                $calendar = "<td class='thisday'><div class='caldivthis'>".$datum."</div>";
            }
        } else {
            if ($dayInfo['röd dag'] == 'Ja') {
                $calendar = "<td class='calday'><div class='caldivred'>".$datum."</div>";
            } else {
                $calendar = "<td class='calday'><div class='caldiv'>".$datum."</div>";
            }
        }

        if (array_key_exists('flaggdag', $dayInfo) || array_key_exists('helgdagsafton', $dayInfo) || array_key_exists('helgdag', $dayInfo)) {
            $calendar .= $this->getHollidays($dayInfo);
        }

        if (array_key_exists('namnsdag', $dayInfo)) {
            $calendar .= $this->getNames($dayInfo);
        }

        $calendar .= "</div></td>";
        return $calendar;
    }

    public function getNames($dayInfo)
    {
        // Tar du ut de namnsdagar som finns för dagen.
        $names = "<div class='namesdiv'>";
        foreach ($dayInfo['namnsdag'] as $namn) {
            $names .= $namn ."<br />";
        }
        $names .= "</div>";
        return $names;
    }

    public function getHollidays($dayInfo)
    {
        // Tar ut de flaggdagar, helgaftnar och helgdagar som finns för dagen.
        $part = "";
        $flaggdag = false;
        if (array_key_exists('flaggdag', $dayInfo)) {
            if ($dayInfo['flaggdag'] != "") {
                $part = "<img src='image/svflaggamini.png' /><br /><div class='flaggtext'>". $dayInfo['flaggdag'] ."</div>";
                $flaggdag = true;
            }
        }
        if (array_key_exists('helgdagsafton', $dayInfo)) {
            if ($dayInfo['helgdagsafton'] != "") {
                $part .= "<div class='afton'>". $dayInfo['helgdagsafton'] ."</div>";
            }
        }
        if (array_key_exists('helgdag', $dayInfo)) {
            if ($dayInfo['helgdag'] != "" && !$flaggdag) {
                $part .= "<div class='afton'>". $dayInfo['helgdag'] ."</div>";
            }
        }
        $holliday = "<div class='helgdiv'>" .$part. "</div>";

        return $holliday;
    }
    public function generateImage($month)
    {
        $image = "<img src='". $this->images[$month-1] ."' alt='Kalenderbild' />";
        return $image;
    }
}
    // public function test($month, $year)
    // {
    //     $thismonth = FALSE;
    //     if ($year == $this->currentyear) {
    //         if ($month == $this->currentmonth) {
    //             $thismonth = TRUE;
    //         }
    //     }
    //
    //     if ($thismonth) {
    //         $text = "Dagens månad";
    //     } else {
    //         $text = "Inte dagens månad";
    //     }
    //
    //     return $text;
    // }
