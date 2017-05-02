<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}

$tableselect = (isset($_POST['storagetablebtn'])) ? htmlentities($_POST['storagetableselect']) : '';
// echo $tableselect;
if ($tableselect == 'concatedall') {
    // $tab = 'concatedall';
    header('Location: ?tab=concatedall');
} else if ($tableselect == 'isolated') {
    // $tab = 'isolated';
    // echo "ändrar tab till isolateda";
    header('Location: ?tab=isolated');
}
$tab = (isset($_GET['tab'])) ? htmlentities($_GET['tab']) : 'produkter';


// echo $_GET['tab'];

if ($tab == 'produkter') {
    $app->database->connect();

    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('productpages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('productordercolumn', htmlentities($_GET['order']));
        $app->session->set('productorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchproductbtn'])) {
        $app->session->set('productsearchfield', htmlentities($_POST['searchproductfield']));
        $app->session->set('productsearchradio', htmlentities($_POST['searchproductradio']));
    }
    if (isset($_POST['searchbtnallproducts'])) {
        $app->session->set('productsearchfield', '%%');
        $app->session->set('productsearchradio', 'title');
        $app->session->set('productordercolumn', 'articleid');
        $app->session->set('productorderas', 'asc');
    }

    $ordercolumn = $app->session->get('productordercolumn', 'articleid');
    $orderas = $app->session->get('productorderas', 'asc');
    $pages = $app->session->get('productpages', 5);
    $searchfield = $app->session->get('productsearchfield', '%%');
    $searchradio = $app->session->get('productsearchradio', 'title');

    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM prod2CatView";
    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'prod2CatView'
                    ];
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s]*$/', $searchfield)) {
        $dbtableprodukter = $dbtable->generateDBTableWebshop($app, 'produkter', $tableproporties);
        $sql = "SELECT * FROM prod2CatView WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtableprodukter = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
} else if ($tab == 'concatedall') { // *************************** lageröversikt
    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('lagerallpages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('lagerallordercolumn', htmlentities($_GET['order']));
        $app->session->set('lagerallorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchlagerbtn'])) {
        $app->session->set('lagerallsearchfield', htmlentities($_POST['searchlagerfield']));
        $app->session->set('lagerallsearchradio', htmlentities($_POST['searchlagerradio']));
    }
    if (isset($_POST['searchbtnalllagers'])) {
        $app->session->set('lagerallsearchfield', '%%');
        $app->session->set('lagerallsearchradio', 'title');
        $app->session->set('lagerallordercolumn', 'shelfsection');
        $app->session->set('lagerallorderas', 'asc');
    }

    $ordercolumn = $app->session->get('lagerallordercolumn', 'shelfsection');
    $orderas = $app->session->get('lagerallorderas', 'asc');
    $pages = $app->session->get('lagerallpages', 5);
    $searchfield = $app->session->get('lagerallsearchfield', '%%');
    $searchradio = $app->session->get('lagerallsearchradio', 'title');

    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM InventoryConcatedView";

    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'InventoryConcatedView'
                    ];
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s\,]*$/', $searchfield)) {
        $dbtablelager = $dbtable->generateDBTableWebshop($app, 'concatedall', $tableproporties);

        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtablelager = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
} else if ($tab == 'isolated') {
    // echo "komme rin i isolateda";
    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('lagerApages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('lagerAordercolumn', htmlentities($_GET['order']));
        $app->session->set('lagerAorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchlagerbtn'])) {
        $app->session->set('lagerAsearchfield', htmlentities($_POST['searchlagerfield']));
        $app->session->set('lagerAsearchradio', htmlentities($_POST['searchlagerradio']));
    }
    if (isset($_POST['searchbtnalllagers'])) {
        $app->session->set('lagerAsearchfield', '%%');
        $app->session->set('lagerAsearchradio', 'title');
        $app->session->set('lagerAordercolumn', 'shelfsection');
        $app->session->set('lagerAorderas', 'asc');
        // echo "återställer";
    }

    $ordercolumn = $app->session->get('lagerAordercolumn', 'shelfsection');
    $orderas = $app->session->get('lagerAorderas', 'asc');
    $pages = $app->session->get('lagerApages', 5);
    $searchfield = $app->session->get('lagerAsearchfield', '%%');
    $searchradio = $app->session->get('lagerAsearchradio', 'storagesection');

    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM InventoryIsolatedView";
    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'InventoryIsolatedView'
                    ];

    // print_r($tableproporties);
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s\,]*$/', $searchfield)) {
        $dbtablelager = $dbtable->generateDBTableWebshop($app, 'isolated', $tableproporties);
        // echo "lagertabell " . $dbtablelager;
        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtablelager = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
} else if ($tab == 'customers') {
    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('lagercustomerpages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('lagercustomerordercolumn', htmlentities($_GET['order']));
        $app->session->set('lagercustomerorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchcustomerbtn'])) {
        $app->session->set('lagercustomersearchfield', htmlentities($_POST['searchcustomerfield']));
        $app->session->set('lagercustomersearchradio', htmlentities($_POST['searchcustomerradio']));
    }
    if (isset($_POST['searchbtnallcustomer'])) {
        $app->session->set('lagercustomerordercolumn', 'id');
        $app->session->set('lagercustomerorderas', 'asc');
        $app->session->set('lagercustomersearchradio', 'username');
        $app->session->set('lagercustomersearchfield', '%%');
    }

    $pages = $app->session->get('lagercustomerpages', 5);
    $ordercolumn = $app->session->get('lagercustomerordercolumn', 'id');
    $orderas = $app->session->get('lagercustomerorderas', 'asc');
    $searchradio = $app->session->get('lagercustomersearchradio', 'username');
    $searchfield = $app->session->get('lagercustomersearchfield', '%%');


    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM Customer";
    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'Customer'
                    ];

    // print_r($tableproporties);
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s\,]*$/', $searchfield)) {
        $dbtablecustomer = $dbtable->generateDBTableWebshop($app, 'customers', $tableproporties);
        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtablecustomer = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
} else if ($tab == 'orders') {
    $deliver = (isset($_GET['deliver'])) ? htmlentities($_GET['deliver']) : 'no';
    $deliverid = (isset($_GET['deliverid'])) ? htmlentities($_GET['deliverid']) : null;
    if ($deliver == 'yes' && $deliverid != null) {
        $app->database->connect();
        $sql="UPDATE `Order` SET status = ?, delivery = NOW() WHERE id = ?";
        $param = ['delivered', $deliverid];
        $app->database->execute($sql, $param);
    }
    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('lagerorderspages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('lagerordersordercolumn', htmlentities($_GET['order']));
        $app->session->set('lagerordersorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchordersbtn'])) {
        $app->session->set('lagerorderssearchfield', htmlentities($_POST['searchordersfield']));
        $app->session->set('lagerorderssearchradio', htmlentities($_POST['searchordersradio']));
    }
    if (isset($_POST['searchbtnallorders'])) {
        $app->session->set('lagerordersordercolumn', 'orderid');
        $app->session->set('lagerordersorderas', 'asc');
        $app->session->set('lagerorderssearchradio', 'orderid');
        $app->session->set('lagerorderssearchfield', '%%');
    }

    $pages = $app->session->get('lagerorderspages', 5);
    $ordercolumn = $app->session->get('lagerordersordercolumn', 'orderid');
    $orderas = $app->session->get('lagerordersorderas', 'asc');
    $searchradio = $app->session->get('lagerorderssearchradio', 'orderid');
    $searchfield = $app->session->get('lagerorderssearchfield', '%%');


    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM OrderView";
    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'OrderView'
                    ];

    // print_r($tableproporties);
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s\,]*$/', $searchfield)) {
        $dbtableorders = $dbtable->generateDBTableWebshop($app, 'orders', $tableproporties);
        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtableorders = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
} else if ($tab == 'invoices') {
    $payed = (isset($_GET['payed'])) ? htmlentities($_GET['payed']) : 'no';
    $paymentid = (isset($_GET['paymentid'])) ? htmlentities($_GET['paymentid']) : null;
    if ($payed == 'yes' && $paymentid != null) {
        $app->database->connect();
        $sql="UPDATE Invoice SET invoicestatus = ?, payed = NOW() WHERE id = ?";
        $param = ['payed', $paymentid];
        $app->database->execute($sql, $param);
    }
    if (isset($_POST['pagesselectsubmit'])) {
        $app->session->set('invoicespages', $_POST['pagesselect']);
    }
    if (isset($_GET['order']) && isset($_GET['orderas'])) {
        $app->session->set('invoicesordercolumn', htmlentities($_GET['order']));
        $app->session->set('invoicesorderas', htmlentities($_GET['orderas']));
    }
    if (isset($_POST['searchinvoicesbtn'])) {
        $app->session->set('invoicessearchfield', htmlentities($_POST['searchinvoicesfield']));
        $app->session->set('invoicessearchradio', htmlentities($_POST['searchinvoicesradio']));
    }
    if (isset($_POST['searchbtnallinvoices'])) {
        $app->session->set('invoicesordercolumn', 'invoiceid');
        $app->session->set('invoicesorderas', 'asc');
        $app->session->set('invoicessearchradio', 'invoiceid');
        $app->session->set('invoicessearchfield', '%%');
    }

    $pages = $app->session->get('invoicespages', 5);
    $ordercolumn = $app->session->get('invoicesordercolumn', 'invoiceid');
    $orderas = $app->session->get('invoicesorderas', 'asc');
    $searchradio = $app->session->get('invoicessearchradio', 'invoiceid');
    $searchfield = $app->session->get('invoicessearchfield', '%%');


    // $tableproporties = [$pages, $ordercolumn, $orderas, $searchradio, $searchfield];

    $app->database->connect();
    $sql = "SELECT * FROM InvoiceView";
    $res = $app->database->executeFetchAll($sql);
    $totalnumberaccounts = count($res);

    $tableproporties = [
                        "pages"         => $pages,
                        "orderby"       => $ordercolumn,
                        "orderas"       => $orderas,
                        "searchcolumn"  => $searchradio,
                        "searchfield"   => $searchfield,
                        "databasetable" => 'InvoiceView'
                    ];

    // print_r($tableproporties);
    $dbtable = new \Maaa16\Webshopcontent\Webshopcontent();

    if (preg_match('/^[a-zA-ZåäöÅÄÖ0-9\%\@\s\,]*$/', $searchfield)) {
        $dbtableinvoices = $dbtable->generateDBTableWebshop($app, 'invoices', $tableproporties);
        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        $res = $app->database->executeFetchAll($sql);
        $thisnumberaccounts = count($res);
    } else {
        $dbtableinvoices = "<p>Felaktig söksträng.</p>";
        $thisnumberaccounts = 0;
    }
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <span><a href=<?= $app->url->create("adminpage") ?>>Tillbaka</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>ADMINISTRATÖR - WEBBSHOP</h4>
        </div>
    </div>
    <div class="row">
        <div class='col-md-10 col-md-offset-1'>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li role="presentation" class="<?= ($tab == 'produkter') ? 'active' : '' ?>"><a href="?tab=produkter">PRODUKTER</a></li>
                <li role="presentation" class="<?= ($tab == 'concatedall' || $tab == 'isolated') ? 'active' : '' ?>"><a href="?tab=isolated">LAGER</a></li>
                <li role="presentation" class="<?= ($tab == 'customers') ? 'active' : '' ?>"><a href="?tab=customers">KUNDER</a></li>
                <li role="presentation" class="<?= ($tab == 'orders') ? 'active' : '' ?>"><a href="?tab=orders">ORDERS</a></li>
                <li role="presentation" class="<?= ($tab == 'invoices') ? 'active' : '' ?>"><a href="?tab=invoices">FAKTUROR</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <!-- PRODUKTERTABBEN -->
                <div role="tabpanel" class="<?= ($tab == 'produkter') ? 'tab-pane active' : 'tab-pane' ?>">
                    <div class="tabcontent">
                        <div class="row">
                            <div class="col-md-2">
                                <h4>PRODUKTTABELL</h4>
                            </div>
                            <div class="col-md-3">
                                <span class='info'>Använd % som wildcard när du söker.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st produkter</span>"; ?>
                                <form action="?tab=<?= $tab ?>" method="POST">
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
                                <form action="?tab=<?= $tab ?>" method="POST">
                                    <label for="searchfile">SÖK</label>
                                    <input type="text" name="searchproductfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                                    <input type="submit" name="searchproductbtn" value="Sök">
                                    <input type="submit" name="searchbtnallproducts" value="Återställ tabell">
                                    <br />
                                    <label>|&nbsp;<input type="radio" name="searchlagerradio" value="articleid" <?= ($searchradio == 'articleid') ? 'checked' : '' ?>>&nbsp;Artikelid | </label>
                                    <label><input type="radio" name="searchproductradio" value="title" <?= ($searchradio == 'title') ? 'checked' : '' ?>>&nbsp;Titel | </label>
                                    <label><input type="radio" name="searchproductradio" value="category" <?=($searchradio == 'category') ? 'checked' : '' ?>>&nbsp;Kategori | </label>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <?php $createurl = $app->url->create('admincreateproduct'); ?>
                                <br />
                                <a class="createuserlink" href=<?= $createurl ?>>Lägg till produkt</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <?= $dbtableprodukter ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /PRODUKTERTAB -->

                <!--
                    TAB FÖR LAGER
                -->
                <div role="tabpanel" class="<?= ($tab == 'concatedall' || $tab == 'isolated') ? 'tab-pane active' : 'tab-pane' ?>">
                    <!-- LAGERTABBEN -->
                    <div role="tabpanel" class="<?= ($tab == 'concatedall' || $tab == 'isolated') ? 'tab-pane active' : 'tab-pane' ?>">
                        <div class="tabcontent">
                            <div class="row">
                                <div class="col-md-2">
                                    <h4>LAGERTABELLER</h4>
                                </div>
                                <div class="col-md-7">
                                    <div class="pillow-20">

                                    </div>
                                    <p class='text-muted-admin'>Lagret har två lagersektioner; <span class='text-highlight-admin'>A</span> och <span class='text-highlight-admin'>B</span>. Varje lagersektion har tre hyllsektioner <span class='text-highlight-admin'>A1-A3</span> och <span class='text-highlight-admin'>B1-B3</span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <h4>Välj typ av tabell</h4>
                                    <form action="#" method="POST">
                                        <select class="form-group" name="storagetableselect">
                                            <option class='form-control' value="isolated" <?= ($tab == 'isolated') ? 'selected' : '' ?>>Uppdelad tabell</option>
                                            <option class='form-control' value="concatedall" <?= ($tab == 'concatedall') ? 'selected' : '' ?>>Sammanslagen tabell</option>
                                        </select>
                                        <input type="submit" name="storagetablebtn" value="välj">
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2">
                                    <span class='info'>Använd % som wildcard när du söker.</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st</span>"; ?>
                                    <form action="?tab=<?=$tab?>" method="POST">
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
                                    <form action="?tab=<?=$tab?>" method="POST">
                                        <label for="searchfile">SÖK</label>
                                        <input type="text" name="searchlagerfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                                        <input type="submit" name="searchlagerbtn" value="Sök">
                                        <input type="submit" name="searchbtnalllagers" value="Återställ tabell">
                                        <br />
                                        <label>|&nbsp;<input type="radio" name="searchlagerradio" value="storagesection" <?= ($searchradio == 'storagesection') ? 'checked' : '' ?>>&nbsp;Lagersektion | </label>
                                        <label><input type="radio" name="searchlagerradio" value="shelfsection" <?= ($searchradio == 'shelfsection') ? 'checked' : '' ?>>&nbsp;Hyllsektion | </label>
                                        <label><input type="radio" name="searchlagerradio" value="shelfrowid" <?= ($searchradio == 'shelfrowid') ? 'checked' : '' ?>>&nbsp;Hyllplats | </label>
                                        <label><input type="radio" name="searchlagerradio" value="articleid" <?= ($searchradio == 'artikleid') ? 'checked' : '' ?>>&nbsp;Artikelid | </label>
                                        <label><input type="radio" name="searchlagerradio" value="title" <?=($searchradio == 'title') ? 'checked' : '' ?>>&nbsp;Title | </label>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <?php $createurl = $app->url->create('adminwebbshopnewshelfrow?step=1'); ?>
                                    <br />
                                    <a class="createuserlink" href=<?= $createurl ?>>Lägg till produkt till lager</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $dbtablelager ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /LAGERTAB -->

                <!--
                    TAB FÖR KUNDER
                -->
                <div role="tabpanel" class="<?= ($tab == 'customers') ? 'tab-pane active' : 'tab-pane' ?>">
                    <!-- KUNDERTABBEN -->
                    <div role="tabpanel" class="<?= ($tab == 'customers') ? 'tab-pane active' : 'tab-pane' ?>">
                        <div class="tabcontent">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>TABELL ÖVER KUNDER/KONTON</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2">
                                    <span class='info'>Använd % som wildcard när du söker.</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st registrerade kunder/konton</span>"; ?>
                                    <form action="?tab=<?=$tab?>" method="POST">
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
                                    <form action="?tab=<?=$tab?>" method="POST">
                                        <label for="searchfile">SÖK</label>
                                        <input type="text" name="searchcustomerfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                                        <input type="submit" name="searchcustomerbtn" value="Sök">
                                        <input type="submit" name="searchbtnallcustomer" value="Återställ tabell">
                                        <br />
                                        <label>|&nbsp;<input type="radio" name="searchcustomerradio" value="id" <?= ($searchradio == 'id') ? 'checked' : '' ?>>&nbsp;Id | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="role" <?= ($searchradio == 'role') ? 'checked' : '' ?>>&nbsp;Roll | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="username" <?=($searchradio == 'username') ? 'checked' : '' ?>>&nbsp;Användarnamn | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="forname"<?= ($searchradio == 'forname') ? 'checked' : '' ?>>&nbsp;Förnamn | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="surname"<?= ($searchradio == 'surname') ? 'checked' : '' ?>>&nbsp;Efternamn | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="email"<?= ($searchradio == 'email') ? 'checked' : '' ?>>&nbsp;Email | </label>
                                        <label><input type="radio" name="searchcustomerradio" value="created"<?= ($searchradio == 'created') ? 'checked' : '' ?>>&nbsp;Datum | </label>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <?php $createurl = $app->url->create('admincreateuser'); ?>
                                    <br />
                                    <a class="createuserlink" href=<?= $createurl ?>>Lägg till kund/konto</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $dbtablecustomer ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /KUNDTAB -->

                <!--
                    TAB FÖR ORDER
                -->
                <!-- <div role="tabpanel" class="<?= ($tab == 'orders') ? 'tab-pane active' : 'tab-pane' ?>"> -->
                    <!-- ORDERTABBEN -->
                <div role="tabpanel" class="<?= ($tab == 'orders') ? 'tab-pane active' : 'tab-pane' ?>">
                    <div class="tabcontent">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>ORDERTABELL</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <span class='info'>Använd % som wildcard när du söker.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st orders</span>"; ?>
                                <form action="?tab=<?=$tab?>" method="POST">
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
                            <div class="col-md-10">
                                <form action="?tab=<?=$tab?>" method="POST">
                                    <label for="searchfile">SÖK</label>
                                    <input type="text" name="searchordersfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                                    <input type="submit" name="searchordersbtn" value="Sök">
                                    <input type="submit" name="searchbtnallorders" value="Återställ tabell">
                                    <br />
                                    <label>|&nbsp;<input type="radio" name="searchordersradio" value="orderid" <?= ($searchradio == 'orderid') ? 'checked' : '' ?>>&nbsp;Ordernummer | </label>
                                    <label><input type="radio" name="searchordersradio" value="orderstatus" <?= ($searchradio == 'orderstatus') ? 'checked' : '' ?>>&nbsp;Orderstatus | </label>
                                    <label><input type="radio" name="searchordersradio" value="product" <?= ($searchradio == 'product') ? 'checked' : '' ?>>&nbsp;Beställning| </label>
                                    <label><input type="radio" name="searchordersradio" value="customerid" <?=($searchradio == 'customerid') ? 'checked' : '' ?>>&nbsp;Kundid | </label>
                                    <label><input type="radio" name="searchordersradio" value="firstname"<?= ($searchradio == 'firstname') ? 'checked' : '' ?>>&nbsp;Förnamn | </label>
                                    <label><input type="radio" name="searchordersradio" value="surname"<?= ($searchradio == 'surname') ? 'checked' : '' ?>>&nbsp;Efternamn | </label>
                                    <label><input type="radio" name="searchordersradio" value="email"<?= ($searchradio == 'email') ? 'checked' : '' ?>>&nbsp;Email | </label>
                                    <label><input type="radio" name="searchordersradio" value="created"<?= ($searchradio == 'created') ? 'checked' : '' ?>>&nbsp;Skapad | </label>
                                    <label><input type="radio" name="searchordersradio" value="updated"<?= ($searchradio == 'updated') ? 'checked' : '' ?>>&nbsp;Uppdaterad | </label>
                                    <label><input type="radio" name="searchordersradio" value="delivered"<?= ($searchradio == 'delivered') ? 'checked' : '' ?>>&nbsp;Levererad | </label>
                                </form>
                            </div>
                            <!-- <div class="col-md-2">
                                <?php $createurl = $app->url->create('admincreateuser'); ?>
                                <br />
                                <a class="createuserlink" href=<?= $createurl ?>>Lägg till kund/konto</a>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $dbtableorders ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!-- /ORDERTAB -->

                <!-- FAKTURATABBEN -->
                <div role="tabpanel" class="<?= ($tab == 'invoices') ? 'tab-pane active' : 'tab-pane' ?>">
                    <div class="tabcontent">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>TABELL ÖVER FAKTUROR</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <span class='info'>Använd % som wildcard när du söker.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?= "<span>".$thisnumberaccounts." av ".$totalnumberaccounts." st fakturor</span>"; ?>
                                <form action="?tab=<?=$tab?>" method="POST">
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
                            <div class="col-md-10">
                                <form action="?tab=<?=$tab?>" method="POST">
                                    <label for="searchfile">SÖK</label>
                                    <input type="text" name="searchinvoicesfield" value="<?= ($searchfield == '%%') ? '' : $searchfield ?>" placeholder="Sök...">
                                    <input type="submit" name="searchinvoicesbtn" value="Sök">
                                    <input type="submit" name="searchbtnallinvoices" value="Återställ tabell">
                                    <br />
                                    <label>|&nbsp;<input type="radio" name="searchinvoicesradio" value="invoiceid" <?= ($searchradio == 'invoiceid') ? 'checked' : '' ?>>&nbsp;Fakturanummer | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="invoicestatus" <?= ($searchradio == 'invoicestatus') ? 'checked' : '' ?>>&nbsp;Fakturastatus | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="product" <?= ($searchradio == 'product') ? 'checked' : '' ?>>&nbsp;Beställning| </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="customerid" <?=($searchradio == 'customerid') ? 'checked' : '' ?>>&nbsp;Kundid | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="firstname"<?= ($searchradio == 'firstname') ? 'checked' : '' ?>>&nbsp;Förnamn | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="surname"<?= ($searchradio == 'surname') ? 'checked' : '' ?>>&nbsp;Efternamn | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="email"<?= ($searchradio == 'email') ? 'checked' : '' ?>>&nbsp;Email | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="created"<?= ($searchradio == 'created') ? 'checked' : '' ?>>&nbsp;Skapad | </label>
                                    <label><input type="radio" name="searchinvoicesradio" value="payed"<?= ($searchradio == 'payed') ? 'checked' : '' ?>>&nbsp;Betald | </label>
                                </form>
                            </div>
                            <!-- <div class="col-md-2">
                                <?php $createurl = $app->url->create('admincreateuser'); ?>
                                <br />
                                <a class="createuserlink" href=<?= $createurl ?>>Lägg till kund/konto</a>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $dbtableinvoices ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /FAKTURATABBEN -->

            </div>
            <!-- /TAB-CONTENT -->
        </div>
        <!-- /COLUMN -->
    </div>
    <!-- /ROW -->

</div>
