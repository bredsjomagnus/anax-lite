<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$shelfsectionselect = "";
$storagesection = "";
$addproducttostorage = "";
$step = isset($_GET['step']) ? htmlentities($_GET['step']) : 'nostep';
if ($step == 1) {
    $addproducttostorage = "<form action='#' method='GET'>
                                <div class='form-group'>
                                    <label for='storagesectionselect'>Välj lagersektion</label>
                                    <select class='form-control' name='storagesectionselect'>
                                        <option value='A'>A</option>
                                        <option value='B'>B</option>
                                    </select>
                                </div>
                                <input type='hidden' name='step' value='2'>
                                <input type='submit' name='storageselectbtn' value='Välj'>
                            </form>";
} else if ($step == 2) {
    $storagesection = $_GET['storagesectionselect'];
    $app->session->set('storagesection', $storagesection);
    if ($storagesection == 'A') {
        $shelfsectionselect = "<select class='form-control' name='shelfselect'>
                                    <option value='A1'>A1</option>
                                    <option value='A2'>A2</option>
                                    <option value='A3'>A3</option>
                                </select>";
    } else if ($storagesection == 'B') {
        $shelfsectionselect = "<select class='form-control' name='shelfselect'>
                                    <option value='B1'>B1</option>
                                    <option value='B2'>B2</option>
                                    <option value='B3'>B3</option>
                                </select>";
    }
    $addproducttostorage = "<p> Lagersektion " . $storagesection;
    $addproducttostorage .= "<form action='#' method='GET'>
                                <div class='form-group'>
                                    <label for='storageselect'>Välj hyllsektion</label>
                                    $shelfsectionselect
                                </div>
                                <input type='hidden' name='step' value='3'>
                                <input type='submit' name='shelfsectionselectbtn' value='Välj'>
                            </form>";
    $addproducttostorage .= "<a href='". $_SERVER['HTTP_REFERER']."'><-- ett steg bakåt</a>";
} else if ($step == 3) {
    $storagesection = $app->session->get('storagesection', '');
    $shelfsection = htmlentities($_GET['shelfselect']);
    $app->session->set('shelfsection', $shelfsection);
    $addproducttostorage = "Lagersektion " . $storagesection ." -> " . $shelfsection;
    $app->database->connect();
    $sql = "SELECT shelfrowid, articleid FROM InventoryIsolatedView WHERE shelfsection = ?";
    $param = [$shelfsection];
    $occupiedshelfrows = "";
    $occupiedshelfrowsarray = [];
    $res = $app->database->executeFetchAll($sql, $param);
    foreach ($res as $row) {
        $occupiedshelfrows .= "<br />".$row->shelfrowid."";
        $occupiedshelfrowsarray[] = $row->shelfrowid;
    }

    $addproducttostorage .= "<p>Upptagna hyllrader på lagersektion " . $storagesection ." -> " . $shelfsection .": " . $occupiedshelfrows ."</p>";
    $addproducttostorage .= "<form action='#' method='GET'>
                                    <p>Hyllradsid måste bestå av Hyllsektion följt av tre siffror. Framförvarande nollor fylls i automatiskt.</p>
                                    <label for='shelfrowselect'>$shelfsection-
                                    <input type='number' name='shelfrowselect' value='' >
                                    </label>
                                <input type='hidden' name='step' value='4'>
                                <input type='submit' name='shelfrowselectbtn' value='Välj'>
                            </form>";
    $addproducttostorage .= "<a href='". $_SERVER['HTTP_REFERER']."'><-- ett steg bakåt</a>";
} else if ($step == 4) {
    $shelfrownumber = htmlentities($_GET['shelfrowselect']);
    $shelfrownumberprefix = "";
    if (strlen($shelfrownumber) < 3) {
        while ((strlen($shelfrownumberprefix) + strlen($shelfrownumber)) < 3) {
            $shelfrownumberprefix .= "0". $shelfrownumberprefix;
        }

        $shelfrownumber = $shelfrownumberprefix . $shelfrownumber;
        $shelfrowid = substr($shelfrownumber, -3);
        $storagesection = $app->session->get('storagesection', '');
        $shelfsection = $app->session->get('shelfsection', '');
        $shelfrowid = $shelfsection . "-" . $shelfrowid;
        $shelfsectionid = "shelfsection_".$shelfsection;
        $app->database->connect();
        $sql = "SELECT * FROM InventoryIsolatedView WHERE shelfrowid = ?";
        $param = [$shelfrowid];
        if ($app->database->executeFetchAll($sql, $param)) {
            $addproducttostorage = "<br><p>Hyllrad: " . $storagesection. "->" . $shelfrowid ." är inte ledig.<br>Vänligen gå tillbaka och välj ny hyllrad.</p>";
            // $addproducttostorage .= "<a href='". $_SERVER['HTTP_REFERER']."'><-- ett steg bakåt</a>";
        } else {
            $app->database->connect();
            $sql = "SELECT articleid FROM Product";
            $productselect =    "<select name='productselect'>";
            foreach ($res = $app->database->executeFetchAll($sql) as $row) {
                $productselect .= "<option value='$row->articleid'>$row->articleid</option>";
            }
            $productselect .= "</select>";
            $addproducttostorage = "<p>Hyllrad: " . $storagesection. "->" . $shelfrowid ." är ledig.</p>";
            $addproducttostorage .= "<form action='#' method='GET'>
                                            <label for='shelfsectionid'>ShelfSection.id:
                                            <input type='text' name='shelfsectionid' value='$shelfsectionid'>
                                            </label>
                                            <label for='shelfrowid'>ShelfRow.id:
                                            <input type='text' name='shelfrowid' value='$shelfrowid'>
                                            </label>
                                            <label for='productselect'>Product.articleid:
                                            $productselect
                                            </label>
                                            <label for='shelfrowid'>Product.items:
                                            <input type='number' name='items' value=''>
                                            </label>
                                            <br>
                                        <input type='hidden' name='step' value='5'>
                                        <input type='submit' name='newshelfrowbtn' value='Lägg in produkt på hyllrad'>
                                    </form>";
        }
    } else if (strlen($shelfrownumber) > 3) {
        $addproducttostorage = "<br><p>Hyllradparameter för lång. Får ange max tre siffror långt.<br>Vänligen gå tillbaka och fyll i ny hyllrad.</p>";
        // $addproducttostorage .= "<a href='". $_SERVER['HTTP_REFERER']."'><-- ett steg bakåt</a>";
    }
    $addproducttostorage .= "<a href='". $_SERVER['HTTP_REFERER']."'><-- ett steg bakåt</a>";
} else if ($step == 5) {
    $shelfsectionid = isset($_GET['shelfsectionid']) ? htmlentities($_GET['shelfsectionid']) : null;
    $shelfrowid = isset($_GET['shelfrowid']) ? htmlentities($_GET['shelfrowid']) : null;
    $product = isset($_GET['productselect']) ? htmlentities($_GET['productselect']) : null;
    $items = isset($_GET['items']) ? htmlentities($_GET['items']) : null;

    // echo $shelfsectionid . " " . $shelfrowid . " " . $product . " " . $items;
    if ($shelfsectionid != null && $shelfrowid != null && $product != null && $items != null) {
        $app->database->connect();
        $sql = "CALL addToStorage(?, ?, ?, ?)";
        $param = [$shelfsectionid, $shelfrowid, $product, $items];
        $paramType = [$shelfsectionid => 'str', $shelfrowid => 'str', $product => 'str', $items => 'int'];
        $app->database->executeProcedure($sql, $param, $paramType);

        $app->session->delete('storagesection');
        $app->session->delete('shelfsection');
        header("Location: adminpagewebbshop?tab=isolated");
    } else {
        header("Location: adminpagewebbshop?tab=isolated");
    }
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpagewebbshop?tab=isolated") ?>>Tillbaka till lagertabell</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">

            <?= $addproducttostorage ?>

            </div>
        </div>
    </div>
</div>
