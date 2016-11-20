<?php
session_start();
require_once 'DB.php';

class Auth
{
    static function isAuthorized()
    {
        return isset($_SESSION['userid']);
    }

    static function logout()
    {

        if(Auth::isAuthorized())
        {
            unset($_SESSION['userid']);
            session_destroy();
        }
    }

    static function authorize($login, $password)
    {
        $db = new DB();
        $query ="SELECT * FROM users WHERE login = '$login'";
        $result = $db->getQuerry($query);
        if(mysqli_num_rows($result) > 0)
        {
            $userInfo = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            $hashedPassword = md5($password);
            if($hashedPassword == $userInfo['password'])
            {
                $_SESSION['userid'] = $userInfo['ID'];
                return true;
            }
            else
            {
                return "Введен неверный пароль!";
            }
        }
        else
        {
            return "Данный пользователь не найден";
        }
    }

    function registration($login, $password, $confirmPassword, $email)
    {
        $db = new DB();
        $querry = "SELECT login FROM users WHERE login = '$login'";
        $result = $db->getQuerry($querry);
        if(mysqli_num_rows($result) > 0)
        {
            //$userInfo = mysqli_fetch_assoc($result);

            //while ($row = mysqli_fetch_assoc($result)) {
            //    echo "<img src='".$row['catalog'].$row['filename']."' />";
            //}

            mysqli_free_result($result);
            return "Пользователь с таким логином или email зарегестрирован!";
        }
        else
        {
            $hashedPassword = md5($password);
            $querry = "INSERT INTO users (email, login, password, lastAuth, token) VALUES ('$email', '$login', '$hashedPassword', NOW(), '$password')";
            $db->getQuerry($querry);
            return true;

        }
        return false;
    }


    static function getUserID()
    {
        return (Auth::isAuthorized()) ? $_SESSION['userid'] : 0;
    }
}