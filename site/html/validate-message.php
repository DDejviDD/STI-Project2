<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

include_once "database/database.php";
SendMessage($_SESSION['username'], $_POST['to'], $_POST['subject'], $_POST['content'], time());

header('Location: view.php');
?>
