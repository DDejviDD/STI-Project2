<?php

// Set default timezone
date_default_timezone_set('UTC');
include_once "../utils/utils.php";

/****************************************
 * Create database and tables           *
 ****************************************/
function CreateTables()
{
    try {

        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $file_db->exec("PRAGMA foreign_keys = ON");

        // Create table users
        $file_db->exec("CREATE TABLE IF NOT EXISTS users (
                    login TEXT PRIMARY KEY, 
                    password TEXT, 
                    valid INTEGER, 
                    role TEXT);");

        // Create table messages
        $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
                    id INTEGER PRIMARY KEY, 
                    title TEXT, 
                    message TEXT, 
                    time TEXT);");

        $file_db->exec("CREATE TABLE IF NOT EXISTS messageSent (
                    sender TEXT, 
                    receiver TEXT,
                    idMessage INTEGER,
                    FOREIGN KEY (sender) REFERENCES users(login) ON DELETE CASCADE,
                    FOREIGN KEY (receiver) REFERENCES users(login) ON DELETE CASCADE,
                    FOREIGN KEY (idMessage) REFERENCES message(time) ON DELETE CASCADE);");

        // Close file db connection
        $file_db = null;

    } catch (PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
    }
}

function ListMessage($user)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare("SELECT * FROM  messages INNER JOIN messageSent ON messages.id = messageSent.idMessage
        WHERE messageSent.receiver LIKE :userId  ORDER BY messages.time DESC ;");

        $stmt->execute(array('userId'=>$id));

        return $stmt->fetchAll();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function ListUser()
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $result = $file_db->query("SELECT login, valid, role FROM users");

        return $result;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function GetUserInfo($login)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $file_db->prepare("SELECT login, valid, role, password FROM users WHERE login LIKE :userId'");
        $stmt->execute(array('userId'=>$id));

        return $stmt->fetchAll();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function SendMessage($from, $to, $title, $message, $time)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $formatted_time = date('Y-m-d H:i:s', $time);

        $result = $file_db->query("SELECT max(id) FROM messages;");

        foreach ($result as $row){
            $id= $row['max(id)'] + 1;
        }

        $file_db->exec();

        $stmt = $file_db->prepare("INSERT INTO messages (id, title, message, time) VALUES (:userId,:title, :mess, :tim)");
        $stmt->execute(array('userId'=>$id, 'title'=>$title, 'mess'=>$message, 'tim'=>$formatted_time));

        $stmt = $file_db->prepare("INSERT INTO messageSent (sender, receiver, idMessage) VALUES (:fro, :t, :userId)");
        $stmt->execute(array('fro'=>$from, 't'=>$to,'userId'=>$id));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function DeleteMessage($id)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare("DELETE FROM messages WHERE id = :userId");
        $stmt->execute(array('userId'=>$id));
        $stmt = $file_db->prepare("DELETE FROM messageSent WHERE idMessage = :userId");
        $stmt->execute(array('userId'=>$id));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function ChangePassword($user, $newPassword)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        //$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare('UPDATE users SET password = :newPassword WHERE login = :userId');
        $stmt->execute(array('newPassword'=>$newPassword,'userId'=>$user));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}


function AddUser($login, $password, $valid, $role)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare("INSERT INTO users (login, password, valid, role) VALUES (:userId, :pass, :newValid, :newRole);");
        $stmt->execute(array('userId'=>$login, 'pass'=>$password,'newValid'=>$valid,'newRole'=>$role));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function EditUser($login, $valid, $role)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare('UPDATE users SET valid = :newValid, role = :newRole WHERE login = :userId');
        $stmt->execute(array('newValid'=>$valid,'newRole'=>$role, 'userId'=>$login));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function DeleteUser($login)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare('DELETE FROM users WHERE login = :username');
        $stmt->execute(array('username'=>$login));


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function isUserValid($login, $password)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $file_db->prepare('SELECT * FROM users WHERE login = :username AND password = :password AND valid = 1');
        $stmt->execute(array('username'=>$login, 'password'=>$password));
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if($row['login'] == test_input($login)){
                return true;
            }
        }

        return false;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function isAdmin($login)
{
    try {
        // Create (connect to) SQLite database in file
        $file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $result = $file_db->query("SELECT * FROM users 
                                             WHERE role == '0' AND valid == '1';");
                                             
        foreach ($result as $row) {
            if($row['login'] == test_input($login)){
                return true;
            }
        }

        return false;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
