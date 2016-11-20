<?
require_once '/classes/Auth.php';
require_once '/classes/DB.php';
require_once "/html/Head.View.php";
require_once "/html/Header.View.php";
?>
<!DOCTYPE html>
<html>
<? GetHead("Главнвя")?>
<body>
<div class="container">
<?php
    GetHeader();
    $db = new DB();
    $query = "SELECT * FROM users";
    echo "<table class='table'><tr><th>ID</th><th>Email</th><th>Login</th><th>Password</th><th>Last Auth</th><th>Token</th></tr>";
    if ($db->Querry($query)) {
        $result = $db->AssocQuerry();
        foreach ($result as $row) {
            echo "<tr><td>".$row["ID"]."</td>";
            echo "<td>".$row["Email"]."</td>";
            echo "<td>".$row["Login"]."</td>";
            echo "<td>".$row["Password"]."</td>";
            echo "<td>".$row["LastAuth"]."</td>";
            echo "<td>".$row["Token"]."</td></tr>";
        }
    }
    echo "</table>";
?>
</div>
</body>
</html>