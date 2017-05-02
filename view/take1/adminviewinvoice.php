<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    header("Location: login");
}
$iid = htmlentities($_GET['invoiceid']);
$app->database->connect();
$sql = "SELECT * FROM InvoiceView WHERE invoiceid = ?";
$res = $app->database->execute($sql, [$iid]);
foreach ($res as $row) {
    $invoiceid = $row->invoiceid;
    $productid = $row->product;
    $producttitle = $row->producttitle;
    $productprice = $row->productprice;
    $productitems = $row->items;
    $customerid = $row->customerid;
    $firstname = $row->firstname;
    $surname = $row->surname;
    $email = $row->email;
    $created = $row->created;
    $payed = $row->payed;
    $status = $row->invoicestatus;
}
$productidarray = explode(', ', $productid);
$producttitlearray = explode(', ', $producttitle);
$productitemsarray = explode(', ', $productitems);
$productpricearray = explode(', ', $productprice);
$productHTML = "";
$costsum = 0;
for ($i = 0; $i < count($productidarray); $i += 1) {
    $cost = (intval($productitemsarray[$i]) * intval($productpricearray[$i]));
    $costsum = $costsum + $cost;
    $productHTML .=     "<tr>
                            <td class='orderviewmargincell'></td>
                            <td>" .$productidarray[$i] ."</td>
                            <td>" .$producttitlearray[$i] ."</td>
                            <td>" .$productitemsarray[$i] ."</td>
                            <td>" .$productitemsarray[$i]. " x " .$productpricearray[$i]. "</td>
                            <td>" .$cost ." kr</td>
                            <td></td>
                        </tr>";
}
$productHTML .=     "<tr class='orderviewhrtrlight'>

                    </tr>";
$productHTML .=     "<tr>
                        <td class='orderviewmargincell'></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>" .$costsum ." kr</b></td>
                        <td></td>
                    </tr>";
?>
<div class="page">
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <span><a href=<?= $app->url->create("adminpagewebbshop?tab=invoices") ?>>Tillbaka</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <h4>FAKTURANR <?= $invoiceid ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <table class='orderviewtable'>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'></td>
                    <td class='orderviewinfo'></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'></td>
                    <td class='orderviewinfo'></td>
                    <td class='orderviewmargincell'></td>
                </tr>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'>FAKTURANUMMER:</td>
                    <td class='orderviewinfo'><?= $invoiceid ?></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'>KUNDNUMMER:</td>
                    <td class='orderviewinfo'><?= $customerid ?></td>
                    <td class='orderviewmargincell'></td>
                </tr>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'>STATUS:</td>
                    <td class='orderviewinfo'><?= $status ?></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'>FÖRNAMN:</td>
                    <td class='orderviewinfo'><?= $firstname ?></td>
                    <td class='orderviewmargincell'></td>
                </tr>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'>SKAPAD:</td>
                    <td class='orderviewinfo'><?= $created ?></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'>EFTERNAMN:</td>
                    <td class='orderviewinfo'><?= $surname ?></td>
                    <td class='orderviewmargincell'></td>
                </tr>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'>BETALD:</td>
                    <td class='orderviewinfo'><?= ($status == 'payed') ? $payed : '- ej betald' ?></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'>EMAIL:</td>
                    <td class='orderviewinfo'><?= $email ?></td>
                    <td class='orderviewmargincell'></td>
                </tr>
                <tr class='orderviewhrtr'>

                </tr>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <th>Artikelid</th>
                    <th>Produkt</th>
                    <th>Antal</th>
                    <th></th>
                    <th>Kostnad</th>
                    <td class='orderviewmargincell'></td>
                </tr>
                <?= $productHTML ?>
                <tr>
                    <td class='orderviewmargincell'></td>
                    <td class='orderviewinfo rightalign'></td>
                    <td class='orderviewinfo'></td>
                    <td class='orderviewspace'></td>
                    <td class='orderviewinfo rightalign'></td>
                    <td class='orderviewinfo'></td>
                    <td class='orderviewmargincell'></td>
                </tr>

            </table>
        </div>

    </div>

</div>
