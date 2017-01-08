<?php
require_once "classes/Auth.php";
if (!Auth::isAuthorized()) header("Location: login.php");
if (count($_POST) == 0) header("Location: index.php");
// Вытаскиваем необходимые данные
$db = new DB();


if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['album'])) {
    $arResult['ok'] = "N";
    $uploaddir = 'upload/';
    $title = $_POST['title'];
    $description = $_POST['description'];
    $albumID = $_POST['album'];

    $name = $_FILES['photoFile']['name'];
    $getMime = explode('.', $name);
    $mime = end($getMime);

    $randomName = substr_replace(sha1(microtime(true)), '', 12) . '.' . $mime;

    if (!empty($_FILES['photoFile']['tmp_name'])) {
        $path = $uploaddir . $randomName;
        if (copy($_FILES['photoFile']['tmp_name'], $path)) {
            if ($db->Querry("INSERT INTO photos (Title, Description, Date, Catalog,Filename, albumID) VALUES ('$title', '$description', NOW(),'$uploaddir','$randomName', '$albumID')"))
                $arResult['ok'] = "Y";
        }
    }
    echo json_encode($arResult);
    die();
}
?>