<?php
    $host = "localhost";  
    $username = "root";  
    $password = "";  
    $database = "gestion";
    try{
        $pdo = new PDO("mysql:host=$host;dbname=$database","$username","$password",array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }catch(PDOException $e){
            $e->getmessage();
        }
?>