<?php
session_start();

if(!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0){
    header('Location: 404.php');
}

include_once "database/database.php";
include_once "utils/utils.php";
DeleteUser(test_input($_GET['id']));
header('Location: admin.php');
?>

