<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=c291470u_double', 'root', '');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE login= :login AND password= :password');
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':password', $password);
    $data = $stmt->execute();
    $data = $stmt->fetch();
    if ($data['id'] == NULL) {
        echo "<label id='error'>Логин или пароль введен неправильно</label>";
    }else {
            $_SESSION['user'] = array(
                'id' => $data['id'],
                'login' => $data['login'],
                'password' => $data['password'],
                'access' => $data['access'],
            );
            header("Location: /");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        justify-content: flex-end;
    }
    .form__items label {
        flex: 1;
        padding-right: 5px;
    }
    .form__items input[type=text] + input[type=password] {
        flex: 2;
    }
    .form__items input[type=submit] {
        margin: 0 auto;
        margin-top: 10px;
        width: 100px;
        height: 45px;
        color: white;
        background-color: #2ecc71;
        border: none;
        border-radius: 4px;
        border-bottom: solid 6px #27ae60;
        cursor: pointer;
        
    }
  #error {
    color: red;
    margin-bottom: 5px;
    display: flex;
    justify-content: center;
  }
</style>
<body>
    <form class="form__container" action="login.php" method="POST">
        <div class="form__row">
          <div class="form__items">
        <label id="error"></label>
        </div>
        <div class="form__items">
        <label for="login">Логин</label>
        <input id="login" type="text" name="login">
        </div>
        <div class="form__items">
        <label for="password">Пароль</label>
        <input id="password" type="password" name="password">
        </div>
        <div class="form__items">
        <input type="submit" value="Войти" name="submit">
        </div>
        </div>

        
    </form>
</body>
</html>