<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}

if (isset($_POST['pagesselectsubmit'])) {
    $app->session->set('contentpages', $_POST['pagesselect']);
}
if (isset($_GET['order']) && isset($_GET['orderas'])) {
    $app->session->set('contentordercolumn', htmlentities($_GET['order']));
    $app->session->set('contentorderas', htmlentities($_GET['orderas']));
}
if (isset($_POST['searchbtn'])) {
    $app->session->set('contentsearchfield', htmlentities($_POST['searchfield']));
    $app->session->set('contentsearchradio', htmlentities($_POST['searchradio']));
}
if (isset($_POST['searchbtnall'])) {
    $app->session->set('contentsearchfield', '%%');
    $app->session->set('contentsearchradio', 'id');
    $app->session->set('contentordercolumn', 'id');
    $app->session->set('contentorderas', 'asc');
}

$ordercolumn = $app->session->get('contentordercolumn', 'id');
$orderas = $app->session->get('contentorderas', 'asc');
$pages = $app->session->get('contentpages', 5);
$searchfield = $app->session->get('contentsearchfield', '%%');
$searchradio = $app->session->get('contentsearchradio', 'title');

// $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

$app->database->connect();
$sql = "SELECT * FROM content";
$res = $app->database->executeFetchAll($sql);
$totalnumberaccounts = count($res);


// Gamla sättet
// $dbtable = new \Maaa16\DBTable\DBTable();
// $dbtabletohtml = $dbtable->generateDBTable($app, $tableproporties);


// Nya sättet
$tableproporties = [
                    "pages"         => $pages,
                    "orderby"       => $ordercolumn,
                    "orderas"       => $orderas,
                    "searchcolumn"  => $searchradio,
                    "searchfield"   => $searchfield,
                    "databasetable" => 'content'
                ];
$dbtable = new \Maaa16\DBTable\DBTable();

if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@]*$/', $searchfield)) {
    $dbtabletohtml = $dbtable->generateDBTableContent($app, $tableproporties);
    $sql = "SELECT * FROM content WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
    $res = $app->database->executeFetchAll($sql);
    $thisnumberaccounts = count($res);
} else {
    $dbtabletohtml = "<p>Felaktig söksträng.</p>";
    $thisnumberaccounts = 0;
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <span><a href=<?= $app->url->create("adminpage") ?>>Tillbaka</a> | <a href=<?= $app->url->create("page") ?>>Databassidor</a> | <a href=<?= $app->url->create("blog") ?>>Blogg</a></span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>ADMINISTRATÖR - INNEHÅLL</h4>
        </div>
        <div class="col-md-3">
            <span class='info'>Använd % som wildcard när du söker.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st konton</span>"; ?>
            <form action="#" method="POST">
                <select name="pagesselect">
                    <option value="3" <?= ($pages == 3) ? 'selected' : '' ?>>3</option>
                    <option value="5" <?= ($pages == 5) ? 'selected' : '' ?>>5</option>
                    <option value="7" <?= ($pages == 7) ? 'selected' : '' ?>>7</option>
                    <option value="10" <?= ($pages == 10) ? 'selected' : '' ?>>10</option>
                    <option value="15" <?= ($pages == 15) ? 'selected' : '' ?>>15</option>
                    <option value="20" <?= ($pages == 20) ? 'selected' : '' ?>>20</option>
                </select>
                <input type="submit" name="pagesselectsubmit" value="Antal rader">
            </form>
        </div>
        <div class="col-md-6">
            <form action="#" method="POST">
                <label for="searchfile">SÖK</label>
                <input type="text" name="searchfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                <input type="submit" name="searchbtn" value="Sök">
                <input type="submit" name="searchbtnall" value="Återställ tabell">
                <br />
                <label>|&nbsp;<input type="radio" name="searchradio" value="id" <?= ($searchradio == 'id') ? 'checked' : '' ?>>&nbsp;Id | </label>
                <label><input type="radio" name="searchradio" value="title" <?= ($searchradio == 'title') ? 'checked' : '' ?>>&nbsp;Titel | </label>
                <label><input type="radio" name="searchradio" value="type" <?=($searchradio == 'type') ? 'checked' : '' ?>>&nbsp;Typ | </label>
                <label><input type="radio" name="searchradio" value="status"<?= ($searchradio == 'status') ? 'checked' : '' ?>>&nbsp;Status | </label>
                <label><input type="radio" name="searchradio" value="published"<?= ($searchradio == 'published') ? 'checked' : '' ?>>&nbsp;Publicerad | </label>
                <label><input type="radio" name="searchradio" value="created"<?= ($searchradio == 'created') ? 'checked' : '' ?>>&nbsp;Skapad | </label>
                <label><input type="radio" name="searchradio" value="updated"<?= ($searchradio == 'updated') ? 'checked' : '' ?>>&nbsp;Uppdaterad | </label>
                <label><input type="radio" name="searchradio" value="deleted"<?= ($searchradio == 'deleted') ? 'checked' : '' ?>>&nbsp;Borttagen | </label>
            </form>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <?php $createurl = $app->url->create('admincreatecontent'); ?>
            <br />
            <a class="createuserlink" href=<?= $createurl ?>>Lägg till innehåll</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <?= $dbtabletohtml ?>
        </div>
    </div>
</div>
