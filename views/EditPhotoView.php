<?php
function GetPhotoEditView($photoID, $fullPath, $title, $description, $private)
{
    $convertedPrivate = ($private) ? "checked" : "";
    ?>
    <div class="row" photoID='<? echo $photoID ?>'>
        <div class="col-md-6">
            <img src='<? echo $fullPath ?>' class='img-thumbnail' photoID='<? echo $photoID ?>'/>
        </div>
        <div class="col-md-6">
            <div class="row">
                <form id="update-photo-info-<? echo $photoID ?>" class="form-horizontal update-photo-info" role="form">
                    <input type="hidden" name="photoID" value="<? echo $photoID ?>">
                    <div class="form-group">
                        <label for="update-photo-title-<? echo $photoID ?>"
                               class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input name="title" type="text" class="form-control"
                                   id="update-photo-title-<? echo $photoID ?>" placeholder="Название фото"
                                   value="<? echo $title ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update-photo-description-<? echo $photoID ?>" class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control"
                                      id="update-photo-description-<? echo $photoID ?>"
                                      placeholder="Описание фото"><? echo $description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="private"
                                           id="update-photo-private-<? echo $photoID ?>" <? echo $convertedPrivate ?>>
                                    Закрытый
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" id="update-photo-<? echo $photoID ?>"
                                    photoID='<? echo $photoID ?>'>Обновить информацию
                            </button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-default setPlaceholder col-sm-offset-2 col-sm-10" name="setPlaceholder" id="make-album-cover-<? echo $photoID ?>"
                        photoID='<? echo $photoID ?>'>Сделать обложкой альбома
                </button>
                <button class='delPhoto btn btn-danger col-sm-offset-2 col-sm-10' photoID=' <? echo $photoID ?> '> Удалить фото
                </button>
            </div>
        </div>
    </div>
    <?
}

?>