<?php
$host = 'localhost'; // имя хоста
$user = 'root'; // имя пользователя
$pass = 'root'; // пароль
$name = 'avito'; // имя базы данных
$link = mysqli_connect($host, $user, $pass, $name);

 
$query = "DROP TABLE avitotable";
$result=mysqli_multi_query($link, $query) or die(mysqli_error($link));
echo $result;
?>