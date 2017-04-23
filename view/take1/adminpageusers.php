<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}

if (isset($_POST['pagesselectsubmit'])) {
    $app->session->set('pages', $_POST['pagesselect']);
}
if (isset($_GET['order']) && isset($_GET['orderas'])) {
    $app->session->set('ordercolumn', htmlentities($_GET['order']));
    $app->session->set('orderas', htmlentities($_GET['orderas']));
}
if (isset($_POST['searchbtn'])) {
    $app->session->set('searchfield', htmlentities($_POST['searchfield']));
    $app->session->set('searchradio', htmlentities($_POST['searchradio']));
}
if (isset($_POST['searchbtnall'])) {
    $app->session->set('searchfield', '%%');
    $app->session->set('searchradio', 'username');
    $app->session->set('ordercolumn', 'id');
    $app->session->set('orderas', 'asc');
}

$ordercolumn = $app->session->get('ordercolumn', 'id');
$orderas = $app->session->get('orderas', 'asc');
$pages = $app->session->get('pages', 5);
$searchfield = $app->session->get('searchfield', '%%');
$searchradio = $app->session->get('searchradio', 'username');

// $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

$app->database->connect();
$sql = "SELECT * FROM accounts";
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
                    "databasetable" => 'accounts'
                ];
$dbtable = new \Maaa16\DBTable\DBTable();

if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@]*$/', $searchfield)) {
    $dbtabletohtml = $dbtable->generateDBTableUsers($app, $tableproporties);
    $sql = "SELECT * FROM accounts WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
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
            <a href=<?= $app->url->create("adminpage") ?>>Tillbaka</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>ADMINISTRATÖR - KONTON</h4>
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
        <div class="col-md-5">
            <form action="#" method="POST">
                <label for="searchfile">SÖK</label>
                <input type="text" name="searchfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                <input type="submit" name="searchbtn" value="Sök">
                <input type="submit" name="searchbtnall" value="Återställ tabell">
                <br />
                <label>|&nbsp;<input type="radio" name="searchradio" value="id" <?= ($searchradio == 'id') ? 'checked' : '' ?>>&nbsp;Id | </label>
                <label><input type="radio" name="searchradio" value="role" <?= ($searchradio == 'role') ? 'checked' : '' ?>>&nbsp;Roll | </label>
                <label><input type="radio" name="searchradio" value="username" <?=($searchradio == 'username') ? 'checked' : '' ?>>&nbsp;Användarnamn | </label>
                <label><input type="radio" name="searchradio" value="forname"<?= ($searchradio == 'forname') ? 'checked' : '' ?>>&nbsp;Förnamn | </label>
                <label><input type="radio" name="searchradio" value="surname"<?= ($searchradio == 'surname') ? 'checked' : '' ?>>&nbsp;Efternamn | </label>
                <label><input type="radio" name="searchradio" value="email"<?= ($searchradio == 'email') ? 'checked' : '' ?>>&nbsp;Email | </label>
                <label><input type="radio" name="searchradio" value="created"<?= ($searchradio == 'created') ? 'checked' : '' ?>>&nbsp;Datum | </label>

            </form>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <?php $createurl = $app->url->create('admincreateuser'); ?>
            <br />
            <a class="createuserlink" href=<?= $createurl ?>>Lägg till användare</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?= $dbtabletohtml ?>
        </div>
    </div>
</div>
