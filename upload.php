<?php
require_once "classes/Auth.php";
if(!Auth::isAuthorized()) header("Location: login.php");
// Вытаскиваем необходимые данные
$db = new DB();
if(isset($_POST['description']) && isset($_POST['title']) && isset($_POST['photoID']) )
{
    $description = $_POST['description'];
    $title = $_POST['title'];
    $photoID = $_POST['photoID'];
    $query = "UPDATE photos SET Description = '$description', Title = '$title' WHERE ID = '$photoID' or ID = '44'";
    if ($db->Querry($query))
    {
        $result = $db->AssocQuerry();
        print_r($result);
    }


}
if(isset($_POST['deletePhoto'])) {
    $photoID = $_POST['deletePhoto'];
    $query = "SELECT * FROM albums, photos WHERE photos.ID = '$photoID' AND albums.ID = photos.AlbumID";

    if ($db->Querry($query)) {
        $result = $db->AssocQuerry();
        foreach ($result as $value) {
            if($value['OwnerID'] == Auth::getUserID()) {
                $uploaddir = $value['Catalog'];
                $file = $value['Filename'];
                $query = "DELETE FROM photos WHERE ID='$photoID'";
                if($db->Querry($query) && count($db->AssocQuerry())>0) {
                    unlink($uploaddir.$file);
                    echo json_encode( array("deleted" => 1) );
                } else {
                    echo json_encode( array("deleted" => 0) );
                }
            }
        }
    }
}
if(isset($_POST['value']) && isset($_POST['name']) && isset($_POST['albumID'])) {
    // Все загруженные файлы помещаются в эту папку
    $uploaddir = 'images/';
    $file = $_POST['value'];
    $name = $_POST['name'];
    $albumID = $_POST['albumID'];
    echo $file;
    echo $name;
    echo $albumID;
    // Получаем расширение файла
    $getMime = explode('.', $name);
    $mime = end($getMime);

    // Выделим данные
    $data = explode(',', $file);

    // Декодируем данные, закодированные алгоритмом MIME base64
    $encodedData = str_replace(' ','+',$data[1]);
    $decodedData = base64_decode($encodedData);

    // Вы можете использовать данное имя файла, или создать произвольное имя.
    // Мы будем создавать произвольное имя!
    $randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;

    // Создаем изображение на сервере
    if(file_put_contents($uploaddir.$randomName, $decodedData)) {
        // Записываем данные изображения в БД
        if ($db->Querry("INSERT INTO photos (Title, Description, Date, Catalog,Filename, albumID) VALUES ('фото', 'описание', NOW(),'$uploaddir','$randomName', '$albumID')"))
        echo $randomName.":загружен успешно";
    }
    else {
        // Показать сообщение об ошибке, если что-то пойдет не так.
        echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
    }
}
?>