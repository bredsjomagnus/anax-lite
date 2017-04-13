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
                "text" => "HEM",
                "route" => "",
                "class" => ""
            ],
            "redovisning" => [
                "text" => "REDOVISNINGAR",
                "route" => "report",
                "class" => ""
            ],
            "om" => [
                "text" => "OM",
                "route" => "about",
                "class" => ""
            ],
            "login" => [
                "text" => "LOGGA IN",
                "route" => "login",
                "class" => ""
            ],
            "logout" => [
                "text" => "LOGGA UT",
                "route" => "logout",
                "class" => ""
            ]
        ],
        "dropdown" => [
            "namn" => "UPPGIFTER",
            "items" => [
                "gissa" => [
                    "text" => "Guess the number",
                    "route" => "guessing"
                ],
                "session" => [
                    "text" => "Session",
                    "route" => "session"
                ],
                "cookie" => [
                    "text" => "Cookie",
                    "route" => "cookie"
                ],
                "calendar" => [
                    "text" => "Kalender",
                    "route" => "calendar"
                ]
            ]
        ]
    ]
];
