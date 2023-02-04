<?php 

include "../DataSet/db.php";

function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
$filename = "Caisse_" . date('Y-m-d') . ".xls";

$path = "../Files/Caisse/";

$fields = array('DATE', 'OBJET', 'NATURE', 'MONTANT');

$excelData = implode("\t", array_values($fields)) . "\n"; 

$query = $pdo->query("SELECT * FROM caisse ORDER BY id ASC"); 

if($query->rowCount() > 0){
    while($row = $query->FETCH(PDO::FETCH_ASSOC)){  
        $lineData = array($row['date'], $row['objet'], $row['nature'], $row['montant']); 
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}else{
    $excelData .= 'Aucun enregistrement trouvé...'. "\n";
}

file_put_contents($path . $filename, $excelData);
echo "<script>
        window.open('../Files/Caisse/Caisse_" . date('Y-m-d') . ".xls');
        window.location.href='Caisse.php';
        </script>";

?>