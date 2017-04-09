<?php
/**
* config file for navbar
*/
return [
    "navbar" => [
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
                ],
                "calendar" => [
                    "text" => "Kalender",
                    "route" => "calendar"
                ]    
            ]
        ]
    ]
];
// return "fisk";
