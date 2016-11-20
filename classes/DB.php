<?php
require_once 'DBSettings.php';
class DB
{
    private $host;
    private $database;
    private $user;
    private $password;

    public function __construct()
    {
        $this->host = DBSettings::HOST;
        $this->database = DBSettings::DATABASE;
        $this->user = DBSettings::USER;
        $this->password = DBSettings::PASSWORD;
    }

    private function connect()
    {
        $link = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if (!$link) {
            echo "Unable to connect to DB: " . mysqli_error($link);
            exit;
        }
        return $link;
    }

    private function close($link)
    {
        mysqli_close($link);
    }

    public function getQuerry($query)
    {
        $link = $this->connect();
        $result = mysqli_query($link, $query);
        if (!$result) {
            echo "Could not successfully run query from DB: " . mysqli_error($link);
            exit;
        }
        $this->close($link);
        return $result;
    }

    public function AssocQuerry($querry)
    {
        $arrResult = [];
        $result = $this->getQuerry($querry);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($arrResult, $row);
            }
            mysqli_free_result($result);
        }
        return $arrResult;
    }
}
?>
