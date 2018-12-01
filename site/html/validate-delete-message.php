<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

include_once "database/database.php";
DeleteMessage($_GET['id']);

header('Location: view.php');
?>
