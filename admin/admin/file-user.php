<?php 
	require 'db.php';
?>
 <link href="folders/style/style.css" rel="stylesheet">
<?php if ( isset ($_SESSION['logged_user']) ) : ?>
<?php

/*
 * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
 */

require_once 'config/connect.php';
?>

<?php
$pdo = new PDO('mysql:host=localhost;dbname=c291470u_double', 'c291470u_double', 'FhHhbqi8');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$stmt = $pdo->query('SELECT * FROM pdf WHERE hide="false"');
$data = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
</head>
<style>
    #upload__file {
        display: none;
    }
    .form__pdf {
        margin: 0 auto;
        border: solid 1px;
    }
    .nav__pdf {
        display: flex;
        justify-content: space-between;
    }
    .files__pdf {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }
    .files__pdf__items {
        display: flex;
        justify-content: space-between;
    }
</style>
<body>
<?php
$count = count($data);
echo "<div class='files__pdf'>";
for ($i=0; $i < $count; $i++) { 
    echo "<div class='files__pdf__items'><label>".$data[$i]['name']."</label>"."<a href='".$data[$i]['file']."' download>Скачать</a></a>"."</div>";
}
echo "</div>";
?>
</body>
</html>
<a href="/">Главная</a>
</body>
</html>
<?php else : ?>
Вы не авторизованы<br/>
<a href="/login.php">Авторизация</a>
<?php endif; ?>

