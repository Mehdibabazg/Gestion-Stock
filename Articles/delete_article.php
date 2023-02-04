<?php
session_start();
$id = $_REQUEST['id'];
require '../DataSet/db.php';

			$delete_article="DELETE FROM articles WHERE id = $id";
			$req = $pdo->prepare($delete_article);
            $req->execute();