<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=c291470u_double', 'root', '');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $login = $_SESSION['user']['login'];
    $password = $_SESSION['user']['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE login= :login AND password= :password');
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $data = $stmt->execute();
    $data = $stmt->fetch();
    if ($data['id'] == NULL) {
        $_SESSION['user'] = array(
            'id' => '',
            'login' => '',
            'password' => '',
            'access' => '',
        );
        header("Location: login.php");
    }else {
            $_SESSION['user'] = array(
                'id' => $data['id'],
                'login' => $data['login'],
                'password' => $data['password'],
                'access' => $data['access'],
            );
    }
if ($data['access'] == "admin") {
    header("Location: admin/");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="shortcut icon" href="/admin/images/logo.png" type="image/png">
</head>
<style>
    .form__container {
        display: flex;
        justify-content: center;
        margin: 0 auto;
    }
    .form__row {
        display: flex;
        flex-direction: column;
    }
    .form__items {
        display: flex;
        justify-content: center;
    }
    .form__items label {
        text-align: center;
        padding-right: 5px;
    }
    .form__items a {
        margin: 0 auto;
        margin-top: 10px;
        width: 100px;
        padding: 10px;
        margin-left: 7px;
        text-decoration: none;
        text-align: center;
        color: white;
        background-color: #2ecc71;
        border: none;
        border-radius: 4px;
        border-bottom: solid 6px #27ae60;
        cursor: pointer;
        
    }
</style>
<body>
    <form class="form__container" action="login.php" method="POST">
        <div class="form__row">
        <div class="form__items">
        <label for="login">Авторизован!</label>
        </div>
        <div class="form__items">
        <label for="password">Привет, <? echo $_SESSION['user']['login']; ?>!</label>
        </div>
        <div class="form__items">
        <a href="logout.php">Выйти</a>
        <a href="file-user.php">Вся музыка</a>
        </div>
        </div>

        
    </form>
</body>
</html>