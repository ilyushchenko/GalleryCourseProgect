<?php
require_once "classes/Auth.php";
require_once "views/Head.View.php";
require_once "views/Header.View.php";
require_once "models/Admin.Model.php";
if (!Auth::isAuthorized()) header("Location: login.php");
if (!Admin::IsAdmin()) header("Location: index.php");
?>
<!doctype html>
<html lang="ru">
<head>
    <? GetHead("Панель администратора") ?>
</head>
<body>
<div class="container">
    <? GetHeader(); ?>
</div>

<section id="querry">
    <div class="container">
        <h1>Выполнить запрос</h1>
        <form action="admin.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="selectText" class="col-sm-2 control-label">SELECT</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="selectText" name="selectText"
                           placeholder="Field1, Field2" required>
                </div>
            </div>
            <div class="form-group">
                <label for="fromText" class="col-sm-2 control-label">FROM</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fromText" name="fromText" placeholder="Table1, Table2" required>
                </div>
            </div>
            <div class="form-group">
                <label for="whereText" class="col-sm-2 control-label">WHERE</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="whereText" name="whereText" placeholder="Statement">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" name="querry" class="btn btn-warning">Выполнить запрос</button>
                </div>
            </div>
        </form>
        <?
        if (isset($_POST["querry"])) {
            echo "<table class='table'>";
            $result = Admin::GetQuerry($_POST["selectText"], $_POST["fromText"], $_POST["whereText"]);
            $first = true;
            foreach ($result as $key => $row) {
                if ($first) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<th>";
                        echo $key;
                        echo "</th>";
                    }
                    echo "</tr>";
                    $first = false;
                }
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>";
                    echo $value;
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</section>
<section id="users">
    <div class="container">
        <h1>Список пользователей</h1>
        <?php
        echo "<table class='table'><tr><th>ID</th><th>Email</th><th>Login</th><th>Password</th><th>Last Auth</th><th>Token</th></tr>";
        foreach (Admin::GetUsers() as $row) {
            echo "<tr><td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["Login"] . "</td>";
            echo "<td>" . $row["Password"] . "</td>";
            echo "<td>" . $row["LastAuth"] . "</td>";
            echo "<td>" . $row["Token"] . "</td></tr>";
        }
        ?>
    </div>
</section>

</body>
</html>
