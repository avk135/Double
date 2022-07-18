<?php
$pdo = new PDO('mysql:host=localhost;dbname=c291470u_double', 'root', '');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$id = $_POST['id'];
$name = $_POST['name'];
$sql = "UPDATE pdf SET name= :name WHERE id= :id";
$stmt= $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);
$stmt->execute();
?>