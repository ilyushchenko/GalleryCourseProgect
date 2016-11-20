<?
function GetUploader($albumID)
{
?>
    <div class="content">
        <!-- Область для перетаскивания -->
        <div id="drop-files" ondragover="return false">
            <div class="form-group table-bordered">
                <p>Перетащите изображение сюда</p>
                <form id="frm"">
                    <input type="hidden" name="currentAlbum" value="<? echo $albumID; ?>">
                    <input class="form-control" type="file" id="uploadbtn" multiple />
                </form>
            </div>
        </div>
        <!-- Область предпросмотра -->
        <div id="uploaded-holder">
            <div id="dropped-files">
                <!-- Кнопки загрузить и удалить, а также количество файлов -->
                <div id="upload-button">
                    <center>
                        <span>0 Файлов</span>
                        <a href="#" class="upload">Загрузить</a>
                        <a href="#" class="delete">Удалить</a>
                        <!-- Прогресс бар загрузки -->
                        <div id="loading">
                            <div id="loading-bar">
                                <div class="loading-color"></div>
                            </div>
                            <div id="loading-content"></div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <!-- Список загруженных файлов -->
        <div id="file-name-holder">
            <ul id="uploaded-files">
                <h1>Загруженные файлы</h1>
            </ul>
        </div>

    </div>
<?
}
?>