<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: 404.php');
}

include_once "database/database.php";
include_once "utils/utils.php";
DeleteMessage(test_input($_GET['id']));

header('Location: view.php');
?>
