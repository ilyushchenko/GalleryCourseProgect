<?
    function GetAlbumRow($title, $description, $photoLink, $albumID) {
    ?>
        <div class="row album-row">
            <div class="col-md-6">
                <a href='?albumID=<?echo $albumID;?>'>
                    <img class = 'img-responsive' src='<?echo $photoLink;?>' alt='<?echo $title;?>' />
                </a>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="row">
                    <h2><?echo $title;?></h2>
                </div>
                <div class="row">
                    <h3><?echo $title;?></h3>
                </div>
            </div>
        </div>
    <?
    }
?>