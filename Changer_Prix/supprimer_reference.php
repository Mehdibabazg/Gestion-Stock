<?php
session_start();
$id = $_REQUEST['ref'];
require '../DataSet/db.php';

			$delete_ref="DELETE FROM reference WHERE reference = '$id'";
			$req = $pdo->prepare($delete_ref);
            $req->execute();
?>