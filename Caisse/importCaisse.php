<?php

//import.php

include '../vendor/autoload.php';

include "../DataSet/db.php";

if($_FILES["import_excel"]["name"] != '')
{
 $allowed_extension = array('xls', 'csv', 'xlsx');
 $file_array = explode(".", $_FILES["import_excel"]["name"]);
 $file_extension = end($file_array);

 if(in_array($file_extension, $allowed_extension))
 {
  $file_name = time() . '.' . $file_extension;
  move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
  $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

  $spreadsheet = $reader->load($file_name);

  unlink($file_name);

  $sheetdata = $spreadsheet->getActiveSheet()->toArray();
  $sheetcount = count($sheetdata);
  if ($sheetcount > 1) {
    for($i=1;  $i < $sheetcount; $i++)
    {
      $date = join('-', array_reverse(explode('/', trim($sheetdata[$i][0]))));
      $objet = $sheetdata[$i][1];
      $nature = $sheetdata[$i][2];
      if ($sheetdata[$i][2] == 'Recette') {
        $montant = $sheetdata[$i][4];
      }else {
        $montant = $sheetdata[$i][3];
      }

     $query = "INSERT INTO Caisse 
     (date, objet, nature, montant) 
     VALUES ('$date', '$objet', '$nature', '$montant')";
     $statement = $pdo->query($query);
    }
  }

  
  $message = 'Données importées avec succès';

 }
 else
 {
  $message = 'Seuls les fichiers .xls .csv ou .xlsx sont autorisés';
 }
}
else
{
 $message = 'Veuillez sélectionner un fichier';
}

echo $message;

?>