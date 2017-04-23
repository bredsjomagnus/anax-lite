<?php

if (isset($_GET['id']) && isset($_GET['status'])) {
    $contentId = htmlentities($_GET['id']);
    $contentStatus = htmlentities($_GET['status']);
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }
    $app->database->connect();
    if ($contentStatus == 'notPublished') {
        $sql = "UPDATE content SET published=NOW(), status='Published' WHERE id=?;";
        $app->database->execute($sql, [$contentId]);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else if ($contentStatus == 'Published') {
        $sql = "UPDATE content SET published=NULL, status='notPublished' WHERE id=?;";
        $app->database->execute($sql, [$contentId]);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
} else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
