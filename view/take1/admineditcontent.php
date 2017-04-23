<?php
$errormsg = "";
$msg = "";
if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $app->database->connect();
    $sql = "SELECT * FROM content WHERE id = ?";

    if ($res = $app->database->executeFetchAll($sql, [$id])) {
        $contentTitle = $res[0]->title;
        $dbtable = new \Maaa16\DBTable\DBTable();
        $tableproporties = [
                            "pages"         => 1,
                            "orderby"       => 'id',
                            "orderas"       => 'desc',
                            "searchcolumn"  => 'id',
                            "searchfield"   => $id,
                            "databasetable" => 'content'
                        ];
        $dbtabletohtml = $dbtable->generateDBTableEditContent($app, $tableproporties);
        // $dbtablepasswordtohtml = $dbtable->generateDBTableEditPassword($app, $tableproporties);
    } else {
        $dbtabletohtml = "Kunde inte koppla upp mot databas och hämta informationen.";
    }
}

?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpagecontent") ?>>Tillbaka</a>
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
</div>
