<?php
require_once "classes/Auth.php";
if (!Auth::isAuthorized()) header("Location: login.php");
if (count($_POST) == 0) header("Location: index.php");
$db = new DB();

if (isset($_POST['description']) && isset($_POST['title']) && isset($_POST['photoID'])) {
    $description = $_POST['description'];
    $title = $_POST['title'];
    $photoID = $_POST['photoID'];
    $private = (isset($_POST['private']) == "on") ? 1 : 0;
    $query = "UPDATE photos SET Description = '$description', Title = '$title', Private = '$private' WHERE ID = '$photoID'";
    if ($db->Querry($query)) {
        $result = $db->GetResult();
        if ($result['Result']) {
            echo json_encode(array("updated" => 1));
        } else {
            echo json_encode(array("updated" => 0));
        }
    } else {
        echo json_encode(array("updated" => 0));
    }
}
if (isset($_POST['deletePhoto'])) {
    $photoID = $_POST['deletePhoto'];
    $query = "SELECT * FROM albums, photos WHERE photos.ID = '$photoID' AND albums.ID = photos.AlbumID";

    if ($db->Querry($query)) {
        $result = $db->GetResult();
        foreach ($result as $value) {
            if ($value['OwnerID'] == Auth::getUserID()) {
                $uploaddir = $value['Catalog'];
                $file = $value['Filename'];
                $query = "DELETE FROM photos WHERE ID='$photoID'";
                if ($db->Querry($query) && count($db->GetResult()) > 0) {
                    unlink($uploaddir . $file);
                    echo json_encode(array("deleted" => 1));
                } else {
                    echo json_encode(array("deleted" => 0));
                }
            }
        }
    }
}
if (isset($_POST['setPlaceholder'])) {
    $photoID = $_POST['setPlaceholder'];
    $query = "SELECT AlbumID FROM photos WHERE photos.ID = '$photoID'";
    if ($db->Querry($query)) {
        $result = $db->GetResult();
        if (count($result) > 0) {
            $albumID = $result[0]['AlbumID'];
            $query = "SELECT * FROM AlbumPlaceholder WHERE AlbumID = '$albumID'";
            if ($db->Querry($query)) {
                $result = $db->GetResult();
                if (count($result) > 0) {
                    $query = "UPDATE AlbumPlaceholder SET PhotoID = '$photoID' WHERE AlbumID = '$albumID'";
                    if ($db->Querry($query)) {
                        echo json_encode(array("placeholderUpdated" => 1));
                    } else {
                        echo json_encode(array("placeholderUpdated" => 0));
                    }
                } else {
                    $query = "INSERT INTO AlbumPlaceholder VALUES ('$photoID', '$albumID')";
                    if ($db->Querry($query)) {
                        echo json_encode(array("placeholderAdded" => 1));
                    } else {
                        echo json_encode(array("placeholderAdded" => 0));
                    }
                }
            }
        }

    }
}
?>