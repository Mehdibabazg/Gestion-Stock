<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$id_client=$_GET['id_client']; 
$sql = "SELECT id, nom, societe FROM client WHERE id = '$id_client'";
$data = $pdo->query($sql);
$row = $data->fetch(PDO::FETCH_ASSOC);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
    <div id="vente_article" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-body ui-front" style="background-color: #EAE7C6;">
          <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
            <div class="col-md row justify-content-center">
              <div class="col-md-2"><strong>Client</strong></div>
              <div class="col-md-4"><input type="text" class="form-control" value="<?php echo($row['nom']);?>" disabled></div>
              <div class="col-md-4"><input type="text" class="form-control" value="<?php echo($row['societe']);?>" disabled></div>
            </div><br>
            <div class="col-md row justify-content-center">
              <div class="col-md-2"><strong>N° BON</strong></div>
              <div class="col-md-2"><input type="text" class="form-control" id="bon" name="bon" value="" required="required"></div>
              <div class="col-md-2"><strong>Date de vente</strong></div>
              <div class="col-md-4"><input type="date" class="form-control" id="dateV" value="<?php echo date('Y-m-d'); ?>"></div>
            </div><br>
            <div class="col-md row justify-content-center">
              <div class="col-md-2"><strong>Réference</strong></div>
              <div class="col-md-4"><input type="text" class="form-control" id="ref" name="ref" value="" required="required"></div>
              <div class="col-md-4"></div>
            </div><br>
            <div class="col-md row justify-content-center">
              <div class="col-md-2"><strong>Quantité</strong></div>
              <div class="col-md-3"><input type="text" class="form-control" id="qte" name="qte" value="" onChange="verifier()" required="required"></div>
              <div class="col-md-5"></div>
            </div><br>
            <div class="col-md row justify-content-center">
              <div class="col-md-2"><strong>Prix de Vente</strong></div>
              <div class="col-md-3"><input type="text" class="form-control" id="prixV" name="prixV" value="" required="required"></div>
              <div class="col-md-5"></div>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-space btn-success mt-2" id="ajoute_btn" onclick="ajoute_vente_article()">Valider</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Sales product modal close -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="card bg-gray-200">
        <div class="card-header">
          <h6 class="text-center font-weight-bold text-primary">
            <i class="fas fa-keyboard"></i> Saisir Une Vente </h6>
        </div>
        <div class="card-body">
          <div class="col-lg row justify-content-center">
            <div class="col-lg-2">
              <input value="Client" class="bg-primary text-white form-control rounded" disabled>
            </div>
            <div class="col-lg-2">
              <input type="text" class="form-control" value="<?php echo($row['nom']);?>" disabled>
            </div>
            <div class="col-lg-2">
              <input type="text" class="form-control" value="<?php echo($row['societe']);?>" disabled>
            </div>
            <div class="col-lg-3">
              <input type="date" class="form-control" id="date_vente" value="<?php echo date('Y-m-d'); ?>" />
            </div>
          </div><br>
          <div class="col-lg row justify-content-center">
            <div class="col-lg-1">
              <label class="control-label">N°BON:</label>
            </div>
            <div class="col-lg-2">
              <input type="text" class="form-control" id="n_bon" name="n_bon" value="" required="required">
            </div>
            <div class="col-lg-1">
              <label class="control-label">Prix Vente:</label>
            </div>
            <div class="col-lg-2">
              <input type="text" class="form-control" id="prix_vente" name="prix_vente" value="" required="required">
            </div>
            <div class="col-lg-1">
              <label class="label">N° Série :</label>
            </div>
            <div class="col-lg-2">
              <input type="text" class="form-control" id="n_serie" name="n_serie" value="" required="required">
            </div>
            <div class="col-lg-3">
              <button class="btn btn-info" onclick="open_modal();" id="AP"><i class="fas fa-plus-square"></i> Autres Article</button>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-info mt-2" id="valider" onclick="ajoute_vente_stock()">Valider</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="card shadow mb-4" id="table_results" style="visibility: hidden;">

</div>
<?php include '../includes/footer.php'; ?>
<script>
    $(document).keypress(function(e){
    if (e.which == 13){
        $("#valider").click();
    }
  });
  function ajoute_vente_stock() {
    var id = '<?php echo $id_client; ?>';
    var n_bon = $('#n_bon').val();
    var date_vente = $('#date_vente').val();
    var prix_vente = $('#prix_vente').val();
    var n_serie = $('#n_serie').val();
    $.ajax({
      type: "POST",
      url: 'ajoute_vente_stock.php',
      data: {id:id,n_bon:n_bon,date_vente:date_vente,prix_vente:prix_vente,n_serie:n_serie},
      success:function(msg) {
        if (msg == "Proudit est Vendu Déja" || msg == "N° Série n'exsite pas dans le Stock" || msg == "Remplis Tous les Champs S'il Vous Plait !!!" || msg == "Vérifier le Prix!!"){
          alert_error(msg);
        }else{
          $("#table_results").css('visibility', 'visible');
          $("#table_results").html(msg);
          $("#n_serie").val("");
          $("#n_serie").focus();
        }
      }
    });
  }
  function open_modal(){
    var bon = $('#n_bon').val();
    if (bon == '') {
      alert_error('Saisie le N° BON');
    }else{
      $("#vente_article").modal('show');
      $("#bon").val(bon);
    }
  }
  $(function () {
    $("#ref").autocomplete({
      source: 'autocomplete/autocomplete_ref.php',
      delay: 30
    });
  });
  function verifier(){
    var qte = $("#qte").val();
    var ref = $("#ref").val();
    $.ajax({
      type: 'POST',
      url: 'verif_qte.php',
      data: {qte:qte,ref:ref},
      success: function(msg){
        if (msg == ''){
          $('#prixV').focus();
        }else{
          alert_error(msg);
          $('#qte').val('');
          $('#qte').focus();
        }
      }
    });
  }

  function ajoute_vente_article() {
    var id = '<?php echo $id_client; ?>';
    var ref = $('#ref').val();
    var bon = $('#bon').val();
    var dateV = $('#dateV').val();
    var prixV = $('#prixV').val();
    var qte = $('#qte').val();
    $.ajax({
      type: "POST",
      url: 'ajoute_vente_article.php',
      data: {id:id,ref:ref,bon:bon,dateV:dateV,prixV:prixV,qte:qte},
      success:function(msg) {
        if (msg == "Vérifier la Quantité!!" || msg == "Vérifier le Prix!!"){
          alert_error(msg);
        }else{
          $("#table_results").css('visibility', 'visible');
          $("#table_results").html(msg);
          $("#ref").val("");
          $("#qte").val("");
          $("#prixV").val("");
          $("#ref").focus();
        }
      }
    });
  }
</script>
<?php }
?>