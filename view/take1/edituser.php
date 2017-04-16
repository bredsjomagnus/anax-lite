<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$msg = "";
$edittable = "";
if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $app->database->connect();
    $sql = "SELECT * FROM accounts WHERE id = '$id'";
    if ($res = $app->database->executeFetchAll($sql)) {
        $forname = $res[0]->forname;
        $surname = $res[0]->surname;
        // $id = $res[0]->id;
        $msg = $forname . " " . $surname;
        $dbtable = new \Maaa16\DBTable\DBTable();
        $tableproporties = [1, 'id', 'desc', 'id', $id];
        $dbtabletohtml = $dbtable->generateDBTableEdit($app, $tableproporties);
        $dbtablepasswordtohtml = $dbtable->generateDBTableEditPassword($app, $tableproporties);
    } else {
        $dbtabletohtml = "Kunde inte koppla upp mot databas och hämta informationen.";
    }
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpage") ?>>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>Redigera <?= $msg; ?></h4>
        </div>

    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <?= $dbtabletohtml ?>
        </div>
    </div>
    <div class="pillow-20">

    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-7">
            <?= $dbtablepasswordtohtml;?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-7">
            <?php
            echo "<br />";
            echo $app->session->get('passerror', '');
            $app->session->delete('passerror');
            ?>
        </div>

    </div>
</div>
