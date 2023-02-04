<?php
session_start();
$id = $_REQUEST['id'];
require '../DataSet/db.php';

			$delete_client="DELETE FROM client WHERE id = $id";
			$req = $pdo->prepare($delete_client);
            $req->execute();
?>