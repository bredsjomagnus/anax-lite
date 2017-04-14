<?php

$msg = "";
$app->database->connect();
$username = $app->session->get('user', "");
$sql = "SELECT * FROM accounts WHERE username = '$username'";
if ($res = $app->database->executeFetchAll($sql)) {
    $forname = $res[0]->forname;
    $surname = $res[0]->surname;
    $msg = $forname . " " . $surname;
}
?>
<div class="page">
    <div class="container">
        <h1>Välkommen<small> - <?= $msg ?></small></h1>

    </div>

</div>
