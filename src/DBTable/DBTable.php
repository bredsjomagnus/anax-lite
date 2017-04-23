<?php
namespace Maaa16\DBTable;

class DBTable
{

    public function generateDBTableUsers($app, $tableproporties = ["pages" => 5, "orderby" => 'id',"orderas" => 'desc', "searchcolumn" => 'username', "searchfield" => '%%', "databasetable" => 'accounts'])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlSearchUsers($paginatorarray, $app);
        return $table;
    }
    public function generateDBTableContent($app, $tableproporties = ["pages" => 5, "orderby" => 'id',"orderas" => 'desc', "searchcolumn" => 'title', "searchfield" => '%%', "databasetable" => 'content'])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlSearchContent($paginatorarray, $app);
        return $table;
    }

    public function generateDBTableEditUsers($app, $tableproporties = ["pages" => 1, "orderby" => 'id',"orderas" => 'desc', "searchcolumn" => 'username', "searchfield" => '%%', "databasetable" => 'accounts'])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlEditUsers($paginatorarray);
        return $table;
    }

    public function generateDBTableEditContent($app, $tableproporties = ["pages" => 1, "orderby" => 'id',"orderas" => 'desc', "searchcolumn" => 'title', "searchfield" => '%%', "databasetable" => 'content'])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlEditContent($paginatorarray);
        return $table;
    }

    public function generateDBTableEditPassword($app, $tableproporties = ["pages" => 1, "orderby" => 'id',"orderas" => 'desc', "searchcolumn" => 'username', "searchfield" => '%%', "databasetable" => 'accounts'])
    {
        $paginatorarray = $this->paginator($app, $tableproporties);
        $table = $this->toHtmlEditPassword($paginatorarray);
        return $table;
    }

    // nya paginator
    private function paginator($app, $tableproporties)
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

        $sql = "SELECT * FROM $dbtable $search";
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

    // gamla paginator
    // private function paginator($app, $tableproporties)
    // {
    //
    //     // $tableproporties = [antal rader per sida, kolumnnamn som skall sorteras efter, asc eller desc beroende på ordning, kolumn att söka på, söksträng]
    //     /*
    //     * Connectar till databasen och räknar antalet Objekt utefter vad man sökt efter
    //     * $numobjects = antalet objekt i databasen
    //     */
    //     $app->database->connect();
    //     $search = "WHERE ". $tableproporties[3] ." LIKE '".$tableproporties[4]."' ";
    //
    //     $sql = "SELECT * FROM accounts $search";
    //     $params = [];
    //     $preres = $app->database->executeFetchAll($sql, $params);
    //     $numobjects = count($preres);
    //
    //     /*
    //     * Sätter begränsningen på antalet objekt per sida med $tableproporties[0]
    //     * Sätter vilken som är sista sidan med $lastpage
    //     */
    //     $lastpage = ceil($numobjects/$tableproporties[0]);
    //     if ($lastpage < 1) {
    //         $lastpage = 1;
    //     }
    //
    //     /*
    //     * Sätter starten på pagenatorn till 1.
    //     * Kontrollerar sedan om det finns någon information att hämta i adressraden.
    //     * med preg_replace ser man till att $_GET['pn'] bara kan vara siffror.
    //     * Ser sedan till att $pagenum inte kan vara mindre än 1 eller mer än $lastpage
    //     */
    //     $pagenum = (isset($_GET['pn'])) ? preg_replace('#[^0-9]#', '', $_GET['pn']) : 1;
    //     if ($pagenum < 1) {
    //         $pagenum = 1;
    //     } else if ($pagenum > $lastpage) {
    //         $pagenum = $lastpage;
    //     }
    //
    //     /*
    //     * Söker efter objekten i databasen med begränsning $limit
    //     */
    //     // $app->database->connect();
    //
    //     // $search = "WHERE ". $tableproporties[3] ." LIKE '%".$tableproporties[4]."%' ";
    //
    //
    //     $search = "WHERE ". $tableproporties[3] ." LIKE '".$tableproporties[4]."' ";
    //
    //     $limit = 'LIMIT ' .($pagenum - 1 ) * $tableproporties[0] . ', ' . $tableproporties[0];
    //     $order = 'ORDER BY ' . $tableproporties[1] ." ". $tableproporties[2]. " ";
    //     // $search = "WHERE ". $tableproporties[3] ." LIKE '%".$tableproporties[4]."%' ";
    //     $sql = "SELECT * FROM accounts $search $order $limit";
    //     $params = [];
    //     $res = $app->database->executeFetchAll($sql, $params);
    //
    //     $textline1 = "Object (".$numobjects.")";
    //     $textline2 = "Sida ".$pagenum." av ".$lastpage;
    //
    //     $pagenationrow = "<ul class='pagination'>";
    //     if ($lastpage != 1) {
    //         $pagenationrow = $this->leftside($pagenum, $pagenationrow);
    //
    //         $pagenationrow .= "<li><a class='paginatoractive'>".$pagenum."</a></li>";
    //
    //         $pagenationrow = $this->rightside($pagenum, $lastpage, $pagenationrow);
    //     }
    //     $pagenationrow .= "</ul>";
    //     $pagenatorarray = array('res' => $res, 'max' =>  $textline1, 'current' => $textline2, 'ctrl' => $pagenationrow);
    //     // $table = $this->toHtmlSearch($pagenatorarray, $app);
    //     // return $table;
    //     return $pagenatorarray;
    // }

    private function leftside($pagenum, $pagenationrow)
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

    private function rightside($pagenum, $lastpage, $pagenationrow)
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
    private function orderby($column)
    {
        $orderby =  "<span class='orderby'>
                        <a href='?order={$column}&orderas=asc'><span class='glyphiconarrow glyphicon glyphicon-menu-down' aria-hidden='true'></span></a>
                        <a href='?order={$column}&orderas=desc'><span class='glyphiconarrow glyphicon glyphicon-menu-up' aria-hidden='true'></a>
                    </span>";
        return $orderby;
    }

    private function toHtmlSearchUsers($pagenatorarray, $app)
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

    private function toHtmlSearchContent($pagenatorarray, $app)
    {
        $table = "";
        $table = "<table class='admintable contenttable'>";
        $table .= "<thead>
                <tr>
                   <th>Id ".$this->orderby('id')."</th>
                   <th>Titel ".$this->orderby('title')."</th>
                   <th>Sökväg ".$this->orderby('path')."</th>
                   <th>Slug ".$this->orderby('slug')."</th>
                   <th>Typ ".$this->orderby('type')."</th>
                   <th>Status ".$this->orderby('status')."</th>
                   <th class='datetimecell'>Publicerad ".$this->orderby('published')."</th>
                   <th>Skapad ".$this->orderby('created')."</th>
                   <th class='datetimecell'>Uppdaterad ".$this->orderby('updated')."</th>
                   <th class='datetimecell'>Borttagen ".$this->orderby('deleted')."</th>
                   <th colspan='4'>Val</th>
               </tr>
               <tbody>";
        foreach ($pagenatorarray['res'] as $row) {
            $publishclass = "";
            $terminate = "";
            $deleteclass = "glyphicon glyphicon-remove-circle";
            if ($row->status == 'notPublished') {
                $publishclass = "glyphicon glyphicon-share";
            } else if ($row->status == 'Published') {
                $publishclass = "glyphicon glyphicon-lock";
            } else if ($row->status == 'isDeleted') {
                $deleteclass = "glyphicon glyphicon-repeat";
                $terminate = "<td><a href='".$app->url->create('adminterminatecontent')."?id=".$row->id."'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";
            }
            if ($row->type == 'page') {
                $titleurl = $app->url->create('pagefromadmin')."?route=".$row->path;
                $title = "<a href='$titleurl'>$row->title</a>";
            } else {
                $title = $row->title;
            }
            $table .= "<tr>
                <td>".$row->id."</td>
                <td>".$title."</td>
                <td>".$row->path."</td>
                <td>".$row->slug."</td>
                <td>". $row->type."</td>
                <td>". $row->status."</td>
                <td>". $row->published."</td>
                <td>". $row->created."</td>
                <td>". $row->updated."</td>
                <td>". $row->deleted."</td>
                <td><a href='".$app->url->create('adminpublishcontent')."?id=".$row->id."&status=".$row->status."'><span class='$publishclass' aria-hidden='true'></span></a></td>
                <td><a href='".$app->url->create('admineditcontent')."?id=".$row->id."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>
                <td><a href='".$app->url->create('admindeletecontent')."?id=".$row->id."&status=".$row->status."'><span class='$deleteclass' aria-hidden='true'></span></a></td>
                $terminate
            </tr>";
        }
        $table .=   "</tbody>
                    </table>";

        $table .= "<div class='col-md-12>'<nav><div class='paginatordiv'>".$pagenatorarray['ctrl']."</div></nav></div>";

        return $table;
    }

    private function toHtmlEditUsers($pagenatorarray)
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

    private function toHtmlEditContent($pagenatorarray)
    {
        $table = "<form action='admineditcontentprocess' method='POST'>";
        foreach ($pagenatorarray['res'] as $row) {
            $table .=   "<div class='form-group'>
                            <label>TITEL</label>
                            <input class='form-control' type='text' name='contentTitle' value='".$row->title."'/>
                        </div>
                        <div class='form-group'>
                            <label>SÖKVÄG</label>
                            <input class='form-control' type='text' name='contentPath' value='".$row->path."'/>
                        </div>
                        <div class='form-group'>
                            <label>SLUG</label>
                            <input class='form-control' type='text' name='contentSlug' value='".$row->slug."'/>
                        </div>
                        <div class='form-group'>
                            <label>INNEHÅLL</label>
                            <textarea class='form-control' name='contentData'>".htmlentities($row->data)."</textarea>
                        </div>
                        <div class='form-group'>
                            <label>TYP</label>
                            <select name='contentType'>
                                <option value='page'>page</option>
                                <option value='post'>post</option>
                                <option value='block'>block</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label>FILTER</label>
                            <input class='form-control' type='text' name='contentFilter' value='".$row->filter."'/>
                        </div>";
        }
        $table .=   "
                    <input type='hidden' name='contentId' value='".htmlentities($row->id)."' />
                    <input type='submit' class='btn btn-default right' name='editcontentbtn' value='Spara' />
                    </form>";

        // <input class='form-control' type='text' name='contentType' value='".$row->type."'/>
        
        return $table;
    }

    private function toHtmlEditPassword($pagenatorarray)
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
