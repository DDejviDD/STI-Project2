<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

include_once "database/database.php";
include_once "utils/utils.php";
SendMessage($_SESSION['username'], test_input($_POST['to']), test_input($_POST['subject']), test_input($_POST['content']), time());

header('Location: view.php');
?>
