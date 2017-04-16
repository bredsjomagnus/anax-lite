<?php
$usermsg = "";
$passmsg = "";
$loginmsg = isset($_SESSION['createusererrormsg']) ? $_SESSION['createusererrormsg']: "";
if (isset($_POST['loginsubmit'])) {
    $userdone = true;
    $passdone = true;
    // $passdone = false;
    if ($_POST['user'] == "") {
        $usermsg = "&nbsp;&nbsp;&nbsp; Måste fylla i användarnamn";
        $userdone = false;
    }
    if ($_POST['pass'] == "") {
        $passmsg = "&nbsp;&nbsp;&nbsp;* Måste fylla i lösenord";
        $passdone = false;
    }
    if ($userdone && $passdone) {
        $loginuser =  htmlentities($_POST["user"]);
        $loginpass =  htmlentities($_POST["pass"]);
        $app->database->connect();
        $sql = "SELECT * FROM accounts WHERE BINARY username = BINARY '$loginuser'";
        if ($res = $app->database->executeFetchAll($sql)) {
            $dbpass = $res[0]->pass;
            $passwordverify = password_verify($loginpass, $dbpass);
            if ($res[0]->active != 'yes') {
                $loginmsg = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Konto deaktiverat av administratör.</span>";
            } else if ($passwordverify) {
                $app->session->set("user", $loginuser);
                $app->session->set("role", $res[0]->role);
                $app->session->set("hash", password_hash($loginpass, PASSWORD_DEFAULT));
                // $app->session->set("forname", $res[0]->forname);
                $app->cookie->set("user", $loginuser);
                $app->cookie->set("forname", $res[0]->forname);
                if (isset($_POST['remember'])) {
                    $app->cookie->set("password", $loginpass);
                }
                // $app->cookie->set("name", $app->database->get($))
                header("Location: welcome");
            } else {
                $loginmsg = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>";
            }
        } else {
            $loginmsg = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>";
        }
    }
}
?>


<div class="page">
    <div class="container">
        <div class="pillow-100">
        </div>
        <div class="col-md-offset-4 col-md-4">
            <form action="#" method="POST">
                <legend>LOGGA IN</legend>
                <div class="form-group">
                    <label for="user">Användarnamn </label><span class="formerror"><?= $usermsg ?></span>
                    <input class="form-control" type="text" name="user" value="<?= $app->cookie->get("user", ""); ?>" placeholder="Användarnamn">
                </div>
                <div class="form-group">
                    <label for="pass">Lösenord: </label><span class="formerror"><?= $passmsg ?></span>
                    <input class="form-control" type="password" name="pass" value="<?= $app->cookie->get("password", ""); ?>" placeholder="Lösenord">
                </div>
                <span>
                    <input class='btn btn-primary' type='submit' name='loginsubmit' value='Logga in'>
                    <span>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="remember" value="">&nbsp;&nbsp;&nbsp;Kom ihåg mig på denna datorn</span>
                </span>
                <br />
                <div class="pillow-20">

                </div>
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addemployeemodal" aria-expanded="false" aria-controls="addemployeemodal">Skapa konto</button>
                <?= $loginmsg ?>
            </form>
            <br />

        </div>


        <!-- modal -->
        <div class="modal fade" id="addemployeemodal" tabindex="-1" role="dialog" aria-labelledby="addemployeemodalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addemployeemodalLabel">SKAPA KONTO</h4>
                    </div>
                    <form role="form" method="POST" action="createuser">
                        <div class="modal-body">
                            <i>Alla fält måste fyllas i.</i>
                            <div class="modal-subheader">
                                <h4>PERSONUPPGIFTER</h4>
                            </div>
                            <div class="form-group">
                                <label class="modal-label" for="forname">Förnamn </label>
                                <input type="text" name="forname" class="form-control" placeholder="Förnamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="surname">Efternamn </label>
                                <input type="text" name="surname" class="form-control" placeholder="Efternamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="email">Email </label>
                                <input type="email" name="email" class="form-control" placeholder="Email"/>
                            </div>

                            <div class="modal-subheader">
                                <h4>KONTOUPPGIFTER</h4>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="username">Användarnamn </label>
                                <input type="text" name="username" class="form-control" placeholder="Användarnamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="passone">Lösenord </label>
                                <input type="password" name="passone" class="form-control" placeholder="Lösenord"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="passtwo">Upprepa lösenordet </label>
                                <input type="password" name="passtwo" class="form-control" placeholder="Upprepa lösenord"/>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Ångra</button>
                            <button type="submit" name='createuserbtn' class="btn btn-primary">Skapa konto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /modal -->

    </div>
</div>
<!--  ||  -->
