<?php

require "fpdf.php";

  $tableData = stripcslashes($_POST['pTableData']);
  $tableData = json_decode($tableData,TRUE);
  $count = count($tableData);
  $societe = $_POST['societe'];
  $id_client = $_POST['id_client'];
  $num_devis = $_POST['num_devis'];
  $mt_total = $_POST['total']/1.2;
  $date = date("Y-m-d");
include "../DataSet/db.php";
$devis = $pdo->query("INSERT INTO devis (num_devis, id_client, date_devis) VALUES 
                        ('$num_devis', '$id_client', '$date')");
for ($i=0; $i < $count; $i++) { 
    $ref = $tableData[$i]['reference'];
    $type = $tableData[$i]['type'];
    $qte = $tableData[$i]['qte'];
    $prix = $tableData[$i]['prix'];
    $create_devis = $pdo->query("INSERT INTO devis_details (num_devis, reference, type, quantite, prix_ttc) VALUES 
                                ('$num_devis', '$ref', '$type', '$qte', '$prix')");
}
$devis_info = $pdo-> query("SELECT * FROM devis_details WHERE num_devis = '$num_devis'");
class myPDF extends FPDF{

    function header(){
        $this->image('massartech.png', 65, 8, 0,12);
        $this->SetFont('Times','',11);
        $this->Cell(0,30,utf8_decode("Caméra de Surveillance et Système d'Alarme, Domotique"),0,0,'C');
        $this->Ln(4);
        $this->SetFont('Times','',11);
        $this->Cell(0,35,utf8_decode('Vente et Maintenance de Matériel Informatique, Réseau Informatique, Accessoires et Consommables'),0,0,'C');
        $this->Ln(30);
    }
    function footer(){
        $this->SetY(-25); 
        $this->SetFont('Arial','',9);
        $this->Cell(0,10,'985 Quartier Industriel Almassar Route de Safi, Marrakech',0,0,'C');
        $this->Ln(4);
        $this->Cell(0,10,utf8_decode('Tél.: 05 24 33 56 05, Mobile: 06 61 34 40 79 / 06 00 60 54 44, Email : massartek@gmail.com'),0,0,'C');
        $this->Ln(4);
        $this->Cell(0,10,'R.C. : 65051 - CNSS : 4221785 - Patente : 67395832 - I. Fiscal : 15201282 - ICE :001563802000088',0,0,'C');
    }
    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(20,6,utf8_decode('Quantité'),1,0,'C');
        $this->Cell(75,6,utf8_decode('Référence'),1,0,'C');
        $this->Cell(45,6,utf8_decode('Type'),1,0,'C');
        $this->Cell(25,6,'Prix',1,0,'C');
        $this->Cell(25,6,'Total',1,0,'C');
        $this->Ln(6);
    }
    function viewTable($devis_info, $mt_total){
        
        while($data=$devis_info->fetch(PDO::FETCH_OBJ)){
            $this->SetFont('Times','',11);
            $this->Cell(20,6,$data->quantite,1,0,'C');
            $this->Cell(75,6,$data->reference,1,0,'C');
            $this->Cell(45,6,$data->type,1,0,'C');
            $this->SetFont('Times','B',11);
            $this->Cell(25,6,number_format($data->prix_ttc/1.2,2,',',''),1,0,'R');
            $this->Cell(25,6,number_format($data->quantite*$data->prix_ttc/1.2, 2,',',' '),1,0,'R');
            $this->Ln();
        }
        
            $this->Cell(140,7,'',0,0,'L');
            $this->Cell(25,7,'Total HT',1,0,'C');
            $this->Cell(25,7,number_format($mt_total,2,',',''),1,0,'R');
            $this->Ln();
            $this->Cell(140,7,'',0,0,'L');
            $this->Cell(25,7,'TVA',1,0,'C');
            $this->Cell(25,7,number_format($_POST['total']-$_POST['total']/1.2, 2,',',' '),1,0,'R');
            $this->Ln();
            $this->Cell(140,7,'',0,0,'L');
            $this->Cell(25,7,'Total TTC',1,0,'C');
            $this->Cell(25,7,number_format($_POST['total'], 2,',',' '),1,0,'R');
    }
}
$pdf= new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
/*$size = getimagesize('massartech.png');
$largeur=$size[0];
$hauteur=$size[1];
$ratio=12/$hauteur;	//hauteur imposée de 120mm
$newlargeur=$largeur*$ratio;
$posi=(210-$newlargeur)/2;	//210mm = largeur de page
//$pdf->image('massartech.png', $posi, 8, 0,12);*/
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode('Devis N°: '.$num_devis.''),0,0,'C');
$pdf->Ln(10);
$pdf->Cell(0,10,utf8_decode('Client : '.$societe.''),0,0,'L');
$pdf->Cell(0,10,utf8_decode(''),0,0,'C');
$pdf->Cell(0,10,utf8_decode('Date :'.date("d/m/Y", strtotime($date)).''),0,0,'R');
$pdf->Ln(10);
$pdf->headerTable();
$pdf->viewTable($devis_info, $mt_total);
$filename = "../Files/Devis/Devis ".str_replace('/','-',$num_devis).' '.str_replace(':','-',$societe).".pdf";
$pdf->Output("F",$filename);
?>