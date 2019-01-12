<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

if( isset($_SESSION['CSRF']) and isset($_POST['CSRF']) and $_SESSION['CSRF'] == $_POST['CSRF'] and isset($_POST['idToDelete'])){
    include_once "database/database.php";
    include_once "utils/utils.php";
    DeleteMessage(test_input($_POST['idToDelete']));

}

header('Location: view.php');
?>
