<?php
$contentTitle = "";
if (isset($_GET['id'])) {
    $contentId = htmlentities($_GET['id']);

    $app->database->connect();
    $sql = "SELECT title FROM content WHERE id = ?";
    $res = $app->database->execute($sql, [$contentId]);
    foreach ($res as $row) {
        $contentTitle = $row->title;
    }
    if (!is_numeric($contentId)) {
        die("Not valid for content id.");
    }

    if (isset($_POST['terminatebtn'])) {
        $sql = "DELETE FROM content WHERE id=?;";
        $app->database->execute($sql, [$contentId]);
        header("Location: adminpagecontent");
    }
}
if (isset($_POST['cancelbtn'])) {
    header('Location: adminpagecontent');
}

?>
<div class="page">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <h3>Ta bort permanent</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="contentTitle">Title</label>
                    <span class="terminateinfo" name="contentTitle"><?= $contentTitle ?></span>
                </div>

                <input type="submit" name="terminatebtn" value="Radera">
                <input type="submit" name="cancelbtn" value="Ångra">
            </form>
        </div>
    </div>
</div>
