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
    header("Location: ../../login.php");
}else {
        $_SESSION['user'] = array(
            'id' => $data['id'],
            'login' => $data['login'],
            'password' => $data['password'],
            'access' => $data['access'],
        );
}
if ($data['access'] == "user") {
header("Location: ../../");
}
$access = "user";
if (isset($_POST['submit'])) {
$login = $_POST['login'];
$password = $_POST['password'];
$stmt=$pdo->prepare("INSERT INTO users (login, password, access) VALUES (:login, :password, :access)");
$stmt->bindParam(':login', $login);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':access', $access);
$stmt->execute();
header("Refresh:0; url=management.php");
}
$stmt = $pdo->query('SELECT * FROM users');
$data = $stmt->fetchAll();

if (isset($_GET['del'])) {
    $sql = "SELECT * FROM users WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_GET['del']));
    $fl = $stmt->fetch();
    if ($fl == false) {

    }else {
    $sql = "DELETE FROM users WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['del']);
    $stmt->execute();
    header("Refresh:0; url=management.php");
    }
}

if (isset($_GET['access'])) {
    $sql = "SELECT * FROM users WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_GET['access']));
    $fl = $stmt->fetch();
    if ($fl['access'] == "user") {
        $access = "admin";
    }else {
        $access = "user";
    }
    $sql = "UPDATE users SET access= :access WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['access']);
    $stmt->bindParam(':access', $access);
    $stmt->execute();
    header("Refresh:0; url=management.php");

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management</title>
</head>
<style>
    #upload__file {
        display: none;
    }
    .form__pdf {
        width: 60%;
        margin: 0 auto;
        border: solid 1px;
    }
    .nav__pdf {
        display: flex;
        justify-content: space-between;
    }
    .files__pdf {
        width: 60%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }
    .files__pdf__items {
        display: flex;
        justify-content: space-between;
    }
    .files__pdf__right {
        display: flex;
        justify-content: flex-end;
          width: 195px;
    }
  label{
    min-width: 100px;
  }
  .files__pdf__right a{
    width: 100px;
  }
</style>
<body>
<a href="../admin">Назад</a>
<form class="form__pdf" action="management.php" method="post">
<div class="nav__pdf">
<div class="nav__pdf__items">
<label for="upload__file">Логин</label>
<input type="text" name="login"/>
</div>
<div class="nav__pdf__items">
<label for="upload__file">Пароль</label>
<input type="text" name="password"/>
</div>
<div class="nav__pdf__items">
<input type="submit" name="submit" value="Зарегистрировать">
</div>
</div>
</form>
<?php
$count = count($data);
echo "<div class='files__pdf'>";
for ($i=0; $i < $count; $i++) { 
    if ($data[$i]['access'] == "user") {
        $hid = "Пользователь";
    }else {
        $hid = "Админ";
    }
    echo "<div class='files__pdf__items'><label>".$data[$i]['login']."</label>"."<label>".$data[$i]['password']."</label>"."<div class='files__pdf__right'>"."<a href='?del=".$data[$i]['id']."'>Удалить</a>"."<a href='?access=".$data[$i]['id']."'>".$hid."</a></a>"."</div></div>";
}
echo "</div>";
?>
</body>

</html>