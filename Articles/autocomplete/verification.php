<?php

include '../DataSet/db.php';

$ref = $_POST['ref'];
// Check username
$query = "select count(*) as Cmp from articles where reference='".$ref."'";

$result = $pdo->query($query);

$row = $result->fetch(PDO::FETCH_ASSOC);

$count = $row['Cmp'];

echo $count;