<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$webcontent = new \Maaa16\Webshopcontent\Webshopcontent();
$categoryChecksHTML = $webcontent->getCategoryChecksHTML($app);
$errormsg = "";
// $articleid = "";
// $title = "";

$params = [];
$paramTypes = [];

if (isset($_POST['createbtn'])) {
    $title = htmlentities($_POST['productTitle']);
    $price = htmlentities($_POST['productPrice']);
    $description = htmlentities($_POST['productDescription']);
    // $imagepath = (isset($_POST['productImage']) || $_POST['productImage'] != "noproductimage") ? htmlentities($_POST{'productImage'}) : 'noproductimage';
    $imagepath = 'noproductimage';

    $idprefix = $webcontent->slugify($title);
    $articleid = "art-".$idprefix;
    $articleidlength = strlen($articleid);
    $articleid = $webcontent->makeArticleidUnique($app, $articleidlength, $articleid);

    if (isset($_POST['catChecks'])) {
        // Alla valda kategorier i en array
        $categories = $_POST['catChecks'];
        foreach ($categories as $cat) {
            $sql = "CALL insertProduct(?, ?, ?, ?, ?, ?)";
            $param = [$articleid, $title, $description, $imagepath, $price, $cat];
            $paramType = [$articleid => 'str', $title => 'str', $description => 'str', $imagepath => 'str', $price => 'str', $cat => 'str'];
            $app->database->executeProcedure($sql, $param, $paramType);
        }
        header('Location: adminpagewebbshop?tab=produkter');
    } else {
        $errormsg = "Måste välja minst en kategori";
    }
    // CALL insertProduct('art-schack', 'Schack', 'Det klassiska schacket som funnits med sedan tusentals år tillbaka.', 'noimage', 'Brädspel');


    // $adminediturl = $app->url->create('admineditproduct');
    // header("Location: ".$adminediturl."?articleid=$id&?title=$title");
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <span><a href=<?= $app->url->create("adminpagewebbshop") ?>>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="productTitle">Titel</label>
                    <input class='form-control' type="text" name="productTitle" value="">
                </div>
                <!-- <div class="form-group">
                    <label for="productImage">Bild</label>
                    <input class='form-control' type="text" name="productImage" value="noproductimage">
                </div> -->
                <div class="form-group">
                    <label for="productPrice">Pris</label>
                    <input class='form-control' type="number" type="number" step="0.01" name="productPrice" value="">
                </div>
                <div class="form-group">
                    <label for="productDescription">Beskrivning</label>
                    <textarea class='form-control' name="productDescription" value=""></textarea>
                </div>
                <?= $categoryChecksHTML ?>
                <input type="submit" name="createbtn" value="Skapa">
            </form>
            <?= $errormsg; ?>
        </div>
    </div>
</div>
