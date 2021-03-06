<?php
namespace Maaa16\Webshopcontent;

class Webshopcontent
{
    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    public function makeArticleidUnique($app, $articlelength, $articleid)
    {
        $counter = 2;

        $app->database->connect();
        $sql = "SELECT articleid FROM Product WHERE articleid = ?";
        while ($app->database->executeFetchAll($sql, [$articleid])) {
            if (strlen($articleid) == $articlelength) {
                $articleid = $articleid ."-".$counter;
            } else {
                $articleid = substr($articleid, 0, $articlelength);
                $articleid = $articleid ."-".$counter;
            }
            $counter += 1;
        }

        return $articleid;
    }

    public function getCategoryChecksHTML($app)
    {
        $app->database->connect();
        $sql = "SELECT cat_id FROM ProdCategory";
        $res = $app->database->executeFetchAll($sql);

        $categoryChecks = "<div class='form-group'>
                                <p>Välj minst en kategori för produkten.</p>
                                <p><b>Kategorier:</b>&nbsp;</p>";
        foreach ($res as $row) {
            // $categoryChecks .= "<label for='".$row->cat_id."'>".$row->cat_id.":&nbsp;</label>";
            // $categoryChecks .= "<input type='checkbox' name='".$row->cat_id."' value='".$row->cat_id."' /> | ";
            $categoryChecks .= "<label for='catChecks[]'>".$row->cat_id.":&nbsp;</label>";
            $categoryChecks .= "<input type='checkbox' name='catChecks[]' value='".$row->cat_id."' /> | ";
        }
        $categoryChecks .= "</div>";

        return $categoryChecks;
    }
    public function generateDBTableWebshop($app, $way, $tableproporties)
    {
        $paginatorarray = $this->paginator($app, $tableproporties, $way);
        if ($way == 'produkter') {
            $table = $this->toHtmlSearchProducts($paginatorarray);
        } else if ($way == 'concatedall') {
            $table = $this->toHtmlSearchStorageConcatedAll($paginatorarray);
        } else if ($way == 'isolated') {
            $table = $this->toHtmlSearchStorageIsolated($paginatorarray);
        } else if ($way == 'customers') {
            $table = $this->toHtmlSearchUsers($paginatorarray, $app);
        } else if ($way == 'orders') {
            $table = $this->toHtmlSearchOrders($paginatorarray);
        } else if ($way == 'invoices') {
            $table = $this->toHtmlSearchInvoices($paginatorarray);
        }

        return $table;
    }

    private function paginator($app, $tableproporties, $way)
    {
        $dbtable = $tableproporties['databasetable'];
        // $tableproporties = [antal rader per sida, kolumnnamn som skall sorteras efter, asc eller desc beroende på ordning, kolumn att söka på, söksträng]
        /*
        * Connectar till databasen och räknar antalet Objekt utefter vad man sökt efter
        * $numobjects = antalet objekt i databasen
        */
        $app->database->connect();
        $search = "WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."' ";
        // $search = "WHERE ". $tableproporties['searchcolumn'] ." LIKE ? ";
        $sql = "SELECT * FROM ".$tableproporties['databasetable']." WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."'";
        // $sql = "SELECT * FROM $dbtable $search";
        // $params = [$tableproporties['searchfield']];
        $params = [];
        $preres = $app->database->executeFetchAll($sql, $params);
        // $preres = $app->database->execute($sql, $params);
        $numobjects = count($preres);

        /*
        * Sätter begränsningen på antalet objekt per sida med $tableproporties[0]
        * Sätter vilken som är sista sidan med $lastpage
        */
        $lastpage = ceil($numobjects/$tableproporties['pages']);
        if ($lastpage < 1) {
            $lastpage = 1;
        }

        /*
        * Sätter starten på pagenatorn till 1.
        * Kontrollerar sedan om det finns någon information att hämta i adressraden.
        * med preg_replace ser man till att $_GET['pn'] bara kan vara siffror.
        * Ser sedan till att $pagenum inte kan vara mindre än 1 eller mer än $lastpage
        */
        $pagenum = (isset($_GET['pn'])) ? preg_replace('#[^0-9]#', '', $_GET['pn']) : 1;
        if ($pagenum < 1) {
            $pagenum = 1;
        } else if ($pagenum > $lastpage) {
            $pagenum = $lastpage;
        }

        /*
        * Söker efter objekten i databasen med begränsning $limit
        */
        // $app->database->connect();

        // $search = "WHERE ". $tableproporties[3] ." LIKE '%".$tableproporties[4]."%' ";

        // $sql = "UPDATE chromebookusers SET roll = ?, klass= ?, fornamn = ?, efternamn = ?, konto = ?, dator= ? WHERE id = ?";
        // $search = "WHERE ". $tableproporties['searchcolumn'] ." LIKE '".$tableproporties['searchfield']."' ";
        $search = "WHERE ". $tableproporties['searchcolumn'] ." LIKE ? ";

        $limit = 'LIMIT ' .($pagenum - 1 ) * $tableproporties['pages'] . ', ' . $tableproporties['pages'];
        $order = 'ORDER BY ' . $tableproporties['orderby'] ." ". $tableproporties['orderas']. " ";
        // $search = "WHERE ". $tableproporties[3] ." LIKE '%".$tableproporties[4]."%' ";
        $sql = "SELECT * FROM $dbtable $search $order $limit";
        // $params = [];
        $params = [$tableproporties['searchfield']];
        // $res = $app->database->executeFetchAll($sql, $params);
        $res = $app->database->execute($sql, $params);

        $textline1 = "Object (".$numobjects.")";
        $textline2 = "Sida ".$pagenum." av ".$lastpage;

        $pagenationrow = "<ul class='pagination'>";
        if ($lastpage != 1) {
            $pagenationrow = $this->leftside($pagenum, $pagenationrow, $way);

            $pagenationrow .= "<li><a class='paginatoractive'>".$pagenum."</a></li>";

            $pagenationrow = $this->rightside($pagenum, $lastpage, $pagenationrow, $way);
        }
        $pagenationrow .= "</ul>";
        $pagenatorarray = array('res' => $res, 'max' =>  $textline1, 'current' => $textline2, 'ctrl' => $pagenationrow);
        // $table = $this->toHtmlSearch($pagenatorarray, $app);
        // return $table;
        return $pagenatorarray;
    }

