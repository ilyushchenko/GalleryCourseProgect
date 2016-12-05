<?
require_once "classes/DB.php";
require_once 'classes/Auth.php';


class Album
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function GetAlbumPlaceholder($albumID)
    {
        $imageLink = "images/albumDefaultPlaceholder.gif";
        $querry = "SELECT photos.Catalog, photos.Filename FROM AlbumPlaceholder, photos WHERE AlbumPlaceholder.AlbumID = '$albumID' AND photos.ID = AlbumPlaceholder.PhotoID";
        if ($this->db->Querry($querry)) {
            $result = $this->db->GetResult();
            if (count($result) > 0) {
                $imageLink = $result[0]['Catalog'] . $result[0]['Filename'];
            }
        }
        return $imageLink;
    }

    function isAlbumOwner($albumID)
    {
        $querry = "SELECT OwnerID FROM albums WHERE ID = '$albumID'";
        if ($this->db->Querry($querry)) {
            $result = $this->db->GetResult();
            if (count($result) > 0) {
                if (Auth::getUserID() == $result[0]['OwnerID'])
                    return true;
            }
        }
        return false;

    }

    function isCanViewAlbum($albumID)
    {
        $querry = "SELECT Private, OwnerID FROM albums WHERE ID = '$albumID'";
        if ($this->db->Querry($querry)) {
            $querryData = $this->db->GetResult();
            $userID = Auth::getUserID();
            if (count($querryData) > 0) {
                if (0 == $querryData[0]['Private']) return true;
                else {
                    if ($querryData[0]['OwnerID'] == $userID) return true;
                    $querry = "SELECT * FROM AlbumAccess WHERE AlbumID = '$albumID' AND UserID = '$userID'";
                    if ($this->db->Querry($querry)) {
                        $result = $this->db->GetResult();
                        if (count($result) > 0) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    function CreateAlbum($title, $description, $private, $ownerID)
    {
        $querry = "INSERT INTO albums (Title, Description, Private, OwnerID) VALUES ('$title', '$description', '$private', '$ownerID')";
        if ($this->db->Querry($querry)) {
            return true;
        }
        return false;
    }

    function GetPhotoFromAlbum($albumID)
    {
        $data = [];
        $querry = "SELECT * FROM photos WHERE AlbumID = '$albumID'";
        if ($this->db->Querry($querry)) {
            $result = $this->db->GetResult();
            foreach ($result as $photo) {
                array_push($data,
                    Array(
                        "Title" => $photo['Title'],
                        "Description" => $photo['Description'],
                        "ID" => $photo['ID'],
                        "Path" => $photo['Catalog'] . $photo['Filename'],
                        "Private" => $photo['Private']
                    )
                );
            }
        }
        return $data;
    }

    function GetAlbumsForUser($userID)
    {
        $data = [];
        $userID = Auth::getUserID();
        $querry = "SELECT * FROM albums WHERE OwnerID = '$userID'";

        if ($this->db->Querry($querry)) {
            $result = $this->db->GetResult();
            foreach ($result as $album) {
                array_push($data,
                    Array(
                        "ID" => $album['ID'],
                        "Title" => $album['Title'],
                        "Description" => $album['Description'],
                        "Private" => $album['Private']
                    )
                );
            }
        }
        return $data;
    }
}

?>