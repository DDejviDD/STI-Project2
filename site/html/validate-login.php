<?php

include 'database/database.php';

session_start();

if(!empty($_POST)){
    
    if(isset($_POST['username']) and isset($_POST['password'])){

        if(isUserValid($_POST['username'],sha1($_POST['password']))){
            $_SESSION['username'] = $_POST['username'];
            if(isAdmin($_POST['username'])){
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


