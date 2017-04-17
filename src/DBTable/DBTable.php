<?php
namespace Maaa16\DBTable;

class DBTable
{

    public function generateDBTable($app, $tableproporties = [5, 'username', 'desc', 'username', ''])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlSearch($paginatorarray, $app);
        return $table;
    }
    public function generateDBTableEdit($app, $tableproporties = [5, 'username', 'desc', 'username', ''])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlEdit($paginatorarray);
        return $table;
    }

    public function generateDBTableEditPassword($app, $tableproporties = [5, 'username', 'desc', 'username', ''])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlEditPassword($paginatorarray);
        return $table;
    }

    private function paginator($app, $tableproporties)
    {

        // $tableproporties = [antal rader per sida, kolumnnamn som skall sorteras efter, asc eller desc beroende på ordning, kolumn att söka på, söksträng]
        /*
        * Connectar till databasen och räknar antalet Objekt utefter vad man sökt efter
        * $numobjects = antalet objekt i databasen
        */
        $app->database->connect();
        $search = "WHERE ". $tableproporties[3] ." LIKE '".$tableproporties[4]."' ";

        $sql = "SELECT * FROM accounts $search";
        $params = [];
        $preres = $app->database->executeFetchAll($sql, $params);
        $numobjects = count($preres);

        /*
        * Sätter begränsningen på antalet objekt per sida med $tableproporties[0]
        * Sätter vilken som är sista sidan med $lastpage
        */
        $lastpage = ceil($numobjects/$tableproporties[0]);
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


        $search = "WHERE ". $tableproporties[3] ." LIKE '".$tableproporties[4]."' ";

        $limit = 'LIMIT ' .($pagenum - 1 ) * $tableproporties[0] . ', ' . $tableproporties[0];
        $order = 'ORDER BY ' . $tableproporties[1] ." ". $tableproporties[2]. " ";
        // $search = "WHERE ". $tableproporties[3] ." LIKE '%".$tableproporties[4]."%' ";
        $sql = "SELECT * FROM accounts $search $order $limit";
        $params = [];
        $res = $app->database->executeFetchAll($sql, $params);

        $textline1 = "Object (".$numobjects.")";
        $textline2 = "Sida ".$pagenum." av ".$lastpage;

        $pagenationrow = "<ul class='pagination'>";
        if ($lastpage != 1) {
            $pagenationrow = $this->leftside($pagenum, $pagenationrow);

            $pagenationrow .= "<li><a class='paginatoractive'>".$pagenum."</a></li>";

            $pagenationrow = $this->rightside($pagenum, $lastpage, $pagenationrow);
        }
        $pagenationrow .= "</ul>";
        $pagenatorarray = array('res' => $res, 'max' =>  $textline1, 'current' => $textline2, 'ctrl' => $pagenationrow);
        // $table = $this->toHtmlSearch($pagenatorarray, $app);
        // return $table;
        return $pagenatorarray;
    }

    public function leftside($pagenum, $pagenationrow)
    {
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $url = $_SERVER['PHP_SELF'].'?pn='.$previous;
            $pagenationrow .= "<li><a href='$url'>" .htmlspecialchars("<<"). "</a></li>";

            if ($pagenum-4 > 0) {
                $pagenationrow .= '<li><a>...</a></li>';
            }
            for ($i = $pagenum-3; $i < $pagenum; $i += 1) {
                if ($i > 0) {
                    $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                    $pagenationrow .= "<li><a href='$url'>".$i."</a></li>";
                }
            }
        }
        return $pagenationrow;
    }
    public function rightside($pagenum, $lastpage, $pagenationrow)
    {
        for ($i = $pagenum+1; $i <= $lastpage; $i += 1) {
            if ($i < $pagenum+4) {
                $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                $pagenationrow .= "<li><a href='$url'>".$i."</a></li>";
            } else if ($i == $pagenum+4) {
                $pagenationrow .= '<li><a>...</a></li>';
            } else if ($i >= $pagenum+4) {
                break;
            }
        }


        if ($pagenum != $lastpage) {
            // var_dump($pagenum);
            $next = $pagenum + 1;
            $pagenationrow .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'#objrefpoint"> ' .htmlspecialchars(">>"). ' </a></li>';
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
    public function orderby($column)
    {
        $orderby =  "<span class='orderby'>
                        <a href='?order={$column}&orderas=asc'><span class='glyphiconarrow glyphicon glyphicon-menu-down' aria-hidden='true'></span></a>
                        <a href='?order={$column}&orderas=desc'><span class='glyphiconarrow glyphicon glyphicon-menu-up' aria-hidden='true'></a>
                    </span>";
        return $orderby;
    }

    public function toHtmlSearch($pagenatorarray, $app)
    {
        /*
        * $pagenatorarray = max, current, ctrl
        */
        // $route = "?route=orderby&";

        $table = "";
        $table = "<table class='admintable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Aktiv ".$this->orderby('active')."</th>
                            <th>id ".$this->orderby('id')."</th>
                            <th></th>
                            <th>Roll ".$this->orderby('role')."</th>
                            <th>Användarnamn ".$this->orderby('username')."</th>
                            <th>Förnamn ".$this->orderby('forname')."</th>
                            <th>Efternamn ".$this->orderby('surname')."</th>
                            <th>Email ".$this->orderby('email')."</th>
                            <th>Datum ".$this->orderby('created')."</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
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

            $editurl = $app->url->create('edituser') ."?id=".$row->id;
            $deleteurl = $app->url->create('deleteuser') ."?id=".$row->id;

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
                            <td><a href='$editurl'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>
                            <td><a href='$deleteurl'><span style='color: #a67e7e;' class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>
                        </tr>";
        }
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }
    public function toHtmlEdit($pagenatorarray)
    {
        $table = "<form action='edituserprocess' method='POST'>";
        $table .= "<table class='admintable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Aktiv</th>
                            <th></th>
                            <th>Roll</th>
                            <th>Användarnamn</th>
                            <th>Förnamn</th>
                            <th>Efternamn</th>
                            <th>Email</th>
                            <th>Datum</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar($row->email, $default);
            $gravatar->size = 40;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";

            $selectedyes = ($row->active == 'yes') ? 'selected' : '';
            $selectedno = ($row->active == 'no') ? 'selected' : '';
            $selectedadmin = $row->role == 'admin' ? 'selected' : '';
            $selecteduser = $row->role == 'user' ? 'selected' : '';

            $table .=   "<tr>
                            <td>
                                <select name='active'>
                                    <option value='yes'".$selectedyes.">yes</option>
                                    <option value='no'".$selectedno.">no</option>
                                </select>
                            </td>
                            <td>".$gravatar->toHTML()."</td>
                            <td>
                                <select name='role'>
                                    <option value='admin'".$selectedadmin.">admin</option>
                                    <option value='user'".$selecteduser.">user</option>
                                </select>
                            </td>
                            <td>".$row->username."</td>
                            <td><input type='text' name='forname' value='".$row->forname."' /></td>
                            <td><input type='text' name='surname' value='".$row->surname."' /></td>
                            <td><input type='email' name='email' value='".$row->email."' /></td>
                            <td>".$row->created."</td>
                        </tr>";
        }
        $table .=   "</tbody>
                    </table>
                    <input type='hidden' name='id' value='".$row->id."' />
                    <input type='submit' class='btn btn-default right' name='edituserbtn' value='Redigera' />
                    </form>";
        // return substr($table, 0, -2);
        return $table;
    }

    public function toHtmlEditPassword($pagenatorarray)
    {
        $table = "<form action='admineditpasswordprocess' method='POST'>";
        $table .= "<table class='admintable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Lösenord#1</th>
                            <th>Lösenord#2</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            $table .=   "<tr>
                            <td><input type='password' name='passone' value='' /></td>
                            <td><input type='password' name='passtwo' value='' /></td>
                        </tr>";
        }
        $table .=   "</tbody>
                    </table>
                    <input type='hidden' name='id' value='".$row->id."' />
                    <input type='submit' class='btn btn-default right' name='admineditpasswordbtn' value='Ändra lösenord' />
                    </form>";
        // return substr($table, 0, -2);
        return $table;
    }

    public function createRowTable()
    {
        $table = "<form action='admincreateuserprocess' method='POST'>";
        $table .= "<table class='admintable'>";
        $table .=   "<thead>
                        <tr>
                            <th>Roll</th>
                            <th>Användarnamn</th>
                            <th>Förnamn</th>
                            <th>Efternamn</th>
                            <th>Email</th>
                            <th>Lösenord</th>
                            <th>Lösenord</th>
                        </tr>
                    </thead>
                    <tbody>";

        $table .=   "<tr>
                        <td>
                            <select name='role'>
                                <option value='admin'>admin</option>
                                <option value='user'>user</option>
                            </select>
                        </td>
                        <td><input type='text' name='username' value='' /></td>
                        <td><input type='text' name='forname' value='' /></td>
                        <td><input type='text' name='surname' value='' /></td>
                        <td><input type='email' name='email' value='' /></td>
                        <td><input type='password' name='passone' value='' /></td>
                        <td><input type='password' name='passtwo' value='' /></td>
                    </tr>";

        $table .=   "</tbody>
                    </table>
                    <input type='submit' class='btn btn-default right' name='admincreateuserbtn' value='Lägg till' />
                    </form>";
        // return substr($table, 0, -2);
        return $table;
    }
}
