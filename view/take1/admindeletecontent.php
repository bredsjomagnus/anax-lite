<?php
$contentTitle = "";
if (isset($_GET['id'])) {
    $contentId = htmlentities($_GET['id']);
    $contentStatus = htmlentities($_GET['status']);

    $app->database->connect();
    $sql = "SELECT title FROM content WHERE id = ?";
    $res = $app->database->execute($sql, [$contentId]);
    foreach ($res as $row) {
        $contentTitle = $row->title;
    }
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if ($contentStatus == 'Published') {
        header('Location: adminpagecontent');
    }

    if ($contentStatus == 'isDeleted') {
        $sql = "UPDATE content SET deleted=null, status='notPublished' WHERE id=?;";
        $app->database->execute($sql, [$contentId]);
        header("Location: adminpagecontent");
    }

    if ($contentStatus == 'notPublished') {
        $sql = "UPDATE content SET deleted=NOW(), status='isDeleted' WHERE id=?;";
        $app->database->execute($sql, [$contentId]);
        header("Location: adminpagecontent");
    }
    // if (isset($_POST['deletebtn'])) {
    //     $sql = "UPDATE content SET deleted=NOW(), status='isDeleted' WHERE id=?;";
    //     $app->database->execute($sql, [$contentId]);
    //     header("Location: adminpagecontent");
    // }
}
if (isset($_POST['cancelbtn'])) {
    header('Location: adminpagecontent');
}

?>
<!-- <form action="#" method="POST">
    <input type="text" name="contentTitle" value="<?= $contentTitle ?>">
    <input type="submit" name="deletebtn" value="Radera">
    <input type="submit" name="cancelbtn" value="Ångra">
</form> -->
