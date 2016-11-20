<?
require_once './classes/DB.php';
$db = new DB();
$query = "SELECT * FROM photos";
$result = $db->getQuerry($query);

if(!$result) { echo "Произошла ошибка подключения к серверу и БД, проверьте параметры полключения"; }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Галерея</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div class="main">
<center><a href="upload.php" class="nav">Вернуться к загрузчику</a></center>
<?
// Если количество записей больше нуля
if (mysqli_num_rows($result) > 0)
{
	// Записываем полученные данные в массив
	$myrow = mysqli_fetch_array ($result);
	// В цикле выводи изображения на страницу
	do {
  		echo "<img src='".$myrow['Catalog'].$myrow['Filename']."' />";
	} 
	while ($myrow = mysqli_fetch_array($result));
}
else
{
	// Собщение о пустой таблице
	echo "<p>Информация по запросу не может быть извлечена, в таблице нет записей.</p>";
	exit();
}
?>
</div>
</body>
</html>