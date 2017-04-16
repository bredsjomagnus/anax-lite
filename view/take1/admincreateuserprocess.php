<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
if (isset($_POST['admincreateuserbtn'])) {
    $forname = isset($_POST['forname']) ? htmlentities($_POST['forname']) : null;
    $surname = isset($_POST['surname']) ? htmlentities($_POST['surname']) : null;
    $email = isset($_POST['email']) ? htmlentities($_POST['email']) : null;
    $username = isset($_POST['username']) ? htmlentities($_POST['username']) : null;
    $passone = isset($_POST['passone']) ? htmlentities($_POST['passone']) : null;
    $passtwo = isset($_POST['passtwo']) ? htmlentities($_POST['passtwo']) : null;
    if ($forname == null || $surname == null || $email == null || $username == null || $passone == null || $passtwo == null) {
        $app->session->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Alla fält måste fyllas i när du skapar nytt konto.</p>");
        header('Location: admincreateuser');
    } else {
        $app->database->connect();
        $sql = "SELECT * FROM accounts WHERE username = '$username'";
        if ($passone != $passtwo) {
            $app->session->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Lösenordet var inte samma vid upprepning.</p>");
            header('Location: admincreateuser');
        } else if ($app->database->executeFetchAll($sql)) {
            $app->session->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Det finns redan konto med det användarnamnet.</p>");
            header('Location: admincreateuser');
        } else if ($passone == $passtwo) {
            $securepass = password_hash($passone, PASSWORD_DEFAULT);
            $sql = "INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES (?, ?, ?, ?, ?, ?)";
            $params = ['user', $username, $securepass, $forname, $surname, $email];
            $sth = $app->database->execute($sql, $params);
            // $app->session->set("user", $username);
            // $app->session->set("forname", $res[0]->forname);
            // $app->cookie->set("user", $username);
            // $app->cookie->set("forname", $forname);
            // $app->cookie->set("name", $app->database->get($))
            header("Location: adminpage");
        }
    }
}
