<?php

// $session = new Maaa16\Session\Session();
$app->session->start();
$app->session->destroy();
header("location: ../session/dump");
