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
$hide = "false";
if (isset($_POST['submit'])) {
if (empty($_FILES['file']['tmp_name'])) {

}else {
$uploaddir = '../../music/';
$file = $uploaddir . basename($_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'], $file);
$stmt=$pdo->prepare("INSERT INTO pdf (name, file, hide) VALUES (:name, :file, :hide)");
$stmt->bindParam(':name', $_FILES['file']['name']);
$stmt->bindParam(':file', $file);
$stmt->bindParam(':hide', $hide);
$stmt->execute();
}}
$stmt = $pdo->query('SELECT * FROM pdf ORDER BY name ASC');
$data = $stmt->fetchAll();

if (isset($_GET['del'])) {
    $sql = "SELECT * FROM pdf WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_GET['del']));
    $fl = $stmt->fetch();
    if ($fl == false) {

    }else {
    unlink($fl['file']);
    $sql = "DELETE FROM pdf WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['del']);
    $stmt->execute();
    header("Refresh:0; url=index.php");
    }
}

if (isset($_GET['hide'])) {
    $sql = "SELECT * FROM pdf WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_GET['hide']));
    $fl = $stmt->fetch();
    if ($fl['hide'] == "false") {
        $hide = "true";
    }else {
        $hide = "false";
    }
    $sql = "UPDATE pdf SET hide= :hide WHERE id= :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['hide']);
    $stmt->bindParam(':hide', $hide);
    $stmt->execute();
    header("Refresh:0; url=index.php");

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>PDF</title>
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
        width: 50%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }
    .files__pdf__items {
        display: flex;
        justify-content: space-between;
    }

  .files__pdf__right a{
    margin-left: 10px;

  }
  .frame {
    position: fixed;
    left: 50%;
    top: 30px;
    transform: translate(-50%);
    display: none;
  }
  .frame__active {
    display: block;
  }
.close {
    position: absolute;
    right: -40px;
    top: -10px;
    width: 32px;
    height: 32px;
    opacity: 1;
    cursor: pointer;
}
.close:before, .close:after {
position: absolute;
left: 15px;
content: ' ';
height: 33px;
width: 2px;
background-color: #333;
}
.close:before {
transform: rotate(45deg);
}
.close:after {
transform: rotate(-45deg);
}
</style>
<body>
<div id="frame" class="frame">
  <span class="close" onclick="document.getElementById('frame').classList.remove('frame__active')"></span>
  <iframe class="iframe" src="" style="width:500px; height:500px;" frameborder="0"></iframe>
</div>
<a href="../">Назад</a>
<form class="form__pdf" action="index.php" method="post" enctype="multipart/form-data">
<div class="nav__pdf">
<div class="nav__pdf__items">
    <input type="text" placeholder="Поиск" oninput="search(this.value)">
</div>
<div class="nav__pdf__items">
<label for="upload__file">Добавить файл</label>
<input type="file" name="file" id="upload__file" />
</div>
<div class="nav__pdf__items">
<input type="submit" name="submit" value="Загрузить">
</div>
</div>
</form>
<?php
$count = count($data);
echo "<div class='files__pdf'>";
for ($i=0; $i < $count; $i++) { 
    if ($data[$i]['hide'] == "false") {
        $hid = "Не скрыто";
    }else {
        $hid = "Скрыто";
    }
    if (preg_match('/\.pdf/', $data[$i]['file'])) {
      $fun = $data[$i]['file'] = preg_replace('/\.\.\/\.\.\//', '', $data[$i]['file']);
      $pdf = "<label style='color: blue; cursor: pointer;' onclick='frame(\"".$fun."\")'>".$data[$i]['name']."</label>";
    }else {
      $pdf = "<label>".$data[$i]['name']."</label>";
    }
    echo "<div class='files__pdf__items'><label>".$pdf."</label>"."<div class='files__pdf__right'>"."<input type='text' value='".$data[$i]['name']."' oninput='change(this.value, ".$data[$i]['id'].")'>"."<a href='?del=".$data[$i]['id']."'>Удалить</a>"."<a href='?hide=".$data[$i]['id']."'>".$hid."</a></a>"."</div></div>";
}
echo "</div>";
?>
<script>
    function search(value){
  $.post("search.php", {search:value}, function(data){
    $(".files__pdf").html(data);
  });
}

function change(name, id){
  $.post("name.php", {id:id,name:name}, function(data){
    console.log('OK');
  });
}
function frame(url){
  var frame = document.querySelector(".frame");
  var iframe = document.querySelector(".iframe");
  frame.classList.add("frame__active");
  iframe.src = "https://docs.google.com/viewer?url=http://cq33910.tmweb.ru/"+url+"&embedded=true";
  iframe.src = "https://docs.google.com/viewer?url=http://cq33910.tmweb.ru/"+url+"&embedded=true";
  iframe.src = "https://docs.google.com/viewer?url=http://cq33910.tmweb.ru/"+url+"&embedded=true";
  
}
  function close(){
    var frame = document.getElementById("frame");
    frame.classList.remove("frame__active");
    
}
</script>
</body>

</html>