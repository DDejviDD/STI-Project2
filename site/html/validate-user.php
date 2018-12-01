<?php
session_start();
if(!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0){
    header('Location: 404.php');
}
print_r($_POST);
$type = $_GET['type'];
$login = $_POST['login'];
$password = sha1($_POST['password']);
$privilege = $_POST['userPrivileges'] - 1;
$isActive = $_POST['isValid'];

include_once "database/database.php";

if($type == "Add"){
    AddUser($login, $password, $isActive, $privilege);
}
if ($type == "Edit"){
    EditUser($login, $isActive, $privilege);
}
if ($type == "Password"){
 ChangePassword($login, $password);
}
header('Location: admin.php');
?>
