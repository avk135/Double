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
$stmt = $pdo->query('SELECT * FROM pdf WHERE hide="false" ORDER BY name ASC');
$data = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
      <link rel="shortcut icon" href="/admin/images/logo.png" type="image/png">
</head>
<style>
    #upload__file {
        display: none;
    }
    .form__pdf {
        width: 50%;
        margin: 0 auto;
        border: solid 1px;
    }
    .nav__pdf {
        display: flex;
        justify-content: space-between;
    }
    .files__pdf {
        width: 100%;
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
<a href="/">Главная</a>
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