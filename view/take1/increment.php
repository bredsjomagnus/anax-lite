<?php

// $app->session = new \Maaa16\Session\Session();
// $app->session->start();
if ($app->session->has('number')) {
    $number = $app->session->get('number');
    $number = $number + 1;
    $app->session->set('number', $number);
}
header("location: ../session");
