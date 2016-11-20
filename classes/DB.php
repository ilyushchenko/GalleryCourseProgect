<?php
require_once 'DBSettings.php';
class DB
{
    private $host;
    private $database;
    private $user;
    private $password;
    private $querryResult;
    private $successQuerrry = false;

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

    public function Querry($query)
    {
        $link = $this->connect();
        $result = mysqli_query($link, $query);
        if (!$result) {
            $this->successQuerrry = false;
        }
        else {
            $this->successQuerrry = true;
            $this->querryResult = $result;
        }
        $this->close($link);
        return $this->successQuerrry;
    }

    public function AssocQuerry()
    {
        $arrResult = [];
        if ($this->successQuerrry) {
            if (gettype($this->querryResult) == "boolean") {
                $arrResult =  array("Result" => $this->querryResult);
            }
            else {
                if (mysqli_num_rows($this->querryResult) > 0) {
                    while ($row = mysqli_fetch_assoc($this->querryResult)) {
                        array_push($arrResult, $row);
                    }
                }
            }
        }
        return $arrResult;
    }
}
?>
