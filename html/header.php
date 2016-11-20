<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Галлерея</a>
            </div>
            <ul class="nav navbar-nav">
                <?
                AddLink("index.php", "Главная");
                AddLink("upload.php", "Загрузчик");
                AddLink("albums.php", "Альбомы")
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?
                if (Auth::isAuthorized()) AddLink("profile.php", "Профиль");
                if (Auth::isAuthorized()) AddLink("login.php?logout", "Выйти"); else AddLink("login.php", "Войти");
                ?>
            </ul>
        </div>
    </nav>
</header>


<?
function AddLink($link, $title)
{
    $paths = explode("/", $_SERVER['PHP_SELF']);
    echo ($link == $paths[count($paths) - 1]) ?
        "<li class='active'><a href=".$link.">".$title."</a></li>" :
        "<li><a href=".$link.">".$title."</a></li>";
}
?>
