<?php

require "fpdf.php";
include "../DataSet/db.php";

$societe = $_POST['societe'];
$num_facture = $_POST['num_facture'];

$sql_mt_total=$pdo->query("SELECT X.num_facture, SUM(total) as mt_total from (select D.num_facture, ROUND(count(S.reference)*D.prix_vente, 2) as total from vente_details D
                            inner join facture F on D.num_facture=F.num_facture
                            inner join stock S on D.n_serie=S.n_serie GROUP BY D.num_facture
                            union
                            select V.num_facture, ROUND(sum((prix_vente*V.quantite)), 2) AS total from vente_article V 
                            inner join facture F on V.num_facture = F.num_facture 
                            inner join articles A on A.id = V.id_articles GROUP BY V.num_facture) X where X.num_facture='".$num_facture."'");

$mt_total = $sql_mt_total->fetch(PDO::FETCH_ASSOC);
$mt_total_ttc = $mt_total['mt_total'];
$mt_total_ht = $mt_total['mt_total']/1.2;
$req_date = $pdo-> query("SELECT * FROM `facture` WHERE num_facture = '$num_facture'");
$data = $req_date->fetch(PDO::FETCH_ASSOC);
$date = $data['date_facture'];
$num_cheque = $data['num_cheque'];
$mt_cheque = $data['mt_cheque'];
$especes = $data['especes'];

$facture_info = $pdo-> query("SELECT societe, quantite, reference, type, prix_vente, total, num_facture, date_facture, num_cheque, mt_cheque, especes from (
                            select societe, count(reference) as quantite, S.reference as reference, type, ROUND(D.prix_vente/1.2, 2) as prix_vente, ROUND(count(S.reference)*D.prix_vente/1.2, 2) as total,
                            D.num_facture, date_facture, F.num_cheque, F.mt_cheque, F.especes from vente_details D inner join client C on D.id_client = C.id 
                            inner join 
                            facture F on D.num_facture=F.num_facture
                            inner join 
                            stock S on D.n_serie=S.n_serie group by societe, S.reference, type, D.prix_vente, D.num_facture, date_facture, D.date_vente, num_cheque,
                            mt_cheque, especes 
                            union
                            select societe, sum(V.quantite) as quantite, reference, type, ROUND(avg(prix_vente)/1.2, 2) as prix_vente, ROUND(sum((prix_vente*V.quantite))/1.2, 2) AS total,
                            V.num_facture, date_facture, F.num_cheque, F.mt_cheque, F.especes from vente_article V inner join Client C on V.id_client=C.id 
                            inner join facture F on V.num_facture = F.num_facture 
                            inner join articles A on A.id = V.id_articles group by societe, A.reference, type, V.prix_vente, V.num_facture, date_facture, 
                            V.date_vente, num_cheque, mt_cheque, especes) X where num_facture='".$num_facture."'");

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
    function viewTable($facture_info, $mt_total_ttc, $mt_total_ht, $num_cheque, $mt_cheque, $especes){
        
        while($data=$facture_info->fetch(PDO::FETCH_OBJ)){
            $this->SetFont('Times','',11);
            $this->Cell(20,6,$data->quantite,1,0,'C');
            $this->Cell(75,6,$data->reference,1,0,'C');
            $this->Cell(45,6,$data->type,1,0,'C');
            $this->SetFont('Times','B',11);
            $this->Cell(25,6,number_format($data->prix_vente/1.2,2,',',' '),1,0,'R');
            $this->Cell(25,6,number_format($data->total, 2,',',' '),1,0,'R');
            $this->Ln();
        }
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'Total HT',1,0,'C');
        $this->Cell(25,7,number_format($mt_total_ht,2,',',' '),1,0,'R');
        $this->Ln();
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'TVA',1,0,'C');
        $this->Cell(25,7,number_format(($mt_total_ttc-$mt_total_ht), 2,',',' '),1,0,'R');
        $this->Ln();
        $this->Cell(140,7,'',0,0,'L');
        $this->Cell(25,7,'Total TTC',1,0,'C');
        $this->Cell(25,7,number_format($mt_total_ttc, 2,',',' '),1,0,'R');
        $this->Ln(-12);
        $this->Cell(30,7,utf8_decode('N° Cheque'),1,0,'L');
        $this->Cell(30,7,$num_cheque,1,0,'R');
        $this->Ln();
        $this->Cell(30,7,'Montant Cheque',1,0,'L');
        $this->Cell(30,7,number_format($mt_cheque, 2,',',' '),1,0,'R');
        $this->Ln();
        $this->Cell(30,7,'Especes',1,0,'L');
        $this->Cell(30,7,number_format($especes, 2,',', ''),1,0,'R');
    }
}
$pdf= new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,10,utf8_decode('facture N°: '.$num_facture.''),0,0,'C');
$pdf->Ln(10);
$pdf->Cell(0,10,utf8_decode('Client : '.$societe.''),0,0,'L');
$pdf->Cell(0,10,utf8_decode(''),0,0,'C');
$pdf->Cell(0,10,utf8_decode('Date :'.date("d/m/Y", strtotime($date)).''),0,0,'R');
$pdf->Ln(10);
$pdf->headerTable();
$pdf->viewTable($facture_info, $mt_total_ttc, $mt_total_ht, $num_cheque, $mt_cheque, $especes);
$filename = "../Files/Facture/Facture ".str_replace('/','-',$num_facture).' '.str_replace(':','-',$societe).".pdf";
$pdf->Output("F",$filename);
?>