<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT DISTINCT N_bon FROM (
    SELECT N_bon FROM vente_article
    UNION
    SELECT N_bon FROM vente_details) d
    WHERE N_bon NOT IN(SELECT DISTINCT N_bon FROM paiement) AND N_bon<>'null' order by N_bon";

$req=$pdo->query($sql);
$sql1 = "SELECT * FROM paiement ORDER BY id DESC";
$data = $pdo->query($sql1);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div>
    
</div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="card bg-gray-200">
                    <div class="row p-2 justify-content-center">
                        <div class="d-inline mt-2 col-md-2">Numéro Bon : </div>
                        <div class="d-inline col-md-2">
                            <select id="n_bon" onchange="select_bon();" onclick="select_bon();" name="n_bon" class="form-control" aria-label="Default select example">
                                <?php foreach ($req as $row) { ?>
                                    <option value="<?php echo $row['N_bon'];?>"> <?php echo $row['N_bon']; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="d-inline col-md-3 p-2">
                            <label class="label">Montant Bon : <label id="mt_bon" name="mt_bon"></label></label>
                        </div>
                    </div>
                    <div class="mx-5">
                        <div class="row col-md mb-2">
                            <div class="col-md-3">
                                <input type="checkbox" class="form-check-input" aria-label="Checkbox for following text input" id="cheque" name="cheque" onclick="get_form1()">
                                <label class="form-check-label" for="cheque">Chéque</label>
                            </div>
                            <div id="form-cheque" class="col-md-9 row" style="display:none;">
                                <div class="col-md-3">
                                    <label>Montant</label>
                                    <input type="number" class="form-control" step="0.01" name="mt_cheque" id="montant_cheque">
                                </div>
                                <div class="col-md-3">
                                    <label>Numéro</label>
                                    <input type="number" class="form-control" name="num_cheque" id="numero">
                                </div>
                                <div class="col-md-4">
                                    <label>Echéance</label>
                                    <input type="date" class="form-control" name="echeance" id="echeance" value="1999-01-01">
                                </div>
                            </div>
                        </div>
                        <div class="col-md row mb-2">
                            <div class="col-md-3">
                                <input type="checkbox" class="form-check-input" aria-label="Checkbox for following text input" id="especes" name="especes" onclick="get_form2()">
                                <label class="form-check-label" for="especes">Espéces</label>
                            </div>
                            <div id="form-especes" class="col-md-9 row" style="display:none;">
                                <div class="col-md-3">
                                    <label>Montant</label>
                                    <input type="number" class="form-control" step="0.01" name="montant_especes" id="montant_especes">
                                </div>
                            </div>
                        </div>
                        <div class="col-md row mb-2">
                            <div class="col-md-3">
                                <input type="checkbox" class="form-check-input" aria-label="Checkbox for following text input" id="virement" name="virement" onclick="get_form3()">
                                <label class="form-check-label" for="virement">Virement</label>
                            </div>
                            <div id="form-virement" class="col-md-9 row" style="display:none;">
                                <div class="col-md-3">
                                    <label>Montant</label>
                                    <input type="number" class="form-control" step="0.01" name="montant_virement" id="montant_virement">
                                </div>
                            </div>
                        </div>
                        <div class="col-md row mb-2">
                            <div class="col-md-3">
                                <input type="checkbox" class="form-check-input" aria-label="Checkbox for following text input" id="non_payer" name="non_payer" onclick="get_form4()">
                                <label class="form-check-label" for="non_payer">Non Payer</label>
                            </div>
                            <div id="form-non-payer" class="col-md-9 row" style="display:none;">
                                <div class="col-md-3">
                                    <label>Montant</label>
                                    <input type="number" class="form-control" step="0.01" name="reste" id="reste" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <button class="btn btn-space md-trigger btn-success float-right" onclick='valide_paiement()'>Valider</button>
                    </div>
            </div>
            <h6 class="mt-3 text-center font-weight-bold text-primary">Liste des Paiements</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><center>N°_bon</center></th>
                            <th><center>Mt_Chéque</center></th>
                            <th><center>Espéces</center></th>
                            <th><center>Virement</center></th>
                            <th><center>Reste</center></th>
                            <th><center>Echéance</center></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                        <tr>
                            <td><center><?php echo($row['n_bon']); ?></center></td>
                            <td><center><?php echo sprintf('%0.2f', $row['mt_cheque'], 2); ?></center></td>
                            <td><center><?php echo sprintf('%0.2f', $row['especes'], 2); ?></center></td>
                            <td><center><?php echo sprintf('%0.2f', $row['virement'], 2); ?></center></td>
                            <td><center><?php echo sprintf('%0.2f', $row['reste'], 2); ?></center></td>
                            <td><center><?php echo date("d/m/Y", strtotime($row['Echeance'])); ?></center></td> 
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
<script>
function select_bon(){
    var n_bon = $('#n_bon').val();
    $.ajax({
        type: "POST",
        url: 'get_mt_bon.php',
        data: {n_bon:n_bon},
        success:function(msg) {
            $('#mt_bon').html(msg);
        }
    });
}
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    }); 

