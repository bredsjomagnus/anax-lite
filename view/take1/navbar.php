<?php
$navbar = [
    "config" => [
        "navbar-class" => "nav navbar-nav"
    ],
    "items" => [
        "hem" => [
            "text" => "Hem",
            "route" => "",
        ],
        "redovisning" => [
            "text" => "Redovisningar",
            "route" => "report",
        ],
        "om" => [
            "text" => "Om",
            "route" => "about",
        ]
    ],
    "dropdown" => [
        "namn" => "Uppgifter",
        "items" => [
            "gissa" => [
                "text" => "Guess the number",
                "route" => "guessing"
            ],
            "session" => [
                "text" => "Session",
                "route" => "session"
            ]
        ]
    ]
];

/*
* Strukturen på en bootstrap dropdown
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Separated link</a></li>
    </ul>
</li>
*/

foreach ($navbar as $key => $value) {
    // echo $key;
    if ($key == "config") {
        foreach ($value as $class) {
            $navhtml = "<ul class='". $class ."'>";
        }
    } else if ($key == "items") {
        foreach ($value as $itemkey => $link) {
            // echo "[" . $itemkey . " => " . $link . "]";
                $navhtml .= "<li><a href='". $app->url->create($link['route']) ."'>".$link['text']."</a></li>";
        }
    } else if ($key == "dropdown") {
        $navhtml .= "<li class='dropdown'>";

        /*
        * Är det är en dropdown kollar man först efter $dropkey == namn för att sätta namn på dropdownmenyn
        * därefter $dropkey == items för att sätta ut länkarna i menyn.
        */
        foreach ($value as $dropkey => $link) {
            if ($dropkey == "namn") {   //sätter ut namnet på dropdownmenyn
                // echo $link;
                $navhtml .= "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
                $navhtml .= "<ul class='dropdown-menu'>";
            } else if ($dropkey == "items") {    //sätter ut länkarna i dropdownmenyn
                foreach ($link as $droplink) {
                    $navhtml .= "<li><a class='dropdownlink' href='". $app->url->create($droplink['route']) ."' style='color: white;'>".$droplink['text']."</a></li>";
                }
            }
        }
        $navhtml .= "</ul>";
        $navhtml .= "</li>";
    }
}

    // } else if ($key == "dropdown") {
    //     $navhtml .= "<li class='dropdown'>";
    //
    //     /*
    //     * Är det är en dropdown kollar man först efter $dropkey == namn för att sätta namn på dropdownmenyn
    //     * därefter $dropkey == items för att sätta ut länkarna i menyn.
    //     */
    //     foreach ($value as $dropkey => $link) {
    //
    //         if ($dropkey == "namn") {   //sätter ut namnet på dropdownmenyn
    //             // echo $link;
    //             $navhtml .= "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
    //             $navhtml .= "<ul class='dropdown-menu'>";
    //         } else if($dropkey == "items") {    //sätter ut länkarna i dropdownmenyn
    //             foreach($link as $droplink) {
    //                 $navhtml .= "<li><a href='". $app->url->create($droplink['route']) ."'>".$droplink['text']."</a></li>";
    //             }
    //
    //         }
    //
    //     }
    //     $navhtml .= "</ul>";
    //     $navhtml .= "</li>";
    // }

$navhtml .= "</ul>";
// $urlHome  = $app->url->create("");
// $urlAbout = $app->url->create("about");
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <?= $navhtml; ?>
    </div>
</nav>
