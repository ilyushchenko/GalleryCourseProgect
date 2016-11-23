<?
include_once "classes/DB.php";

class Album
{
    public static function GetAlbumPlaceholder($albumID)
    {
        $db = new DB();
        $imageLink = "images/albumDefaultPlaceholder.gif";
        $querry = "SELECT photos.Catalog, photos.Filename FROM AlbumPlaceholder, photos WHERE AlbumPlaceholder.AlbumID = '$albumID' AND photos.ID = AlbumPlaceholder.PhotoID";
        if ($db->Querry($querry)) {
            $result = $db->GetResult();
            if (count($result) > 0) {
                $imageLink = $result[0]['Catalog'] . $result[0]['Filename'];
            }
        }
        return $imageLink;
    }
}
?>