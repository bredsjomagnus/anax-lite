<?php

$session = new Maaa16\Session\Session();
$session->start();
$session->destroy();
header("location: ../session/dump");
