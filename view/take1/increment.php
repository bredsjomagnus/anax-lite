<?php

$session = new Maaa16\Session\Session();
$session->start();
if ($session->has('number')) {
    $number = $session->get('number');
    $number = $number + 1;
    $session = $session->set('number', $number);
}
header("location: ../session");
