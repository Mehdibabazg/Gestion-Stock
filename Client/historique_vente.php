<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$id_client=$_GET['id_client'];
$societe=$_GET['societe'];
$sql = "SELECT B.date_vente, B.N_bon, sum(B.total) AS 'Somme Total', facture, num_facture, bl ,num_bl FROM (
        SELECT DISTINCT (D.date_vente), S.N_bon, sum(D.prix_vente) AS total, facture, num_facture, bl ,num_bl FROM vente_details D 
        INNER JOIN stock S on D.N_serie=S.N_serie WHERE id_client = $id_client GROUP BY D.date_vente, S.N_bon 
        UNION 
        SELECT DISTINCT (D.date_vente), N_bon, sum(D.prix_vente * D.quantite) AS total, facture, num_facture, bl ,num_bl FROM vente_article D 
        WHERE id_client = $id_client GROUP BY D.date_vente, N_bon) B GROUP BY B.date_vente, B.N_bon order by B.date_vente DESC";
$data = $pdo->query($sql);
$sql1 ="SELECT B.date_vente, B.N_bon, sum(B.total) AS 'Somme Total', facture FROM (
        SELECT DISTINCT (D.date_vente), S.N_bon, sum(D.prix_vente) AS total, facture FROM vente_details D
        INNER JOIN stock S on D.N_serie=S.N_serie WHERE id_client = $id_client AND facture = 'Non' GROUP BY S.N_bon 
        UNION 
        SELECT DISTINCT (D.date_vente), N_bon, sum(D.prix_vente * D.quantite) AS total, facture FROM vente_article D
        WHERE id_client = $id_client AND facture = 'Non' GROUP BY D.date_vente, N_bon) B GROUP BY B.date_vente, B.N_bon order by B.date_vente";
$data1 = $pdo->query($sql1);
$sql2 ="SELECT B.date_vente, B.N_bon, sum(B.total) AS 'Somme Total', bl FROM (
    SELECT DISTINCT (D.date_vente), S.N_bon, sum(D.prix_vente) AS total, bl FROM vente_details D
    INNER JOIN stock S on D.N_serie=S.N_serie WHERE id_client = $id_client AND bl = 'Non' GROUP BY S.N_bon 
    UNION 
    SELECT DISTINCT (D.date_vente), N_bon, sum(D.prix_vente * D.quantite) AS total, bl FROM vente_article D
    WHERE id_client = $id_client AND bl = 'Non' GROUP BY D.date_vente, N_bon) B GROUP BY B.date_vente, B.N_bon order by B.date_vente";
$data2 = $pdo->query($sql2);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
    <!---------------------------------------------- Facture modal open ---------------------------------------------->
<div id="modal_facture" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <button type="button" class="btn btn-light close mb-2" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="col-md table-responsive justify-content-center">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th><center><input aria-label="Checkbox for following text input" type="checkbox" onclick="select_all_f(this);"></center></th>
                                <th><center>Date Vente</center></th>
                                <th><center>N° BON</center></th>
                                <th><center>Somme total</center></th>
                                <th><center>Facture</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="listFacture" name="listFacture">
                                <?php
                                    foreach ($data1 as $row1){ ?>
                                    
                                <tr>
                                    <td><center><input aria-label="Checkbox for following text input" type="checkbox" id="check_facture" name="check_facture" 
                                                        onclick="count_montant_facture();" value="<?php echo sprintf('%0.2f', $row1['Somme Total'])." ".$row1['N_bon']?>"></center></td>
                                    <td><center><?php echo date("d/m/Y", strtotime($row1['date_vente']));?></center></td>
                                    <td><center><?php echo($row1['N_bon']);?></center></td>
                                    <td><center><?php echo sprintf('%0.2f', $row1['Somme Total']);?></center></td>
                                    <td><center><?php echo($row1['facture']);?></center></td>
                                </tr>
                                <tr hidden>
                                    <td><center><input aria-label="Checkbox for following text input" type="checkbox" id="check_facture" name="check_facture" 
                                                        onclick="count_montant_facture();" value="0"></center></td>
                                </tr>
                                <?php   } ?>
                            </form>
                        </tbody>
                    </table>
                </div>
                <div class="col-md row justify-content-center">
                    <div class="col-md-6">
                    <input type="text" id="montant_total_facture" class="form-control" disabled /></div>
                    <div class="col-md-4">
                    <a type="button" class="btn btn-md btn-danger" onclick="open_modal_print_facture()"><i class="fas fa-print"></i> Imprimer</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!---------------------------------------------- Facture modal close ---------------------------------------------->
    <!---------------------------------------------- BL modal open ---------------------------------------------->
