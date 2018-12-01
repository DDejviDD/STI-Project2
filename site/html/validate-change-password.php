<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

include_once "database/database.php";
ChangePassword($_SESSION['username'], sha1($_POST['newPassword']));
if(($_SESSION['user_id']) == 0) {
    header('Location: admin.php');
} else {header('Location: view.php');}
?>