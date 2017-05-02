<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$id = (isset($_GET['id'])) ? htmlentities($_GET['id']) : null;

if ($id != null) {
    $app->database->connect();

    $sql = "SELECT items, product FROM ShelfRow WHERE id = '$id'";
    if ($res = $app->database->executeFetchAll($sql)) {
        $items = $res[0]->items;
        $product = $res[0]->product;
    } else {
        header('Location: adminpagewebbshop?tab=isolated');
    }
} else {
    header('Location: adminpagewebbshop?tab=isolated');
}

if (isset($_POST['itemssetbtn'])) {
    $newnumberofitems = ($_POST['items'] > 0) ? $_POST['items'] : 1;
    $app->database->connect();
    $sql = "UPDATE ShelfRow SET items = ? WHERE id = ?";
    $app->database->execute($sql, [$newnumberofitems, $id]);
    header('Location: adminpagewebbshop?tab=isolated');
} else if (isset($_POST['itemsdeletebtn'])) {
    $app->database->connect();
    $sql = "DELETE FROM ShelfRow WHERE id = ?";
    $app->database->execute($sql, [$id]);
    header('Location: adminpagewebbshop?tab=isolated');
}
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <a href=<?= $app->url->create("adminpagewebbshop?tab=isolated") ?>>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-4">
            <form action="#" method="POST">
                <div class="form-group">
                    <p class='text-muted-admin'>Lägsta antalet är 1. För att ta bort helt tryck 'Ta bort'</p>
                    <label for="items">Antal exemplar av <?= $product ?> på hyllrad <?= $id ?></label><br>
                    <input type="number" name="items" value="<?= $items ?>">
                </div>
                <input type="submit" name="itemssetbtn" value="Sätt antal">
                <input type="submit" name="itemsdeletebtn" value="Ta bort">
            </form>
        </div>
    </div>
</div>
