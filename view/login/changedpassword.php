<?php

$msg = "";
$app->database->connect();
$username = $app->session->get('user', "");
$sql = "SELECT * FROM accounts WHERE username = '$username'";
if ($res = $app->database->executeFetchAll($sql)) {
    $forname = $res[0]->forname;
    $surname = $res[0]->surname;
    $securepass = $res[0]->pass;
    $msg = " ".$forname;
}
?>
<div class="page">
    <div class="container">
        <h4>Grattis<?= $msg ?>, ditt lösenord ändrades</h4>
    </div>

</div>
