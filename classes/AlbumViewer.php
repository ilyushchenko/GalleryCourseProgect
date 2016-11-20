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
        if($this->db->Querry($querry)) {
            $result = $this->db->AssocQuerry();
            if (Auth::getUserID() == $result[0]['OwnerID'])
                return true;
        }
        return false;

    }

    function isCanViewAlbum($albumID)
    {
        $querry = "SELECT Private, OwnerID FROM albums WHERE ID = '$albumID'";
        if ($this->db->Querry($querry))
        {

            $querryData = $this->db->AssocQuerry();
            $userID = Auth::getUserID();
            if (0 == $querryData[0]['Private']) return true;
            else
            {
                if($querryData[0]['OwnerID'] == $userID) return true;
                $querry = "SELECT * FROM AlbumAccess WHERE AlbumID = '$albumID' AND UserID = '$userID'";

                if ($this->db->Querry($querry))
                {
                    $result = $this->db->AssocQuerry();
                    if (count($result) > 0) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}