<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
if (isset($_POST['editcontentbtn'])) {
    $id = $_POST["contentId"];
    $content = new \Maaa16\Content\Content();
    if (!isset($_POST["contentSlug"]) || $_POST["contentSlug"] == "") {
        $_POST["contentSlug"] = $content->slugify($_POST["contentTitle"]);
    }


    $sluglength = strlen($_POST['contentSlug']);

    $_POST["contentSlug"] = $content->makeSlugUnique($app, $sluglength, $_POST['contentSlug'], $id);

    // $sql = "SELECT id, slug FROM content WHERE slug = ? AND NOT id = ?";
    // while ($app->database->executeFetchAll($sql, [$_POST["contentSlug"], $id])) {
    //     if (strlen($_POST['contentSlug']) == $sluglength) {
    //         $_POST["contentSlug"] = $_POST['contentSlug'] ."-".$counter."";
    //     } else {
    //         $_POST["contentSlug"] = substr($_POST["contentSlug"], 0, $sluglength);
    //         $_POST["contentSlug"] = $_POST['contentSlug'] ."-".$counter."";
    //     }
    //     $counter += 1;
    // }

    $_POST["contentPath"] = $content->checkPath($app, $_POST["contentPath"], $id);

    // $sql = "SELECT path FROM content WHERE path = ? AND NOT id = ?";
    // if ($app->database->executeFetchAll($sql, [$_POST["contentPath"], $id])) {
    //     $_POST["contentPath"] = null;
    //     $errormsg .= "Path måste vara unik. Path sattes till null.<br />";
    // }
    $params = [
            $_POST["contentTitle"],
            $_POST["contentPath"],
            $_POST["contentSlug"],
            $_POST["contentData"],
            $_POST["contentType"],
            $_POST["contentFilter"],
            $_POST["contentId"]
        ];
    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, updated = NOW() WHERE id = ?";
    $app->database->execute($sql, $params);
    $msg = "Sparat";

    header("Location: adminpagecontent");
    exit;
}
