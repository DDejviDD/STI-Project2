<?php
session_start();
if(!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0){
    header('Location: 404.php');
}
include_once "utils/utils.php";

$type = test_input($_GET['type']);
$login = test_input($_POST['login']);
$password = sha1(test_input($_POST['password']));
$privilege = test_input($_POST['userPrivileges']) - 1;
$isActive = test_input($_POST['isValid']);

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
