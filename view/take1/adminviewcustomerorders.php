<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}

$customerid = (isset($_GET['customerid'])) ? htmlentities($_GET['customerid']) : null;
if ($customerid != null) {
    if (!is_numeric($customerid)) {
        die("Not valid for customer id.");
    }
    $app->database->connect();
    $sql = "SELECT forname, surname FROM Customer WHERE id = ?";
    $res = $app->database->execute($sql, [$customerid]);
    foreach ($res as $row) {
        $firstname = $row->forname;
        $surname = $row->surname;
    }
    $sql = "SELECT * FROM OrderView WHERE customerid = ?";
    $res2 = $app->database->executeFetchAll($sql, [$customerid]);
    $orderlist =   "<table class='admintable'>
                        <thead>
                            <tr>
                                <td>ORDERID</td>
                                <td>SKAPAD</td>
                                <td>LEVERERAD</td>
                                <td>LÄS ORDER</td>
                            </tr>
                        </thead>
                        <tbody>";
    foreach ($res2 as $row2) {
        $orderlist .=   "<tr>
                            <td>".$row2->orderid."</td>
                            <td>".$row2->created."</td>
                            <td>".$row2->delivered."</td>
                            <td><a href='adminvieworder?orderid=$row2->orderid' data-toggle='tooltip' data-placement='right' title='Se order'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></td>
                        </tr>";
    }
    $orderlist .=   "<tbody>
                    </table>";
}


?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <span><a href=<?= $app->url->create("adminpagewebbshop?tab=customers") ?>>Tillbaka</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>ÖVERBLICK - ORDRAR</h4>
            <h5><?= $firstname ." ".$surname ?></h5>

        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <?= $orderlist ?>
        </div>
    </div>
</div>