    private function leftside($pagenum, $pagenationrow, $way)
    {
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $url = $_SERVER['PHP_SELF'].'?pn='.$previous;
            $pagenationrow .= "<li><a href='$url&tab=$way'>" .htmlspecialchars("<<"). "</a></li>";

            if ($pagenum-4 > 0) {
                $pagenationrow .= '<li><a>...</a></li>';
            }
            for ($i = $pagenum-3; $i < $pagenum; $i += 1) {
                if ($i > 0) {
                    $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                    $pagenationrow .= "<li><a href='$url&tab=$way'>".$i."</a></li>";
                }
            }
        }
        return $pagenationrow;
    }

    private function rightside($pagenum, $lastpage, $pagenationrow, $way)
    {
        for ($i = $pagenum+1; $i <= $lastpage; $i += 1) {
            if ($i < $pagenum+4) {
                $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                $pagenationrow .= "<li><a href='$url&tab=$way'>".$i."</a></li>";
            } else if ($i == $pagenum+4) {
                $pagenationrow .= '<li><a>...</a></li>';
            } else if ($i >= $pagenum+4) {
                break;
            }
        }


        if ($pagenum != $lastpage) {
            // var_dump($pagenum);
            $next = $pagenum + 1;
            $url = $_SERVER['PHP_SELF'].'?pn='.$next;
            $pagenationrow .= "<li><a href='$url&tab=$way'>" .htmlspecialchars('>>'). "</a></li>";
        }

        return $pagenationrow;
    }

    /**
     * Function to create links for sorting.
     *
     * @param string $column the name of the database column to sort by
     * @param string $route  prepend this to the anchor href
     *
     * @return string with links to order by column.
     */
    private function orderby($column, $tab)
    {
        $orderby =  "<span class='orderby'>
                        <a href='?tab={$tab}&order={$column}&orderas=asc'><span class='glyphiconarrow glyphicon glyphicon-menu-down' aria-hidden='true'></span></a>
                        <a href='?tab={$tab}&order={$column}&orderas=desc'><span class='glyphiconarrow glyphicon glyphicon-menu-up' aria-hidden='true'></a>
                    </span>";
        return $orderby;
    }

    private function toHtmlSearchStorageConcatedAll($pagenatorarray)
    {
        $table =        "<table class='admintable producttable'>
                            <thead>
                                <tr>
                                    <th>Lagersektion ".$this->orderby('storagesection', 'concatedall')."</th>
                                    <th>Hyllsektion ".$this->orderby('shelfsection', 'concatedall')."</th>
                                    <th>Hyllplats ".$this->orderby('shelfrowid', 'concatedall')."</th>
                                    <th>Artikelid ".$this->orderby('articleid', 'concatedall')."</th>
                                    <th>Titel ".$this->orderby('title', 'concatedall')."</th>
                                    <th>Antal ".$this->orderby('items', 'concatedall')."</th>
                                </tr>
                            </thead>
                            <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            $table .=           "<tr>
                                    <td>".$row->storagesection."</td>
                                    <td>".$row->shelfsection."</td>
                                    <td>".$row->shelfrowid."</td>
                                    <td>".$row->articleid."</td>
                                    <td>".$row->title."</td>
                                    <td>".$row->items."</td>
                                </tr>";
        }
        $table .=           "</tbody>
                        </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }

    private function toHtmlSearchProducts($pagenatorarray)
    {
        $table = "";
        $table = "<table class='admintable producttable'>";
        $table .= "<thead>
                <tr>
                   <th>Id ".$this->orderby('articleid', 'produkter')."</th>
                   <th>Titel ".$this->orderby('title', 'produkter')."</th>
                   <th>Beskrivning</th>
                   <th>Kategori ".$this->orderby('category', 'produkter')."</th>
               </tr>
               <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            if ($row->image == 'noproductimage') {
                $imageurl = 'noproductimage128x128.png';
            } else {
                $imageurl = $row->image;
            }
            // $image = "<img alt='$row->title' src='img/$imageurl'>";

            $descriptionlimit = 50;
            if (strlen($row->description)<=$descriptionlimit) {
                $description = $row->description;
            } else {
                $description = substr($row->description, 0, $descriptionlimit) . '...';
            }


            $table .=   "<tr>
                            <td>".$row->articleid."</td>
                            <td>".$row->title."</td>
                            <td>".$description."</td>
                            <td>".$row->category."</td>
                        </tr>";
        }
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }

    private function toHtmlSearchStorageIsolated($pagenatorarray)
    {
        $table =        "<table class='admintable producttable'>
                            <thead>
                                <tr>
                                    <th>Lagersektion ".$this->orderby('storagesection', 'isolated')."</th>
                                    <th>Hyllsektion ".$this->orderby('shelfsection', 'isolated')."</th>
                                    <th>Hyllplats ".$this->orderby('shelfrowid', 'isolated')."</th>
                                    <th>Artikelid ".$this->orderby('articleid', 'isolated')."</th>
                                    <th>Titel ".$this->orderby('title', 'isolated')."</th>
                                    <th>Antal ".$this->orderby('items', 'isolated')."</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            $table .=           "<tr>
                                    <td>".$row->storagesection."</td>
                                    <td>".$row->shelfsection."</td>
                                    <td>".$row->shelfrowid."</td>
                                    <td>".$row->articleid."</td>
                                    <td>".$row->title."</td>
                                    <td>".$row->items."</td>
                                    <td><a href='adminwebbshopaddtoshelfrow?id=$row->shelfrowid'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></a></td>
                                </tr>";
        }
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";
        return $table;
    }

    private function toHtmlSearchUsers($pagenatorarray, $app)
    {
        /*
        * $pagenatorarray = max, current, ctrl
        */
        // $route = "?route=orderby&";

        $table = "";
        $table = "<table class='admintable producttable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Aktiv ".$this->orderby('active', 'customers')."</th>
                            <th>id ".$this->orderby('id', 'customers')."</th>
                            <th></th>
                            <th>Roll ".$this->orderby('role', 'customers')."</th>
                            <th>Användarnamn ".$this->orderby('username', 'customers')."</th>
                            <th>Förnamn ".$this->orderby('forname', 'customers')."</th>
                            <th>Efternamn ".$this->orderby('surname', 'customers')."</th>
                            <th>Email ".$this->orderby('email', 'customers')."</th>
                            <th>Datum ".$this->orderby('created', 'customers')."</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                    // <th></th>
                    // <th></th>
        foreach ($pagenatorarray['res'] as $row) {
            $app->database->connect();
            $sql = "SELECT * FROM OrderView WHERE customerid = ?";
            if ($ores = $app->database->executeFetchAll($sql, [$row->id])) {
                foreach ($ores as $orow) {
                    $orow;
                    $orderlink = "<td><a href='adminviewcustomerorders?customerid=$row->id' data-toggle='tooltip' data-placement='right' title='Se kundens ordrar'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></td>";
                }
            } else {
                $orderlink = "<td></td>";
            }


            if ($row->active == "yes") {
                // $active = "glyphicon glyphicon-ok";
                $active = "<span style='color: #8ca67e;' class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
            } else {
                $active = "<span style='color: #a67e7e;' class='glyphicon glyphicon-lock' aria-hidden='true'></span>";
            }


            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar($row->email, $default);
            $gravatar->size = 30;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";

            // $editurl = $app->url->create('edituser') ."?id=".$row->id;
            // $deleteurl = $app->url->create('deleteuser') ."?id=".$row->id;

            $table .=   "<tr>
                            <td>".$active."</td>
                            <td>".$row->id."</td>
                            <td>".$gravatar->toHTML()."</td>
                            <td>".$row->role."</td>
                            <td>".$row->username."</td>
                            <td>".$row->forname."</td>
                            <td>".$row->surname."</td>
                            <td>".$row->email."</td>
                            <td>".$row->created."</td>
                            $orderlink
                        </tr>";
        }
        // redigeringsceller. Lägg till om tid finnes.
        // <td><a href='$editurl'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>
        // <td><a href='$deleteurl'><span style='color: #a67e7e;' class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }

    private function toHtmlSearchInvoices($pagenatorarray)
    {
        /*
        * $pagenatorarray = max, current, ctrl
        */
        // $route = "?route=orderby&";

        $table = "";
        $table = "<table class='admintable ordertable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Nr ".$this->orderby('invoiceid', 'invoices')."</th>
                            <th>Status ".$this->orderby('invoicestatus', 'invoices')."</th>
                            <th>Beställning ".$this->orderby('product', 'invoices')."</th>
                            <th>Kund-id ".$this->orderby('customerid', 'invoices')."</th>
                            <th>Förnamn ".$this->orderby('firstname', 'invoices')."</th>
                            <th>Efternamn ".$this->orderby('surname', 'invoices')."</th>
                            <th>Email ".$this->orderby('email', 'invoices')."</th>
                            <th>Skapad ".$this->orderby('created', 'invoices')."</th>
                            <th>Betald ".$this->orderby('payed', 'invoices')."</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                    // <th></th>
                    // <th></th>
        foreach ($pagenatorarray['res'] as $row) {
            $table .=   "<tr>
                            <td>".$row->invoiceid."</td>
                            <td>".$row->invoicestatus."</td>
                            <td>".$row->product."</td>
                            <td>".$row->customerid."</td>
                            <td>".$row->firstname."</td>
                            <td>".$row->surname."</td>
                            <td>".$row->email."</td>
                            <td>".$row->created."</td>
                            <td>".$row->payed."</td>
                            <td><a href='?tab=invoices&payed=yes&paymentid=$row->invoiceid' data-toggle='tooltip' data-placement='right' title='Markera faktura som betald'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></a></td>
                            <td><a href='adminviewinvoice?invoiceid=$row->invoiceid' data-toggle='tooltip' data-placement='right' title='Se order'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></td>
                        </tr>";
        }
        // redigeringsceller. Lägg till om tid finnes.
        // <td><a href='$editurl'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>
        // <td><a href='$deleteurl'><span style='color: #a67e7e;' class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }

    private function toHtmlSearchOrders($pagenatorarray)
    {
        /*
        * $pagenatorarray = max, current, ctrl
        */
        // $route = "?route=orderby&";

        $table = "";
        $table = "<table class='admintable ordertable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Nr ".$this->orderby('orderid', 'orders')."</th>
                            <th>Status ".$this->orderby('orderstatus', 'orders')."</th>
                            <th>Beställning ".$this->orderby('product', 'orders')."</th>
                            <th>Kund-id ".$this->orderby('customerid', 'orders')."</th>
                            <th>Förnamn ".$this->orderby('firstname', 'orders')."</th>
                            <th>Efternamn ".$this->orderby('surname', 'orders')."</th>
                            <th>Email ".$this->orderby('email', 'orders')."</th>
                            <th>Skapad ".$this->orderby('created', 'orders')."</th>
                            <th>Uppdaterad ".$this->orderby('updated', 'orders')."</th>
                            <th>Levererad ".$this->orderby('delivered', 'orders')."</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                    // <th></th>
                    // <th></th>
        foreach ($pagenatorarray['res'] as $row) {
            $table .=   "<tr>
                            <td>".$row->orderid."</td>
                            <td>".$row->orderstatus."</td>
                            <td>".$row->product."</td>
                            <td>".$row->customerid."</td>
                            <td>".$row->firstname."</td>
                            <td>".$row->surname."</td>
                            <td>".$row->email."</td>
                            <td>".$row->created."</td>
                            <td>".$row->updated."</td>
                            <td>".$row->delivered."</td>
                            <td><a href='?tab=orders&deliver=yes&deliverid=$row->orderid' data-toggle='tooltip' data-placement='right' title='Leverera order'><span class='glyphicon glyphicon-share' aria-hidden='true'></span></a></td>
                            <td><a href='adminvieworder?orderid=$row->orderid' data-toggle='tooltip' data-placement='right' title='Se order'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></td>
                        </tr>";
        }
        // redigeringsceller. Lägg till om tid finnes.
        // <td><a href='$editurl'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>
        // <td><a href='$deleteurl'><span style='color: #a67e7e;' class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }
}
