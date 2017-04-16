<?php
if (!$app->session->has('user')) {
    header("Location: login");
}
$msg = "";
$passerror = "";
$adminurl = $app->url->create('adminpage');
$adminrow = ($app->session->get('role') == 'admin') ? "<tr><td><b>Roll</b></td><td><a href='$adminurl'>Administratör</a></td></tr>": "";
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

if (isset($_POST['editaccount'])) {
    $app->database->connect();
    // $sql = "SELECT * FROM accounts WHERE username = '$username'";
    // $res = $app->database->executeFetchAll($sql);
    // $fornamebefore = $res[0]->forname;
    // $surnamebefore = $res[0]->surname;
    // $emailbefore = $res[0]->email;
    // $username = $res[0]->username;


    $fornameedit = (isset($_POST['forname']) || $_POST['forname'] != "") ? htmlentities($_POST['forname']) : null;
    $surnameedit = (isset($_POST['surname']) || $_POST['surname'] != "") ? htmlentities($_POST['surname']) : null;
    $emailedit = (isset($_POST['email']) || $_POST['email'] != "") ? htmlentities($_POST['email']) : null;

    if ($fornameedit != null && $surnameedit != null && $emailedit != null) {
        $sql = "UPDATE accounts SET forname = ?, surname = ?, email = ? WHERE username = ?";
        $params = [$fornameedit, $surnameedit, $emailedit, $username];
        $sth = $app->database->execute($sql, $params);

        // Ser till att uppdatera sidan korrekt efter förändringarna
        $sql = "SELECT * FROM accounts WHERE username = '$username'";
        if ($res = $app->database->executeFetchAll($sql)) {
            $forname = $res[0]->forname;
            $surname = $res[0]->surname;
            $email = $res[0]->email;
            $username = $res[0]->username;
            $msg = $forname . " " . $surname;
            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar($email, $default);
            $gravatar->size = 150;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";
        }
    }
} else if (isset($_POST['deleteaccount'])) {
    $app->database->connect();
    $sql = "DELETE FROM accounts WHERE username = ?";
    $params = [$username];
    $app->database->execute($sql, $params);
    header('Location: logout');
} else if (isset($_POST['editpassword'])) {
    $oldpassedit = (isset($_POST['oldpass']) && $_POST['oldpass'] != "") ? htmlentities($_POST['oldpass']) : null;
    $newpassoneedit = (isset($_POST['newpassone']) && $_POST['newpassone'] != "") ? htmlentities($_POST['newpassone']) : null;
    $newpasstwoedit = (isset($_POST['newpasstwo']) && $_POST['newpasstwo'] != "") ? htmlentities($_POST['newpasstwo']) : null;
    if ($oldpassedit != null && $newpassoneedit != null && $newpasstwoedit != null) {
        $app->database->connect();
        $sql = "SELECT * FROM accounts WHERE username = '$username'";
        if ($res = $app->database->executeFetchAll($sql)) {
            $oldpass = $res[0]->pass;
            if (password_verify($oldpassedit, $oldpass)) {
                if ($newpassoneedit == $newpasstwoedit) {
                    $sql = "UPDATE accounts SET pass = ? WHERE username = ?";
                    $securepass = password_hash($newpassoneedit, PASSWORD_DEFAULT);
                    $params = [$securepass, $username];
                    $sth = $app->database->execute($sql, $params);
                    header('Location: changedpassword');
                } else {
                    $passerror = "<p>De nya lösenordet var inte samma i båda fälten. Försök igen.</p>";
                }
            } else {
                $passerror = "<p>Felaktigt nuvanrande lösenord. Försök igen.</p>";
            }
        }
    } else {
        $passerror = "<p>Nytt lösenord får inte vara tomt.</p>";
    }
}
?>

<div class="page">
    <div class="container">

        <p class='info'>Ingen profilbild? Sidan använder sig av <a href="https://sv.gravatar.com/">Gravatar</a>. Gå genast dit och koppla en profilbild till din emailadress.</p>
        <h1>KONTO<small> - <?= $msg  ?></small></h1>
        <div class="row">
            <div class="col-md-3">
            <?= $gravatar->toHTML(); ?>
            <br />

            </div>
        </div>

        <table class="table accounttable">
            <?= $adminrow ?>
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
        <div class="row">
            <div class="col-md-5">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#editprofileinfocollapse" aria-expanded="false" aria-controls="editprofileinfocollapse">
                Redigera profilinformation
                </button>
            </div>

            <div class="col-md-5">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#editpasswordcollapse" aria-expanded="false" aria-controls="editpasswordcollapse">
                Ändra lösenord
                </button>
                <?= $passerror ?>
            </div>

            <div class="col-md-5">

                <div class="collapse" id="editprofileinfocollapse">
                    <div class="pillow-20">

                    </div>
                    <div class="well">
                        <p class='info'>Justera de felaktiga fälten och tryck därefter på 'Redigera' för att utföra ändringen.</p>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="forname">Förnamn</label>
                                <input class="form-control" type="text" name="forname" value=<?= $forname ?> placeholder="Förnamn">
                            </div>
                            <div class="form-group">
                                <label for="forname">Efternamn</label>
                                <input class="form-control" type="text" name="surname" value=<?= $surname ?> placeholder="Efternamn">
                            </div>
                            <div class="form-group">
                                <label for="forname">Email</label>
                                <input class="form-control" type="email" name="email" value=<?= $email ?> placeholder="Email">
                            </div>

                            <input class="btn btn-primary" type="submit" name="editaccount" value="Redigera">
                            <input class="btn btn-danger right" type="submit" name="deleteaccount" value="Radera konto">
                        </form>
                    </div>
                </div>

        </div>

        <div class="col-md-5">
            <div class="collapse" id="editpasswordcollapse">
                <div class="pillow-20">

                </div>
                <div class="well">
                    <p class='info'>Skriv in ditt nuvarande lösenord följt av det nya lösenordet två gånger.</p>
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="forname">Nuvarande lösenord</label>
                            <input class="form-control" type="password" name="oldpass" value="" placeholder="Nuvarande lösenord">
                        </div>
                        <div class="form-group">
                            <label for="forname">Nytt lösenord</label>
                            <input class="form-control" type="password" name="newpassone" value="" placeholder="Nytt lösenord">
                        </div>
                        <div class="form-group">
                            <label for="forname">Nytt lösenord igen</label>
                            <input class="form-control" type="password" name="newpasstwo" value="" placeholder="Nytt lösenord igen">
                        </div>

                        <input class="btn btn-primary" type="submit" name="editpassword" value="Ändra lösenordet">
                    </form>
                </div>
            </div>

        </div>

</div>
    </div>

</div>
