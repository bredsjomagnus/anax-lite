<?php
namespace Maaa16\Database;

/**
 * Class to collect all database activities.
 */
class Database implements \Anax\Common\ConfigureInterface
{
    use \Anax\Common\ConfigureTrait;

    /** @var $pdo the PDO connection. */
    private $pdo;
    // private $dbconfig;


    /**
     * Create a connection to the database.
     *
     * @param array $config details on how to connect.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD)
     */
    public function connect()
    {
        try {
            $this->pdo = new \PDO($this->dbconfig['dns'], $this->dbconfig['user'], $this->dbconfig['password'], $this->dbconfig['options']);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (Exception $e) {
            // Rethrow to hide connection details, through the original
            // exception to view all connection details.
            //throw $e;
            throw new \PDOException("Could not connect to database, hiding details.");
        }
    }

    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * Do SELECT with optional parameters and return a resultset.
     *
     * @param string $sql   statement to execute
     * @param array  $param to match ? in statement
     *
     * @return array with resultset
     */
    public function executeFetchAll($sql, $param = [])
    {
        $sth = $this->execute($sql, $param);
        $res = $sth->fetchAll();
        if ($res === false) {
            $this->statementException($sth, $sql, $param);
        }
        return $res;
    }



    /**
     * Do INSERT/UPDATE/DELETE with optional parameters.
     *
     * @param string $sql   statement to execute
     * @param array  $param to match ? in statement
     *
     * @return PDOStatement
     */
    public function execute($sql, $param = [])
    {
        $sth = $this->pdo->prepare($sql);
        if (!$sth) {
            $this->statementException($sth, $sql, $param);
        }

        $status = $sth->execute($param);
        if (!$status) {
            $this->statementException($sth, $sql, $param);
        }

        return $sth;
    }

    public function executeProcedure($sql, $param = [], $paramType = [])
    {
        $sth = $this->pdo->prepare($sql);
        if (!$sth) {
            $this->statementException($sth, $sql, $param);
        }
        $counter = 1;
        foreach ($param as $input) {
            // print_r($input);
            if ($paramType[$input] == 'str') {
                // $sth->bindParam($counter, $input, \PDO::PARAM_INPUT_OUTPUT, $paramType[$input][1]);
                // $sth->bindParam($bindNames[$counter], $input, \PDO::PARAM_STR, $paramType[$input][1]);
                // $sth->bindValue($bindNames[$counter], $input, \PDO::PARAM_STR);
                $sth->bindValue($counter, $input, \PDO::PARAM_STR);
            } else if ($paramType[$input] == 'int') {
                $sth->bindValue($counter, $input, \PDO::PARAM_INT);
            }

            $counter += 1;
        }
        $status = $sth->execute();
        if (!$status) {
            $this->statementException($sth, $sql, $param);
        }

        return $sth;

    }


    /**
     * Through exception with detailed message.
     *
     * @param PDOStatement $sth statement with error
     * @param string       $sql     statement to execute
     * @param array        $param   to match ? in statement
     *
     * @return void
     *
     * @throws Exception
     */
    public function statementException($sth, $sql, $param)
    {
        throw new \Exception(
            $sth->errorInfo()[2]
            . "<br><br>SQL:<br><pre>$sql</pre><br>PARAMS:<br><pre>"
            . implode($param, "\n")
            . "</pre>"
        );
    }

    /**
     * Return last insert id from an INSERT.
     *
     * @return void
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Set default values from configuration.
     *
     * @return this.
     */
    public function setDefaultsFromConfiguration()
    {
        $this->dbconfig = $this->config['database'];
        // var_dump($this->dbconfig);
        return $this;
    }

    public function getConfig()
    {
        return $this->dbconfig["options"];
        // return "fisk";
    }

    // public function generateTable($res)
    // {
    //     $table = "<table class='admintable'>";
    //     $table .=   "<thead>
    //                     <tr>
    //                         <th></th>
    //                         <th>Roll</th>
    //                         <th>Användarnamn</th>
    //                         <th>Förnamn</th>
    //                         <th>Efternamn</th>
    //                         <th>Email</th>
    //                         <th>Datum</th>
    //                         <th></th>
    //                     </tr>
    //                 </thead>
    //                 <tbody>";
    //     foreach ($res as $row) {
    //         $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
    //         $gravatar = new \Maaa16\Gravatar\Gravatar($row->email, $default);
    //         $gravatar->size = 30;
    //         $gravatar->rating = "G";
    //         $gravatar->border = "FF0000";
    //
    //         $editurl = $this->app->url->create('edituser') ."?username=".$row->username;
    //
    //         $table .=   "<tr>
    //                         <td>".$gravatar->toHTML()."</td>
    //                         <td>".$row->role."</td>
    //                         <td>".$row->username."</td>
    //                         <td>".$row->forname."</td>
    //                         <td>".$row->surname."</td>
    //                         <td>".$row->email."</td>
    //                         <td>".$row->created."</td>
    //                         <td><a href='$editurl'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></td>
    //                     </tr>";
    //     }
    //     $table .=   "</tbody>
    //                 </table>";
    //     // return substr($table, 0, -2);
    //     return $table;
    // }
    // public function generateEditTable($res)
    // {
    //     $table = "<form action='edituserprocess' method='POST'>";
    //     $table .= "<table class='admintable'>";
    //     $table .=   "<thead>
    //                     <tr>
    //                         <th></th>
    //                         <th>Roll</th>
    //                         <th>Användarnamn</th>
    //                         <th>Förnamn</th>
    //                         <th>Efternamn</th>
    //                         <th>Email</th>
    //                         <th>Datum</th>
    //                         <th></th>
    //                     </tr>
    //                 </thead>
    //                 <tbody>";
    //     foreach ($res as $row) {
    //         $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
    //         $gravatar = new \Maaa16\Gravatar\Gravatar($row->email, $default);
    //         $gravatar->size = 40;
    //         $gravatar->rating = "G";
    //         $gravatar->border = "FF0000";
    //
    //         $table .=   "<tr>
    //                         <td>".$gravatar->toHTML()."</td>
    //                         <td><input type='text' name='role' value='".$row->role."' /></td>
    //                         <td>".$row->username."</td>
    //                         <td><input type='text' name='forname' value='".$row->forname."' /></td>
    //                         <td><input type='text' name='surname' value='".$row->surname."' /></td>
    //                         <td><input type='email' name='email' value='".$row->email."' /></td>
    //                         <td>".$row->created."</td>
    //                     </tr>";
    //     }
    //     $table .=   "</tbody>
    //                 </table>
    //                 <input type='hidden' name='username' value='".$row->username."' />
    //                 <input type='submit' class='btn btn-default right' name='edituserbtn' value='Ändra' />
    //                 </form>";
    //     // return substr($table, 0, -2);
    //     return $table;
    // }
}