function get_form1() {
    var checkBox = document.getElementById("cheque");
    var div = document.getElementById("form-cheque");
    var mt_bon = $("#mt_bon").html();
    if (checkBox.checked == true){
        div.style.display = "inline-flex";
        $("#montant_cheque").val(parseFloat(mt_bon));
        document.getElementById('echeance').value = new Date().toDateInputValue();
    }else {
        div.style.display = "none";
        $("#montant_cheque").val(0);
        document.getElementById('echeance').value = "1900-01-01";
    }
}
function get_form2() {
    var checkBox = document.getElementById("especes");
    var div = document.getElementById("form-especes");
    var mt_bon = $("#mt_bon").html();
    if (checkBox.checked == true){
        div.style.display = "inline-flex";
        $("#montant_especes").val(parseFloat(mt_bon));
    }else {
        div.style.display = "none";
        $("#montant_especes").val(0);
    }
}
function get_form3() {
    var checkBox = document.getElementById("virement");
    var div = document.getElementById("form-virement");
    var mt_bon = $("#mt_bon").html();
    if (checkBox.checked == true){
        div.style.display = "inline-flex";
        $("#montant_virement").val(parseFloat(mt_bon));
    }else {
        div.style.display = "none";
        $("#montant_virement").val(0);
    }
}
function get_form4() {
    var checkBox = document.getElementById("non_payer");
    var div = document.getElementById("form-non-payer");
    var mt_bon = $("#mt_bon").html();
    if (checkBox.checked == true){
        div.style.display = "inline-flex";
        $("#reste").val(parseFloat(mt_bon));
    }else {
        div.style.display = "none";
    }
}
function valide_paiement(){
    var n_bon = $('#n_bon').val();
    var mt_cheque = $('#mt_cheque').val();
    var num_cheque = $('#num_cheque').val();
    var echeance = $('#echeance').val();
    var montant_especes = $('#montant_especes').val();
    var montant_virement = $('#montant_virement').val();
    var reste = $('#reste').val();
    if ($('#cheque').is(':checked') || $('#especes').is(':checked') || $('#virement').is(':checked') || $('#non_payer').is(':checked')) {
        $.ajax({
            type: "POST",
            url: 'valide_paiement.php',
            data: {n_bon:n_bon,mt_cheque:mt_cheque,num_cheque:num_cheque,echeance:echeance,
                    montant_especes:montant_especes,montant_virement:montant_virement,reste:reste},
            success:function(msg) {
                if (msg = 'Enregistrement Effectuée') {
                    alert_success(msg);
                    setTimeout(function() {
                        window.location.href="Paiement.php";
                    }, 750);
                }else{
                    alert_error(msg);
                }
            }
        });
    }else{
        alert_error('Séléctionner une Méthode de Paiement');
    }
}
</script>
<?php }
?>