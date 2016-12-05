<?
function GetAlbumRow($title, $description, $photoLink, $albumID)
{
    ?>
    <div class="row album-row">
        <div class="col-md-6">
            <a href='?albumID=<? echo $albumID; ?>'>
                <img class='img-responsive' src='<? echo $photoLink; ?>' alt='<? echo $title; ?>'/>
            </a>
        </div>
        <div class="col-md-5 col-md-offset-1">
            <div class="row">
                <h2><? echo $title; ?></h2>
            </div>
            <div class="row">
                <h3><? echo $title; ?></h3>
            </div>
        </div>
    </div>
    <?
}

function GetInfoAboutAlbum($title, $description, $placeholder)
{
    ?>
    <div class="container">
        <div class="row">
            <h2>Информация об альбоме</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="<? echo $placeholder ?>" alt="Обложка альбома"
                     class="img-thumbnail"/>
            </div>
            <div class="col-md-6">
                <form class="form-horizontal photo-update-info" role="form">
                    <div class="form-group">
                        <label for="inputAlbumName" class="col-sm-2 control-label">Название альбома</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAlbumName"
                                   placeholder="Название альбома">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAlbumDescription" class="col-sm-2 control-label">Описание
                            альбома</label>
                        <div class="col-sm-10">
                                <textarea class="form-control" id="inputAlbumDescription"
                                          placeholder="Описание альбома"></textarea>
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
                            <button type="submit" class="btn btn-default">Обновить альбом</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-danger">Удалить альбом</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?
}

function GetCreateAlbumForm()
{
    ?>
    <form class="form-horizontal" role="form" action="albums.php" method="post">
        <div class="form-group">
            <label for="inputAlbumName" class="col-sm-2 control-label">Название альбома</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="inputAlbumName"
                       placeholder="Название альбома">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAlbumDescription" class="col-sm-2 control-label">Описание альбома</label>
            <div class="col-sm-10">
                                <textarea class="form-control" name="description" id="inputAlbumDescription"
                                          placeholder="Описание альбома"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="private"> Закрытый
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" name="createAlbum">Создать альбом</button>
            </div>
        </div>
    </form>
    <?
}

?>