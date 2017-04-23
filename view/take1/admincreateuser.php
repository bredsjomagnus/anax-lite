<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$dbtable = new \Maaa16\DBTable\DBTable();
$dbtabletohtml = $dbtable->createRowTable();
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpageusers") ?>>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>Lägg till användare</h4>
        </div>

    </div>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            <?php
            echo $dbtabletohtml;
            echo $app->session->get('createusererrormsg', '');
            $app->session->delete('createusererrormsg');
            ?>
        </div>
    </div>

</div>
