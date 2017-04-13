<?php
$forname = isset($_POST['forname']) ? htmlentities($_POST['forname']) : null;
$surname = isset($_POST['surname']) ? htmlentities($_POST['surname']) : null;
$email = isset($_POST['email']) ? htmlentities($_POST['email']) : null;
$username = isset($_POST['username']) ? htmlentities($_POST['username']) : null;
$passone = isset($_POST['passone']) ? htmlentities($_POST['passone']) : null;
$passtwo = isset($_POST['passtwo']) ? htmlentities($_POST['passtwo']) : null;

unset($_SESSION['createusererrormsg']);

// echo $forname . " " . $surname . " " . $email . " " . $username . " " . $passone . " " . $passtwo;
if ($forname == null || $surname == null || $email == null || $username == null || $passone == null || $passtwo == null) {
    $_SESSION['createusererrormsg'] = "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Alla fält måste fyllas i när du skapar nytt konto.</p>";
    header('Location: login');
} else {
    if ($passone == $passtwo) {
        $securepass = password_hash($passone, PASSWORD_DEFAULT);
        $app->database->connect();
        $sql = "INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES (?, ?, ?, ?, ?, ?)";
        $params = ['user', $username, $securepass, $forname, $surname, $email];
        $sth = $app->database->execute($sql, $params);
        header('Location: login');
    } else {
        $_SESSION['createusererrormsg'] = "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Lösenordet var inte samma vid upprepning.</p>";
        header('Location: login');
    }
}
