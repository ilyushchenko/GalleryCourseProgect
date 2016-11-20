<?php
    require_once "classes/Auth.php";
require_once "classes/AlbumViewer.php";
    if(!Auth::isAuthorized()) header("Location: login.php");
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" href="/css/bootstrap.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.css">
        <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />

        <style>
            .thumb img {
                filter: none; /* IE6-9 */
                -webkit-filter: grayscale(0);
                border-radius:5px;
                background-color: #fff;
                border: 1px solid #ddd;
                padding:5px;
            }
            .thumb img:hover {
                filter: gray; /* IE6-9 */
                -webkit-filter: grayscale(1);
            }
            .thumb {
                padding:5px;
            }
        </style>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="/js/bootstrap.js"></script>
        <script src="/js/javascript.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("a.fancyimage").fancybox();
            });
        </script>

        <title>Document</title>
    </head>
    <body>
        <div class="container">
            <? include "html/header.php";
            // Вытаскиваем необходимые данные
            $db = new DB();
            $av = new AlbumViewer();
            if(isset($_GET['albumID']))
            {
                $albumID = $_GET['albumID'];
                if ($av->isCanViewAlbum($albumID))
                {

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
                        $result = $db->getQuerry($querry);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class='col-md-3 col-sm-4 col-xs-6 thumb'>
                                    <a class='fancyimage' data-fancybox-group='group' href='<? echo $row['Catalog'].$row['Filename']?>'>
                                        <img class="img-responsive" src='<? echo $row['Catalog'].$row['Filename']?>'/>
                                    </a>
                                </div>
                                <?
                            }
                            // очищаем результат
                            mysqli_free_result($result);
                        }
                        ?>
                        </div>
                    </div>
                    <?
                }
            } elseif(isset($_GET['edit']))
            {
                $albumID = $_GET['edit'];
                if ($av->isAlbumOwner($albumID))
                {
                    include 'html/uploadForm.php';
                    GetUploader($albumID);
                    $querry = "SELECT * FROM photos WHERE AlbumID = '$albumID'";
                    $result = $db->getQuerry($querry);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="row" photoID = '<? echo $row['ID'] ?>'>
                                <div class="col-md-4">
                                    <img src='<? echo $row['Catalog'].$row['Filename'] ?>' class='img-responsive' photoID = '<? echo $row['ID'] ?>' />
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <form class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="inputAlbumName" class="col-sm-2 control-label">Название</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputAlbumName" placeholder="Название фото" value="<?echo $row['Title']?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAlbumDescription" class="col-sm-2 control-label">Описание</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="inputAlbumDescription" placeholder="Описание фото"><?echo $row['Description']?></textarea>
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
                                                    <button type="submit" class="btn btn-default btn-info">Обновить</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <button class='delPhoto btn btn-danger col-sm-offset-2' photoID=' <? echo $row['ID'] ?> '> Удалить </button>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        // очищаем результат
                        mysqli_free_result($result);
                    }
                }
                else
                {
                    echo "Вы не можете редактировать альбом";
                }

            } else
            {
                require_once "html/albumRow.php";
                //показ фоток
                $userID = Auth::getUserID();
                $querry = "SELECT * FROM albums WHERE OwnerID = '$userID'";
                $result = $db->getQuerry($querry);
                if ($result) {
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
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row['Title'];
                        $description = $row['Description'];
                        $imageLink = "http://placehold.it/350x150";
                        $albumID = $row['ID'];
                        echo "<tr><td>";
                        GetAlbumRow($title, $description, $imageLink, $albumID);
                        echo "</td></tr>";
                    }
                    echo "</table>";
                    // очищаем результат
                    mysqli_free_result($result);
                }
            }
            ?>
        </div>
    </body>
</html>