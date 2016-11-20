<?php
require_once './classes/Auth.php';
if(!Auth::isAuthorized()) header("Location: login.php");
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 18.11.16
 * Time: 1:51
 */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
    <? include "html/header.php"; ?>
</body>
</html>
