<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT N°Facture, date_facture, societe, Total FROM (
        SELECT F.num_facture as N°Facture, date_facture, societe, mt_total as Total from vente_details D
        INNER JOIN client C on C.id = D.id_client 
        INNER JOIN facture F on D.num_facture = F.num_facture
        UNION
        SELECT F.num_facture as N°Facture, date_facture, societe, mt_total as Total from vente_article V 
        INNER JOIN client C on C.id = V.id_client 
        INNER JOIN facture F on V.num_facture = F.num_facture)X";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card bg-gray-200">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <fieldset class="border border-dark rounded mb-2 p-2">
                            <legend class="float-none w-auto p-2">Date de Stockage</legend>
                            <div class="col-md-12 d-inline-block">
                                <input type="date" class="form-control" id="date_stockage" value="">
                                <button class="btn btn-info mt-2">OK</i></button>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col">
                        <div class="">
                            <div class="d-flex justify-content-center">
                                <div class="custom-control custom-radio form-check-inline">
                                    <input class="custom-control-input" onclick="etat_recherche();" type="radio" name="flexRadioDefault" id="vendu" checked>
                                    <label class="custom-control-label text-nowrap" for="vendu">
                                        Vendu
                                    </label>
                                </div>
                                <div class="custom-control custom-radio form-check-inline">
                                    <input class="custom-control-input" onclick="etat_recherche();" type="radio" name="flexRadioDefault" id="en_stock">
                                    <label class="custom-control-label text-nowrap" for="en_stock">
                                        En Stock
                                    </label>
                                </div>
                            </div><br>
                            <div>
                                <label class="d-flex justify-content-center" for="">Saisissez Votre Recherche</label>
                                <div class="row justify-content-center">
                                    <div class="col-md-9"><input type="text" class="form-control" id="rech"></div>
                                    <div class="col-md-1"><button class="btn btn-info" onclick="recherche();"><i class="fas fa-search"></i></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <fieldset class="border border-dark rounded mb-2 p-2">
                            <legend class="float-none w-auto p-2">Critère de Recherche :</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="critere" value="n_serie" id="n_serie" checked>
                                        <label class="form-check-label " for="n_serie">
                                            N°Série
                                        </label>
                                    </div>
                                    <div class="form-check" id="n_bon_check">
                                        <input class="form-check-input" type="radio" value="n_bon" name="critere" id="n_bon">
                                        <label class="form-check-label" for="n_bon">
                                            N°Bon
                                        </label>
                                    </div>
                                    <div class="form-check" id="nom_check">
                                        <input class="form-check-input" type="radio" value="nom" name="critere" id="nom">
                                        <label class="form-check-label" for="nom">
                                            Nom
                                        </label>
                                    </div>
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <div class="form-check" id="societe_check">
                                        <input class="form-check-input" type="radio" value="societe" name="critere" id="societe">
                                        <label class="form-check-label" for="societe">
                                            Société
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="reference" name="critere" id="reference">
                                        <label class="form-check-label" for="reference">
                                            Référence
                                        </label>
                                    </div>
                                    <div class="form-check" id="fournisseur_check">
                                        <input class="form-check-input" type="radio" value="fournisseur" name="critere" id="fournisseur">
                                        <label class="form-check-label" for="fournisseur">
                                            Fournisseur
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="table">

        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.getElementById('date_stockage').value = new Date().toDateInputValue();
function etat_recherche(){
    var checkbox_vendu = document.getElementById("vendu");
    var checkbox_enstock = document.getElementById("en_stock");
    if(checkbox_enstock.checked == true){
        $("#nom_check").hide();
        $("#societe_check").hide();
        $("#n_bon_check").hide();
    }else if(checkbox_vendu.checked == true){
        $("#nom_check").show();
        $("#societe_check").show();
        $("#n_bon_check").show();
    }
}
function recherche(){
    var rech = $('#rech').val();
    var condition = '';
    var etat = '';
    if (rech == '' || rech == ' ') {
        alert_error('SVP Saisissez Votre Recherche');
    }else{
        var vendu = document.getElementById("vendu");
        var enstock = document.getElementById("en_stock");
        var n_serie = document.getElementById("n_serie");
        var societe = document.getElementById("societe");
        var n_bon = document.getElementById("n_bon");
        var reference = document.getElementById("reference");
        var nom = document.getElementById("nom");
        var fournisseur = document.getElementById("fournisseur");
        if(vendu.checked == true){
            etat = 'vendu';
            if(n_serie.checked == true){
                condition = 'n_serie';
            }else if(societe.checked == true){
                condition = 'C.societe';
            }else if(nom.checked == true){
                condition = 'C.nom';
            }else if(reference.checked == true){
                condition = 'reference';
            }else if(fournisseur.checked == true){
                condition = 'fournisseur';
            }else if(n_bon.checked == true){
                condition = 'N_bon';
            }
        }else if(enstock.checked == true){
            etat = 'enstock';
            if(n_serie.checked == true){
                condition = 'n_serie';
            }else if(fournisseur.checked == true){
                condition = 'fournisseur';
            }else if(reference.checked == true){
                condition = 'reference';
            }
        }
        $.ajax({
            type: "POST",
            url: 'valide_recherche.php',
            data: {rech:rech,condition:condition,etat:etat},
            success:function(msg) {
                $('#table').html(msg);
            }
        });
    }
}
</script>
<?php }
?>