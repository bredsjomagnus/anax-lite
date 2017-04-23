<?php
if (isset($_POST['createbtn'])) {
    $title = htmlentities($_POST['contentTitle']);
    $app->database->connect();
    $sql = "INSERT INTO content (title) VALUES (?);";
    $app->database->execute($sql, [$title]);
    $id = $app->database->lastInsertId();
    $adminediturl = $app->url->create('admineditcontent');
    header("Location: ".$adminediturl."?id=$id");
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="contentTitle">Namn</label>
                    <input type="text" name="contentTitle" value="">
                </div>
                <input type="submit" name="createbtn" value="Skapa">
            </form>
        </div>
    </div>
</div>
