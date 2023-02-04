<?php

require "fpdf.php";
include "../DataSet/db.php";

$societe = $_POST['societe'];
$num_devis = $_POST['num_devis'];
$id_client = $_POST['id_client'];
$new_num_devis = $_POST['new_num_devis'];
$date = date("Y-m-d");

$devis = $pdo->query("INSERT INTO devis (num_devis, id_client, date_devis) VALUES 
                        ('$new_num_devis', '$id_client', '$date')");

$devis_details = $pdo->query("INSERT INTO devis_details (num_devis, reference, type, quantite, prix_ttc) 
                    SELECT '$new_num_devis', reference, type, quantite, prix_ttc FROM devis_details WHERE num_devis = '$num_devis'");

$req_mt_ttc = $pdo-> query("SELECT SUM(quantite*prix_ttc) as total FROM `devis_details` WHERE num_devis = '$new_num_devis'");
$mt_total_ttc = $req_mt_ttc->fetch(PDO::FETCH_ASSOC);
$req_mt_ttc->closeCursor();
$mt_total_ttc = $mt_total_ttc['total'];
$mt_total_ht = $mt_total_ttc/1.2;
$req_date = $pdo-> query("SELECT date_devis FROM `devis` WHERE num_devis = '$new_num_devis'");
$date = $req_date->fetch(PDO::FETCH_ASSOC);
$date = $date['date_devis'];
$devis_info = $pdo-> query("SELECT reference, type, quantite, prix_ttc/1.2 as prix FROM devis_details WHERE num_devis = '$new_num_devis'");

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
    function viewTable($devis_info, $mt_total_ttc, $mt_total_ht){
        
        while($data=$devis_info->fetch(PDO::FETCH_OBJ)){
            $this->SetFont('Times','',11);
            $this->Cell(20,6,$data->quantite,1,0,'C');
            $this->Cell(75,6,$data->reference,1,0,'C');
            $this->Cell(45,6,$data->type,1,0,'C');
            $this->SetFont('Times','B',11);
            $this->Cell(25,6,number_format($data->prix/1.2,2,',',''),1,0,'R');
            $this->Cell(25,6,number_format($data->quantite*$data->prix/1.2, 2,',',' '),1,0,'R');
            $this->Ln();
        }
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'Total HT',1,0,'C');
        $this->Cell(25,7,number_format($mt_total_ht,2,',',''),1,0,'R');
        $this->Ln();
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'TVA',1,0,'C');
        $this->Cell(25,7,number_format(($mt_total_ttc-$mt_total_ht), 2,',',' '),1,0,'R');
        $this->Ln();
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'Total TTC',1,0,'C');
        $this->Cell(25,7,number_format($mt_total_ttc, 2,',',' '),1,0,'R');
    }
}
$pdf= new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode('Devis N°: '.$new_num_devis.''),0,0,'C');
$pdf->Ln(10);
$pdf->Cell(0,10,utf8_decode('Client : '.$societe.''),0,0,'L');
$pdf->Cell(0,10,utf8_decode(''),0,0,'C');
$pdf->Cell(0,10,utf8_decode('Date :'.date("d/m/Y", strtotime($date)).''),0,0,'R');
$pdf->Ln(10);
$pdf->headerTable();
$pdf->viewTable($devis_info, $mt_total_ttc, $mt_total_ht);
$filename = "../Files/Devis/Devis ".str_replace('/','-',$new_num_devis).' '.str_replace(':','-',$societe).".pdf";
$pdf->Output("F",$filename);
?>