<?
require_once './classes/Auth.php';
require_once './classes/DB.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<div class="container">

<?php
    include 'html/header.php';
    $db = new DB();
    $query = "SELECT * FROM users";

    echo "<table class='table'><tr><th>ID</th><th>Email</th><th>Login</th><th>Password</th><th>Last Auth</th><th>Token</th></tr>";


    if ($db->Querry($query)) {
        $result = $db->AssocQuerry();
        foreach ($result as $row) {
            echo "<tr><td>".$row["ID"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["login"]."</td>";
            echo "<td>".$row["password"]."</td>";
            echo "<td>".$row["lastAuth"]."</td>";
            echo "<td>".$row["token"]."</td></tr>";
        }
    }
    echo "</table>";
?>
</div>
</body>
</html>