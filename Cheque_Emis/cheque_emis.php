<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT * FROM cheques WHERE debite = 'Non' ORDER BY id DESC";
$data = $pdo->query($sql);
$sql1 = "SELECT ROUND(SUM(montant), 2) AS total FROM cheques";
$data2 = $pdo->query($sql1);
$resultat=$data2->fetch(PDO::FETCH_ASSOC);
$sql2 = "SELECT DISTINCT YEAR(echeance) AS annee FROM cheques WHERE debite = 'Non' ORDER BY annee DESC";
$req = $pdo->query($sql2);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card bg-gray-200">
            <div class="container-fluid">
                <div class="p-2 d-flex justify-content-center">
                    <div class=" row p-2 col-lg-9 border rounded border-dark">
                        <button class="btn btn-secondary mr-2" onclick="global();">Global</button>
                        <button class="btn btn-secondary" onclick="chiffre_fournisseur();">Chiffre/Fournisseur</button>
                        <div class="col-lg-3">
                            <select class="form-control" id="annee_echeance">
                                <?php
                                foreach ($req as $row1){ ?>
                                <option><?php echo($row1['annee']);?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <button class="btn btn-secondary" onclick="echeance_annee();">Chèques/Mois</button>
                    </div>
                </div>
                <div class="row p-2">
                    <label class="form-label p-2" for="date_emis">Date Emis :</label>   
                    <div class="col-lg-3"><input type="date" class="form-control" id="date_emis" value="<?php echo date("Y-m-d");?>"></div>
                    <label class="form-label p-2" for="date_echeance">Date Echéance :</label>
                    <div class="col-lg-3"><input type="date" class="form-control" id="date_echeance" value="<?php echo date("Y-m-d");?>"></div>
                </div>
                <div class="row">
                    <label class="form-label p-2" for="type">Type : </label>
                    <div class="col-lg-2">
                        <select class="form-control" id="type" aria-label="">
                            <option selected>Lettre Change</option>
                            <option>Chèque</option>
                            <option>Virement</option>
                        </select>
                    </div>
                    <label class="form-label p-2" for="numero">Numéro : </label>
                    <div class="col-lg-2"><input type="text" class="form-control" id="numero"></div>
                    <label class="form-label p-2" for="montant">Montant : </label>
                    <div class="col-lg-2"><input type="text" class="form-control" id="montant"></div>
                </div>
                <div class="row">
                    <label class="form-label p-2" for="fournisseur">Fournisseur:</label>
                    <div class="col-lg-4"><input type="text" class="form-control" id="fournisseur"></div>
                    <label class="form-label p-2" for="nature">Nature : </label>
                    <div class="col-lg-2">
                        <select class="form-control" id="nature" aria-label="Default select example">
                            <option selected>Caméra</option>
                            <option>Construction</option>
                        </select>
                    </div>
                    <div class="col float-right">
                        <button type="button" class="btn btn-success" onclick="valider();">Valider</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center p-3">
            <button type="button" class="btn btn-info btn-sm" onclick="payant()">P</button>
            <label class="form-label p-2" for="total">Total :</label>
            <div class="col-lg-4">
                <input type="text" class="form-control float-right" id="total" value="<?php echo number_format($resultat['total'],2,","," ");?>" disabled>
            </div>
        </div>
        <h6 class="mt text-center font-weight-bold text-primary">Liste des Chéques</h6>
        <div class="card-body">
            <div class="table-responsive" id="cheque_list">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><center>#</center></th>
                            <th><center>Type</center></th>
                            <th><center>Numero</center></th>
                            <th><center>Montant</center></th>
                            <th><center>Emis</center></th>
                            <th><center>Echeance</center></th>
                            <th><center>Fournisseur</center></th>
                            <th><center>Nature</center></th>
                            <th><center>id</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form name="list_cheque" id="list_cheque">
                            <?php
                                foreach ($data as $row){ ?>
                            <tr>
                                <td><center>
                                        <input aria-label="Checkbox for following text input" type="checkbox" id="cheque" name="cheque" 
                                            onclick="select_cheque_payant();" value="<?php echo $row['id'];?>">
                                    </center>
                                </td>
                                <td><center><?php echo($row['type']);?></center></td>
                                <td><center><?php echo($row['numero']);?></center></td>
                                <td><center><?php echo number_format($row['montant'],2,","," ");?></center></td>
                                <td><center><?php echo date("d-m-Y", strtotime($row['emis']));?></center></td>
                                <td><center><?php echo date("d-m-Y", strtotime($row['echeance']));?></center></td>
                                <td><center><?php echo($row['fournisseur']);?></center></td>
                                <td><center><?php echo($row['nature']);?></center></td>
                                <td><center><?php echo($row['id']);?></center></td>
                            </tr>
                            <?php } ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
var cheque = '';
$(function () {
    $("#fournisseur").autocomplete({
        source: 'autocomplete_filtre_fourn.php',
        delay: 30
    });
});
function echeance_annee(){
    var echeance = $('#annee_echeance').val();
    $.ajax({
        type: "POST",
        url: 'list_echeance.php',
        data: {echeance:echeance},
        success:function(msg) {
            $('#cheque_list').html(msg);
        }
    }); 
}
function global(){
    $.ajax({
        type: "POST",
        url: 'list_global.php',
        success:function(msg) {
            $('#cheque_list').html(msg);
            $('#dataTable').DataTable( { });
        }
    });
}
function chiffre_fournisseur(){
    var fournisseur = $('#fournisseur').val();
    if(fournisseur == ''){
        alert_error('Saisie le Fournisseur');
    }else{
        $.ajax({
            type: "POST",
            url: 'chiffre_fournisseur.php',
            data: {fournisseur:fournisseur},
            success:function(msg) {
                $('#cheque_list').html(msg);
                $('#dataTable').DataTable({ });
            }
        }); 
    }
}
function valider(){
    var emis = $("#date_emis").val();
    var echeance = $("#date_echeance").val();
    var type = $("#type").val();
    var numero = $("#numero").val();
    var montant = $("#montant").val();
    var fournisseur = $("#fournisseur").val();
    var nature = $("#nature").val();
    if (emis == '' || echeance == '' || type == '' || numero == '' || montant == '' || fournisseur == '' || nature == '') {
        alert_error('Remplis Tous Les Champs SVP');
    }else{
        $.ajax({
            type: "POST",
            url: 'valide_cheque.php',
            data: {emis:emis,echeance:echeance,type:type,numero:numero,montant:montant,fournisseur:fournisseur,nature:nature},
            success:function(msg) {
                alert_success('Enregistrement Effectué');
                setTimeout(function() {
                    window.location.href="cheque_emis.php";
                }, 750);
            }
        });
    }
}
function select_cheque_payant(){
    var valeur = document.querySelectorAll('input[type="checkbox"]');;
    var msg = '';
    for (var i = 0; i < valeur.length; i++) {
        //alert('y');
        if (valeur[i].checked) {
            var v = valeur[i].value;
            msg += '\''+v+'\',';
        }
    }
    cheque = msg.substring(0, msg.length-1);
    //alert(cheque);
}
function payant(){
    if(cheque == ''){
        alert_error('SVP Selectionner Un Chèque');
    }else{
        $.ajax({
            type: "POST",
            url: 'cheque_payant.php',
            data: {cheque:cheque},
            success:function(msg) {
                if (msg = 'Opération Effectué') {
                    alert_success(msg);
                    setTimeout(function() {
                        window.location.href="cheque_emis.php";
                    }, 750);
                }
            }
        });
    }
}
</script>
<?php }
?>