<div id="modal_BL" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <button type="button" class="btn btn-light close mb-2" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="col-md table-responsive justify-content-center">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th><center><input aria-label="Checkbox for following text input" type="checkbox" onclick="select_all_lb(this);"></center></th>
                                <th><center>Date Vente</center></th>
                                <th><center>N° BON</center></th>
                                <th><center>Somme total</center></th>
                                <th><center>BL</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="listBL" name="listBL">
                                <?php
                                    foreach ($data2 as $row2){ ?>
                                <tr>
                                    <td><center><input aria-label="Checkbox for following text input" type="checkbox" id="check_bl" name="check_bl" 
                                                    onclick="count_montant_bl();" value="<?php echo sprintf('%0.2f', $row2['Somme Total'])." ".$row2['N_bon']?>"></center></td>
                                    <td><center><?php echo date("d/m/Y", strtotime($row2['date_vente']));?></center></td>
                                    <td><center><?php echo($row2['N_bon']);?></center></td>
                                    <td><center><?php echo sprintf('%0.2f', $row2['Somme Total']);?></center></td>
                                    <td><center><?php echo($row2['bl']);?></center></td>
                                </tr>
                                <tr hidden>
                                    <td><center><input aria-label="Checkbox for following text input" type="checkbox" id="check_bl" name="check_bl" 
                                                    onclick="count_montant_bl();" value="0"></center></td>
                                </tr>
                                <?php   } ?>
                            </form>
                        </tbody>
                    </table>
                </div>
                <div class="col-md row justify-content-center">
                    <div class="col-md-6">
                    <input type="text" id="montant_total_bl" class="form-control" disabled /></div>
                    <div class="col-md-4">
                    <a type="button" class="btn btn-md btn-danger" onclick="open_modal_print_BL()"><i class="fas fa-print"></i> Imprimer</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!---------------------------------------------- BL modal close ---------------------------------------------->
    <!-------------------------------------------- BON details modal open -------------------------------------------->
<div id="modal_bon_details" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <button type="button" class="btn btn-light close mb-2" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="col-md table-responsive justify-content-center">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th><center>Référence</center></th>
                                <th><center>Quantité</center></th>
                                <th><center>Prix de Vente</center></th>
                            </tr>
                        </thead>
                        <tbody id="details_bon">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--------------------------------------------- BON details modal close ----------------------------------------->
    <!--------------------------------------------- Impression facture modal ----------------------------------------->
<div id="impression_facture" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-sm modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body">
                N° Chéque <input type="text" class="form-control" id="num_cheque_facture">
                Montant Chéque <input type="number" class="form-control" id="mt_cheque_facture">
                Espéces <input type="number" class="form-control" id="especes_facture">
                <a  class="btn btn-md btn-danger mt-2" onclick="imprimer_facture()"><i class="fas fa-print"></i> Valider</a>
            </div>
        </div>
    </div>
</div>
    <!--------------------------------------------- Impression facture modal Final ----------------------------------------->
        <!--------------------------------------------- Impression bl modal ----------------------------------------->
<div id="impression_bl" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-sm modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body">
                N° Chéque <input type="text" class="form-control" id="num_cheque_bl">
                Montant Chéque <input type="number" class="form-control" id="mt_cheque_bl">
                Espéces <input type="number" class="form-control" id="especes_bl">
                <a  class="btn btn-md btn-danger mt-2" onclick="imprimer_bl()"><i class="fas fa-print"></i> Valider</a>
            </div>
        </div>
    </div>
</div>
    <!--------------------------------------------- Impression bl modal Final ----------------------------------------->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Liste des Ventes Du <?php echo($societe);?></h6>
        <a href="" class="btn btn-primary btn-md float-right ml-2" data-target="#modal_facture" data-toggle="modal"><i class="fas fa-file-invoice-dollar"></i> Facture</a> 
        <a href="" class="btn btn-primary btn-md float-right" data-target="#modal_BL" data-toggle="modal"><i class="far fa-file-alt"></i> Bon de Livraison</a> 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th><center>Date de vente</center></th>
                    <th><center>N° BON</center></th>
                    <th><center>Somme Total</center></th>
                    <th><center>Facture</center></th>
                    <th><center>Num_Facture</center></th>
                    <th><center>BL</center></th>
                    <th><center>Num_BL</center></th>
                    <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo date("d/m/Y", strtotime($row['date_vente']));?></center></td>
                        <td><center><?php echo($row['N_bon']);?></center></td>
                        <td><center><?php echo number_format($row['Somme Total'],2,".","");?></center></td>
                        <td><center><?php echo($row['facture']);?></center></td>
                        <td><center><?php echo($row['num_facture']);?></center></td>
                        <td><center><?php echo($row['bl']);?></center></td>
                        <td><center><?php echo($row['num_bl']);?></center></td>
                        <td><center>
                            <button title="Afficher les details" data-toggle="modal" data-target="#modal_bon_details" class="btn btn-sm btn-info"
                                onclick="open_model_bon('<?php echo $row['N_bon']; ?>');">
                            <i class="far fa-eye"></i></button>
                            </center></td> 
                    </tr>
                    <?php   } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
