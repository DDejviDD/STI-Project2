<?php
session_start();

if(!isset($_SESSION['user_id']) or $_SESSION['user_id'] != 0){
    header('Location: 404.php');
}

if( isset($_SESSION['CSRF']) and isset($_POST['CSRF']) and $_SESSION['CSRF'] == $_POST['CSRF'] and isset($_POST['idToDelete'])){
    include_once "database/database.php";
    include_once "utils/utils.php";
    DeleteUser(test_input($_POST['idToDelete']));
}
header('Location: admin.php');
?>

