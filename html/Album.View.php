<?php
function GetPhotoEditView($photoID, $fullPath, $title, $description, $private) {
    $convertedPrivate = ($private) ? "checked" : "";
    ?>
    <div class="row" photoID = '<?echo $photoID ?>'>
        <div class="col-md-4">
            <img src='<? echo $fullPath ?>' class='img-responsive' photoID = '<? echo $photoID ?>' />
        </div>
        <div class="col-md-8">
            <div class="row">
                <form id="update-photo-info-<? echo $photoID ?>" class="form-horizontal" role="form">
                    <input type="hidden" name="photoID" value="<? echo $photoID ?>">
                    <div class="form-group">
                        <label for="update-photo-title-<? echo $photoID ?>" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input name="title" type="text" class="form-control" id="update-photo-title-<? echo $photoID ?>" placeholder="Название фото" value="<?echo $title ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update-photo-description-<? echo $photoID ?>" class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" id="update-photo-description-<? echo $photoID ?>" placeholder="Описание фото"><?echo $description?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <lable><input type="checkbox" name="private" <? echo $convertedPrivate ?>>Закрытый<lable>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default btn-info" id="update-photo-<? echo $photoID ?>" photoID = '<? echo $photoID ?>'>Обновить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <button class='delPhoto btn btn-danger col-sm-offset-2' photoID=' <? echo $photoID ?> '> Удалить </button>
            </div>
        </div>
    </div>
    <?
}
?>