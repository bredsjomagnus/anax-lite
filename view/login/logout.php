<?php

$app->session->delete('user');

header("Location: login");
