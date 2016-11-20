<?php
require_once 'DB.php';
require_once 'Auth.php';

class AlbumViewer
{
    private $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    function isAlbumOwner($albumID)
    {
        $querry = "SELECT OwnerID FROM albums WHERE ID = '$albumID'";
        $result = $this->db->AssocQuerry($querry);
        if(count($result)>0)
            if (Auth::getUserID() == $result[0]['OwnerID'])
                return true;
        return false;
    }

    function isCanViewAlbum($albumID)
    {
        $querry = "SELECT Private, OwnerID FROM albums WHERE ID = '$albumID'";
        $result = $this->db->AssocQuerry($querry);
        $userID = Auth::getUserID();
        if (count($result) > 0) {
            if (0 == $result[0]['Private']) return true;
            else
            {
                if($result[0]['OwnerID'] == $userID) return true;
                $querry = "SELECT * FROM AlbumAccess WHERE AlbumID = '$albumID' AND UserID = '$userID'";
                $result = $this->db->AssocQuerry($querry);
                if (count($result) > 0) {
                    return true;
                }
            }
        }
        return false;
    }
}