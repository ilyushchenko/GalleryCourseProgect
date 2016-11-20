<?php
session_start();
require_once 'DB.php';

class Auth
{
    static function isAuthorized()
    {
        return isset($_SESSION['Userid']);
    }

    static function logout()
    {

        if(Auth::isAuthorized()) {
            unset($_SESSION['Userid']);
            session_destroy();
        }
    }

    static function authorize($login, $password)
    {
        $db = new DB();
        $query ="SELECT * FROM users WHERE login = '$login'";
        if($db->Querry($query)) {
            $result = $db->AssocQuerry();
            if(count($result) > 0) {
                $hashedPassword = md5($password);
                if($hashedPassword == $result[0]['Password']) {
                    $_SESSION['Userid'] = $result[0]['ID'];
                    return true;
                }
                else {
                    return "Введен неверный пароль!";
                }
            }
            else {
                return "Данный пользователь не найден";
            }
        }
        return "Ошибка при входе!";

    }

    function registration($login, $password, $confirmPassword, $email)
    {
        $db = new DB();
        $querry = "SELECT Login FROM users WHERE Login = '$login'";
        if ($db->Querry($querry))
        {
            $result = $db->AssocQuerry();
            if(count($result) > 0) {
                return "Пользователь с таким логином или email зарегестрирован!";
            }
            else {
                $hashedPassword = md5($password);
                $querry = "INSERT INTO users (Email, Login, Password, LastAuth, Token) VALUES ('$email', '$login', '$hashedPassword', NOW(), '$password')";
                if ($db->Querry($querry)) {
                    return true;
                }
            }
        }
        return false;
    }


    static function getUserID()
    {
        return (Auth::isAuthorized()) ? $_SESSION['Userid'] : 0;
    }
}