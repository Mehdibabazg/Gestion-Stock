<?php
include "../DataSet/db.php";
$sql = "SELECT * FROM stock ORDER BY id DESC";
$result = $pdo->query($sql);
$data = array();
while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
$data[] = $rows;
}
$results = array(
    "sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data
    );
echo json_encode($results);
?>