<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$msg = "";
$deletetable = "";
if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $app->database->connect();
    $sql = "SELECT * FROM accounts WHERE id = '$id'";
    if ($res = $app->database->executeFetchAll($sql)) {
        $forname = $res[0]->forname;
        $surname = $res[0]->surname;
        $msg = $forname . " " . $surname;
        $dbtable = new \Maaa16\DBTable\DBTable();
        $tableproporties = [1, 'id', 'desc', 'id', $id];
        $dbtabletohtml = $dbtable->generateDBTable($app, $tableproporties);
    } else {
        $dbtabletohtml = "Kunde inte koppla upp mot databas och hämta informationen.";
    }
}
if (isset($_POST['deleteuserbtn'])) {
    $id = htmlentities($_POST['idtodelete']);
    $app->database->connect();
    $sql = "DELETE FROM accounts WHERE id = ?";
    $params = [$id];
    $app->database->execute($sql, $params);
    header('Location: adminpageusers');
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpageusers") ?>>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>Ta bort <?= $msg; ?>?</h4>
        </div>

    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <?= $dbtabletohtml ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <form action="#" method="POST">
                <input type="hidden" name="idtodelete" value="<?= $id ?>">
                <input class='right' type="submit" name="deleteuserbtn" value="Ta bort">
            </form>
        </div>
    </div>

</div>
