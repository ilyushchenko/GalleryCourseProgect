<?php
require_once "classes/Auth.php";
if(!Auth::isAuthorized()) header("Location: login.php");
// Вытаскиваем необходимые данные
if(isset($_POST['deletePhoto'])) {
    $photoID = $_POST['deletePhoto'];
    $db = new DB();
    $query = "SELECT * FROM albums, photos WHERE photos.ID = '$photoID' AND albums.ID = photos.AlbumID";
    $result = $db->getQuerry($query);
    if(!$result) { echo "Произошла ошибка подключения к серверу и БД, проверьте параметры полключения";  exit;}
    if (mysqli_num_rows($result) > 0) {
        $pictureDataRow = mysqli_fetch_array ($result);
        mysqli_free_result($result);
        if($pictureDataRow['OwnerID'] == Auth::getUserID()) {
            $uploaddir = $pictureDataRow['Catalog'];
            $file = $pictureDataRow['Filename'];
            $query = "DELETE FROM photos WHERE ID='$photoID'";
            $result = $db->getQuerry($query);
            if($result) {
                unlink($uploaddir.$file);
                echo json_encode( array("deleted" => 1) );
            } else {
                echo json_encode( array("deleted" => 0) );
            }
        }
    }
}
if(isset($_POST['value']) && isset($_POST['name']) && isset($_POST['albumID'])) {
    $db = new DB();

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
        $db->getQuerry("INSERT INTO photos (Title, Description, Date, Catalog,Filename, albumID) VALUES ('фото', 'описание', NOW(),'$uploaddir','$randomName', '$albumID')");
        echo $randomName.":загружен успешно";
    }
    else {
        // Показать сообщение об ошибке, если что-то пойдет не так.
        echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
    }
}
?>