<?php
require_once "classes/Auth.php";
require_once "views/Head.View.php";
require_once "views/Header.View.php";
require_once "models/Album.Model.php";
require_once "views/albumRow.php";
if (!Auth::isAuthorized()) header("Location: login.php");
?>
<!doctype html>
<html lang="en">
<? GetHead("Titlewq") ?>
<body>
<div class="container">
    <? GetHeader(); ?>
</div>
<?
$av = new Album();
if (isset($_GET['albumID'])) {
    $albumID = $_GET['albumID'];
    if ($av->isCanViewAlbum($albumID)) {
        ?>
        <div class="container">
            <div class="row">
                <a class="btn btn-default" href="albums.php" role="button">Назад в альбомы</a>
                <?
                if ($av->isAlbumOwner($albumID)) {
                    echo "<a class='btn btn-default' href='?edit=" . $albumID . "' role='button'>Редактировать альбом</a>";
                }
                ?>
            </div>
            <div class="row">
                <?
                $result = $av->GetPhotoFromAlbum($albumID);
                foreach ($result as $photo) { ?>
                    <div class='col-md-3 col-sm-4 col-xs-6 thumb'>
                        <a class='fancyimage' data-fancybox-group='group'
                           href='<? echo $photo['Path'] ?>'>
                            <img class="img-responsive"
                                 src='<? echo $photo['Path'] ?>'/>
                        </a>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>
        <?
    }
} elseif (isset($_GET['edit'])) {
    $albumID = $_GET['edit'];
    if ($av->isAlbumOwner($albumID)) {
        ?>
        <section id="albumInfo">
            <? GetInfoAboutAlbum("Заголовок", "Описание", $av->GetAlbumPlaceholder($albumID)); ?>
        </section>
        <section id="upload">
            <div class="container">
                <div class="row">
                    <h2>Загрузка фотографий</h2>
                </div>
                <div class="row">
                    <?
                    if ($av->isAlbumOwner($albumID)) {
                        include 'views/uploadForm.php';
                        GetUploader($albumID);
                    } else {
                        echo "Вы не можете редактировать альбом";
                    }
                    ?>
                </div>
            </div>
        </section>
        <section id="photos">
            <div class="container">
                <div class="row">
                    <h2>Фотографии в альбоме</h2>
                </div>
                <div class="row">
                    <?
                    if ($av->isAlbumOwner($albumID)) {
                        include_once "views/EditPhotoView.php";
                        foreach ($av->GetPhotoFromAlbum($albumID) as $photo) {
                            GetPhotoEditView($photo['ID'], $photo['Path'], $photo['Title'], $photo['Description'], $photo['Private']);
                        }
                    } else {
                        echo "Вы не можете редактировать альбом";
                    }
                    ?>
                </div>
            </div>
        </section>
        <?

    } else {
        echo "Вы не можете редактировать альбом";
    }

} elseif (isset($_POST["createAlbum"]) && isset($_POST["title"]) && isset($_POST["description"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $private = (isset($_POST["private"])) ? 1 : 0;
    $ownerID = Auth::getUserID();
    if ($av->CreateAlbum($title, $description, $private, $ownerID)) {
        echo "Альбом успешно создан";
    }
} else {
    ?>
    <div class="container">
        <table class='table'>

            <tr>
                <td>
                    <? GetCreateAlbumForm() ?>
                </td>
            </tr>
            <?
            $userID = Auth::getUserID();
            $result = $av->GetAlbumsForUser($userID);
            foreach ($result as $photo) {
                $albumID = $photo['ID'];
                $title = $photo['Title'];
                $description = $photo['Description'];
                $imageLink = $av->GetAlbumPlaceholder($albumID);
                echo "<tr><td>";
                GetAlbumRow($title, $description, $imageLink, $albumID);
                echo "</td></tr>";
            }
            ?>
        </table>
    </div>
    <?
}
?>
</body>
</html>