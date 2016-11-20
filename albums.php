<?php
require_once "classes/Auth.php";
require_once "classes/AlbumViewer.php";
require_once "html/Head.View.php";
require_once "html/Header.View.php";
if(!Auth::isAuthorized()) header("Location: login.php");
?>
<!doctype html>
<html lang="en">
    <? GetHead("Titlewq")?>
    <body>
        <div class="container">
            <?
            GetHeader();
            // Вытаскиваем необходимые данные
            $db = new DB();
            $av = new AlbumViewer();
            if(isset($_GET['albumID'])) {
                $albumID = $_GET['albumID'];
                if ($av->isCanViewAlbum($albumID)) {
                    ?>
                    <div class="container">
                        <div class="row">
                            <a class="btn btn-default" href="albums.php" role="button">Назад в альбомы</a>
                            <?
                            if ($av->isAlbumOwner($albumID)) {
                                echo "<a class='btn btn-default' href='?edit=".$albumID."' role='button'>Редактировать альбом</a>";
                            }
                            ?>
                        </div>
                        <div class="row">
                        <?
                        //показ фоток
                        $querry = "SELECT * FROM photos WHERE AlbumID = '$albumID'";

                        if ($db->Querry($querry)) {
                            $result = $db->AssocQuerry();
                            foreach ($result as $photoData) {
                                ?>
                                <div class='col-md-3 col-sm-4 col-xs-6 thumb'>
                                    <a class='fancyimage' data-fancybox-group='group' href='<? echo $photoData['Catalog'].$photoData['Filename']?>'>
                                        <img class="img-responsive" src='<? echo $photoData['Catalog'].$photoData['Filename']?>'/>
                                    </a>
                                </div>
                                <?
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <?
                }
            } elseif(isset($_GET['edit'])) {
                $albumID = $_GET['edit'];
                if ($av->isAlbumOwner($albumID)) {
                    include 'html/uploadForm.php';
                    GetUploader($albumID);
                    $querry = "SELECT * FROM photos WHERE AlbumID = '$albumID'";
                    if ($db->Querry($querry)) {
                        $result = $db->AssocQuerry();
                        include_once "html/Album.View.php";
                        foreach ($result as $photoData) {
                            $title  = $photoData['Title'];
                            $description  = $photoData['Description'];
                            $photoID = $photoData['ID'];
                            $fullPath = $photoData['Catalog'].$photoData['Filename'];
                            $private = $photoData['Private'];
                            GetPhotoEditView($photoID, $fullPath, $title, $description, $private);
                        }
                    }
                }
                else {
                    echo "Вы не можете редактировать альбом";
                }

            }
            else {
                require_once "html/albumRow.php";
                //показ фоток
                $userID = Auth::getUserID();
                $querry = "SELECT * FROM albums WHERE OwnerID = '$userID'";

                if ($db->Querry($querry)) {
                    $result = $db->AssocQuerry();
                    echo "<table class='table'>";
                    ?>
                    <tr>
                        <td>
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="inputAlbumName" class="col-sm-2 control-label">Название альбома</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputAlbumName" placeholder="Название альбома">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAlbumDescription" class="col-sm-2 control-label">Описание альбома</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputAlbumDescription" placeholder="Описание альбома"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Закрытый
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default">Создать альбом</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?
                    foreach ($result as $photoData) {
                        $title = $photoData['Title'];
                        $description = $photoData['Description'];
                        $imageLink = "http://placehold.it/350x150";
                        $albumID = $photoData['ID'];
                        echo "<tr><td>";
                        GetAlbumRow($title, $description, $imageLink, $albumID);
                        echo "</td></tr>";
                    }
                    echo "</table>";
                }
            }
            ?>
        </div>
    </body>
</html>