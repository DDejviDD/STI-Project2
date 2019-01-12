<?php

include 'database/database.php';
include 'utils/utils.php';
session_start();

if(!empty($_POST)){
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    echo $username;
    echo $password;
    if(isset($username) and isset($password)){

        if(isUserValid($username,sha1($password))){
            $_SESSION['CSRF']=base64_encode(openssl_random_pseudo_bytes(32));
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


