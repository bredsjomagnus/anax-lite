<?php

$app->session->delete('user');
$app->session->delete('role');

header("Location: login");
