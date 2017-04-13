<?php
if (!$app->session->has('user')) {
    header("Location: login");
}
$msg = "";
$username = $app->session->get('user');
$app->database->connect();
$sql = "SELECT * FROM accounts WHERE username = '$username'";
if ($res = $app->database->executeFetchAll($sql)) {
    $forname = $res[0]->forname;
    $surname = $res[0]->surname;
    $email = $res[0]->email;
    $username = $res[0]->username;
    $msg = $forname . " " . $surname;

    // $email = "youremail@yourhost.com";
    $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
    $gravatar = new \Maaa16\Gravatar\Gravatar($email, $default);
    $gravatar->size = 150;
    $gravatar->rating = "G";
    $gravatar->border = "FF0000";
} else {
    $msg = "<p>Kunde inte ladda kontoinformation.</p>";
}
?>

<div class="page">
    <div class="container">
        <h1>KONTO<small> - <?= $msg  ?></small></h1>
        <div class="row">
            <div class="col-md-2">
            <?= $gravatar->toHTML(); ?>
            </div>
        </div>

        <table class="table accounttable">
            <tr>
                <td><b>Användarnamn</b></td><td><?= $username ?></td>
            </tr>
            <tr>
                <td><b>Förnamn</b></td><td><?= $forname ?></td>
            </tr>
            <tr>
                <td><b>Efternamn</b></td><td><?= $surname ?></td>
            </tr>
            <tr>
                <td><b>Email</b></td><td><?= $email ?></td>
            </tr>
        </table>
    </div>

</div>
