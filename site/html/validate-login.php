<?php

include 'database/database.php';
session_start();

if(!empty($_POST)){

    include_once "utils/utils.php";

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    
    if(isset($username) and isset()){

        if(isUserValid($username,sha1($password))){
            $_SESSION['username'] = $username;
            if(isAdmin($username)){
                $_SESSION['user_id'] = 0;
                header('Location: admin.php');
            }else{
                $_SESSION['user_id'] = 1;
                header('Location: view.php');
            }
        }
    }
}
header('Location: index.php');
?>


