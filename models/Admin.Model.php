<?php
require_once "classes/DB.php";
require_once 'classes/Auth.php';

/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 26.11.16
 * Time: 10:51
 */
class Admin
{

    public static function IsAdmin()
    {
        if (Auth::isAuthorized()) {
            $UserID = Auth::getUserID();
            $querry = "SELECT * FROM Administrators WHERE UserID = '$UserID'";
            $db = new DB();
            if ($db->Querry($querry)) {
                $result = $db->GetResult();
                if (count($result) > 0) {
                    return true;
                }
            }

        }
        return false;
    }

    public static function GetUsers()
    {
        $db = new DB();
        $query = "SELECT * FROM users";
        $result = [];

        if ($db->Querry($query)) {
            $result = $db->GetResult();
        }
        return $result;
    }

    public static function GetQuerry($select, $from, $where)
    {
        $db = new DB();
        $querry = "SELECT ".$select." FROM ".$from;
        if ($where != "") {
            $querry = $querry." WHERE " . $where;
        }
        if ($db->Querry($querry))
        {
            $result = $db->GetResult();
            return $result;
        }
        return [];
    }
}