var bon_facture = '';
var bon_bl = '';
    function open_model_bon(n_bon) {
        $.ajax({
            type: "POST",
            url: 'details_bon.php',
            data: {n_bon:n_bon},
            success:function(msg) {
                $('#details_bon').html(msg);
            }
        });
    }
    function select_all_f(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
        count_montant_facture();
    }
    function count_montant_facture(){
        var valeur = document.listFacture.check_facture;
        var msg = '';
        var total = 0;
        for (var i = 0; i < valeur.length; i++) {
            //alert('y');
            if (valeur[i].checked) {
                var v = valeur[i].value;
                var array = v.split(" ");
                total+=parseFloat(array[0]);
                msg += '\''+array[1]+'\',';
            }
        }
        bon_facture = msg.substring(0, msg.length-1);
        $('#montant_total_facture').val(total.toFixed(2));  
    }
    function open_modal_print_facture(){
        var valeur = document.listFacture.check_facture;
        var b = false;
        for (var i = 0; i < valeur.length; i++) {
            if (valeur[i].checked) {
                b=true;
                break;
            }
        }
        if (b) {
            $('#impression_facture').modal('show');
        }else{
            alert_error('Sélectionnez Un BON');
        }
    }
    function imprimer_facture() {
        <?php
            $num_facture_req = $pdo->query("CALL Inc_facture()");
            $num_facture = $num_facture_req->fetch(PDO::FETCH_ASSOC);
            $num_facture_req->closeCursor();
            $num = $num_facture['num']; ?>
        var num_facture = '<?php echo $num; ?>';
        var societe ='<?php echo strtoupper($societe); ?>';
        var mt_total = $('#montant_total_facture').val();
        var num_cheque = $('#num_cheque_facture').val();
        var mt_cheque = $('#mt_cheque_facture').val();
        var especes = $('#especes_facture').val();
        //alert(mt_total+" "+num_cheque+" "+mt_cheque+" "+especes+" "+societe);
        //alert(msg.substring(0,msg.length-1));
        $.ajax({
            type: "POST",
            url: '../pdf/facture_pdf.php',
            data: {societe:societe,num_facture:num_facture,bon:bon_facture,num_cheque:num_cheque,
                mt_cheque:mt_cheque,especes:especes,mt_total:mt_total
            },
            success:function(msg) {
                $('#impression_facture').modal('hide');
                window.open('../Files/Facture/Facture '+num_facture.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
                window.location.reload();
                //alert(msg);
            }
        });
    }
    function select_all_lb(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
        count_montant_bl();
    }
    function count_montant_bl(){
        var valeur = document.listBL.check_bl; 
        var msg = '';
        var total = 0;
        for (var i = 0; i < valeur.length; i++) {
            if (valeur[i].checked) {
                var v = valeur[i].value;
                var array = v.split(" ");
                total+=parseFloat(array[0]);
                msg += '\''+array[1]+'\',';
            }
        }
        bon_bl = msg.substring(0, msg.length-1);
        $('#montant_total_bl').val(total.toFixed(2)); 
    }
    function open_modal_print_BL(){
        var valeur = document.listBL.check_bl;
        var b = false;
        for (var i = 0; i < valeur.length; i++) {
            if (valeur[i].checked) {
                b=true;
                break;
            }
        }
        if (b) {
            $('#impression_bl').modal('show');
        }else{
            alert_error('Sélectionnez Un BON');
        }
    }
    function imprimer_bl() {
        <?php
            $num_bl_req = $pdo->query("CALL Inc_BL()");
            $num_bl = $num_bl_req->fetch(PDO::FETCH_ASSOC);
            $num_bl_req->closeCursor();
            $num = $num_bl['num']; ?>
        var num_bl = '<?php echo $num; ?>';
        var societe ='<?php echo strtoupper($societe); ?>';
        var mt_total = $('#montant_total_bl').val();
        var num_cheque = $('#num_cheque_bl').val();
        var mt_cheque = $('#mt_cheque_bl').val();
        var especes = $('#especes_bl').val();
        $.ajax({
            type: "POST",
            url: '../pdf/bl_pdf.php',
            data: {societe:societe,num_bl:num_bl,bon:bon_bl,num_cheque:num_cheque,
                mt_cheque:mt_cheque,especes:especes,mt_total:mt_total
            },
            success:function(msg) {
                $('#impression_bl').modal('hide');
                window.open('../Files/BL/BL '+num_bl.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
                window.location.reload();
                //alert(msg);
            }
        });
    }

</script>
<?php }
?>