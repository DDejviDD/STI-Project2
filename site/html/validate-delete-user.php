<?php
session_start();

if(!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0){
    header('Location: 404.php');
}

include_once "database/database.php";
DeleteUser($_GET['id']);
header('Location: admin.php');
?>

