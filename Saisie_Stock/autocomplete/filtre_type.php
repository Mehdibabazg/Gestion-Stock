<?php
include '../../DataSet/db.php';

$type = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT DISTINCT type FROM stock WHERE type LIKE '%".$type."%' ORDER BY type ASC LIMIT 5";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['type'];
}

echo json_encode($data);



/*if (isset($_POST['query'])) {
    $inpText = $_POST['query'];
    $sql = 'SELECT DISTINCT type FROM stock WHERE type LIKE :reference';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['reference' => '%' . $inpText . '%']);
    $result = $stmt->fetchAll();

    if ($result) {
      foreach ($result as $row) {
        echo '<a href="#" class="list-group-item list-group-item-action border-1">' . $row['type'] . '</a>';
      }
    } else {
    
    }
  }

*/
?>