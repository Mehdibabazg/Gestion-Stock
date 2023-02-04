<?php 
require_once('DataSet/db.php');
session_start();
    if(isset($_POST['submit']))
    {
        if(empty($_POST['Uname']) || empty($_POST['Password']))
        {
            header("location:index.php?Empty= Veuillez remplir tout les Champs !");
        }
        else
        {
            $query="select * from utilisateurs where username='".$_POST['Uname']."' collate utf8_bin and password='".md5($_POST['Password'])."'";
            $result=$pdo->query($query);
            $statement=$result->fetch(PDO::FETCH_ASSOC);
            if($statement)
            {
                $_SESSION['role']=$statement['role'];
                header("location:Acceuil\Acceuil.php");
            }
            else
            {
                header("location:index.php?Invalid= Nom utilisateur ou Mot de Passe Incorrect !");
            }
        }
    }
    else
    {
        echo 'Non Fonctionnel !';
    }

?>