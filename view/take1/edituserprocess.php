<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
if (isset($_POST['edituserbtn'])) {
    $activeedit = (isset($_POST['active']) || $_POST['active'] != "") ? htmlentities($_POST['active']) : null;
    $id = (isset($_POST['id']) || $_POST['id'] != "") ? htmlentities($_POST['id']) : null;
    $roleedit = (isset($_POST['role']) || $_POST['role'] != "") ? htmlentities($_POST['role']) : null;
    $fornameedit = (isset($_POST['forname']) || $_POST['forname'] != "") ? htmlentities($_POST['forname']) : null;
    $surnameedit = (isset($_POST['surname']) || $_POST['surname'] != "") ? htmlentities($_POST['surname']) : null;
    $emailedit = (isset($_POST['email']) || $_POST['email'] != "") ? htmlentities($_POST['email']) : null;
    if ($activeedit != null && $id != null && $roleedit != null && $fornameedit != null && $surnameedit != null && $emailedit != null) {
        $app->database->connect();
        $sql = "UPDATE accounts SET active = ?, role= ?, forname = ?, surname = ?, email = ? WHERE id = ?";
        $params = [$activeedit, $roleedit, $fornameedit, $surnameedit, $emailedit, $id];
        $sth = $app->database->execute($sql, $params);
        header('Location: adminpageusers');
    } else {
        header('Location: adminpageusers');
    }
}
