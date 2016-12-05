<?php
require_once "classes/Auth.php";
require_once "views/Head.View.php";
require_once "views/Header.View.php";
if (!Auth::isAuthorized()) header("Location: login.php");


?>
<!doctype html>
<html lang="en">
<? GetHead("Профиль пользователя") ?>
<body>
<div class="container">
    <? GetHeader() ?>
</div>

</body>
</html>
