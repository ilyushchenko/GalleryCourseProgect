<?php
require_once "classes/Auth.php";
require_once "views/Head.View.php";
require_once "views/Header.View.php";
if(Auth::isAuthorized()) header("Location: index.php");
if (isset($_GET['logout'])) {
    if(Auth::isAuthorized()) Auth::logout();
    header("Location: index.php");
}
if (isset($_POST["log"]))
{
    if (isset($_POST["login"]) && isset($_POST["password"])) {
        $login = $_POST["login"];
        $password = $_POST["password"];
        $authResult = Auth::authorize($login, $password);
        if($authResult == 1) {
            header("Location: index.php");
        }
        else {
            echo $authResult;
        }
    }
}
if (isset($_POST["reg"]))
{
    if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])&& isset($_POST["email"])) {
        $login = $_POST["login"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $email = $_POST["email"];
        $auth = new Auth();
        $regres = $auth->registration($login, $password, $confirmPassword, $email);
        if($regres == 1) {
            $authResult = Auth::authorize($login, $password);
            if($authResult == 1) {
                header("Location: index.php");
            }
            else {
                echo $authResult;
            }
        }
        else echo "Ошибка при регистрации";
    }
}
?>
<!doctype html>
<html lang="ru">
<? GetHead("Авторизация")?>
<body>
    <div class="container">
        <? GetHeader() ?>
        <div class="row">
            <div class="col-xs-6">
                <div class="col-xs-5 col-xs-offset-2">
                    <div class="row">
                        <h3>Войти</h3>
                    </div>
                    <div class="row form-group">
                        <form action="login.php" method="post" role="form">
                            <label for="authLogin">Логин</label>
                            <input class="form-control" type="text" name="login" id="authLogin">
                            <label for="authPassword">Пароль</label>
                            <input class="form-control" type="password" name="password" id="authPassword">
                            <button class="btn btn-default" type="submit" name="log">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="col-xs-5 col-xs-offset-2">
                    <div class="row">
                        <h3>Зарегестрироваться</h3>
                    </div>
                    <div class="row form-group">
                        <form action="login.php" method="post" role="form">
                            <label for="regLogin">Логин</label>
                            <input class="form-control" type="text" name="login" id="regLogin">
                            <label for="regPassword">Пароль</label>
                            <input class="form-control" type="password" name="password" id="regPassword">
                            <label for="regConfirmPassword">Повтор пароля</label>
                            <input class="form-control" type="password" name="confirmPassword" id="regConfirmPassword">
                            <label for="regEmail">Email</label>
                            <input class="form-control" type="email" name="email" id="regEmail">
                            <button class="btn btn-default" type="submit" name="reg">Зарегестрироваться</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
