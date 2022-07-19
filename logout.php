<?php
session_start();
$_SESSION['user'] = array(
    'id' => '',
    'login' => '',
    'password' => '',
    'access' => '',
);
header("Location: login.php");
?>