<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
if (isset($_POST['admineditpasswordbtn'])) {
    $newpassoneedit = (isset($_POST['passone']) && $_POST['passone'] != "") ? htmlentities($_POST['passone']) : null;
    $newpasstwoedit = (isset($_POST['passtwo']) && $_POST['passtwo'] != "") ? htmlentities($_POST['passtwo']) : null;
    $id = (isset($_POST['id']) && $_POST['id'] != "") ? htmlentities($_POST['id']) : null;

    if ($newpassoneedit != null && $newpasstwoedit != null && $id != null) {
        $app->database->connect();
        $sql = "SELECT * FROM accounts WHERE id = '$id'";
        if ($res = $app->database->executeFetchAll($sql)) {
            if ($newpassoneedit == $newpasstwoedit) {
                $sql = "UPDATE accounts SET pass = ? WHERE id = ?";
                $securepass = password_hash($newpassoneedit, PASSWORD_DEFAULT);
                $params = [$securepass, $id];
                $sth = $app->database->execute($sql, $params);
                header('Location: adminpageusers');
            } else {
                $app->session->set('passerror', "<p>De nya lösenordet var inte samma i båda fälten. Försök igen.</p>");
                header('Location: edituser?id='.$id);
            }
        }
    } else {
        $app->session->set('passerror', "<p>De nya lösenordet får inte vara tomt. Försök igen.</p>");
        header('Location: edituser?id='.$id);
    }
}
