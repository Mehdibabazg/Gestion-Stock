<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
/*$sql = "SELECT * FROM stock ORDER BY id DESC";
$data = $pdo->query($sql);*/
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="card bg-gray-200">
        <div class="card-header" id="div_show" role="button">
          <h6 class="text-center font-weight-bold text-primary">
            <i class="fas fa-keyboard"></i> Saisie Stock 
            <i class="fas fa-angle-double-down float-right mt-2" id='show'></i>
          </h6>
        </div>
        <div class="card-body" id="saisie_stock" style="display:none;">
            <div class="row">
              <div class="col-lg-4"></div>
              <div class="col-lg">
                <label class="label text-center">Référence : </label>
                <input type="text" placeholder="Enter Référence..." id="ref" name="reference" class="form-control" autocomplete="off" /> 
              </div>
              <div class="col-lg-4"></div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4"></div>
              <div class="col-lg">
                <label class="control-label">Type :</label>  
                <input type="text" placeholder="Enter type..." id="type" name="type" class="form-control" autocomplete="off" >
              </div>
              <div class="col-lg-4"></div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4"></div>
              <div class="col-lg">
                <label class="control-label">Fournisseur : </label>
                <input type="text" placeholder="Enter Fournissuer..." id="fourn" name="fournisseur" class="form-control input-xs" autocomplete="off"> 
              </div>
              <div class="col-lg-4"></div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4"></div>
              <div class="col-lg">
                <label class="control-label">Numéro Série :</label>    
                <input type="text" placeholder="Enter N° Série..." id="n_serie" name="n_serie" class="form-control input-xs" autocomplete="off">
              </div>
              <div class="col-lg-4"></div>
            </div>
            <div class="col-lg-12 mt-2">
                <button class="btn btn-space md-trigger btn-success" style="float:right;" id='valider' onclick="ajoute_stock()">Valider</button>
            </div>
        </div>
      </div>
      <h6 class="mt-4 font-weight-bold text-primary">Liste des Produits</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th><center>#</center></th>
                      <th><center>Réference</center></th>
                      <th><center>Type</center></th>
                      <th><center>N_serie</center></th>
                      <th><center>fournisseur</center></th>
                      <th><center>Date d'entre</center></th>
                      <th><center>N_bon</center></th>
                      <th><center>Etat de vente</center></th>
                      <th><center>Date de Vente</center></th>
                      <th><center>Prix de Vente</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
  var table = '';
  const FROM_PATTERN = 'YYYY-MM-DD';
  const TO_PATTERN   = 'DD/MM/YYYY';
  $( document ).ready(function() {
    table = $('#example').DataTable( {
      "ajax": "data.php",
      "columns": [
        { mData: 'id' } ,
        { mData: 'reference' },
        { mData: 'type' },
        { mData: 'N_serie' },
        { mData: 'fournisseur' },
        { mData: 'date_entre' },
        { mData: 'N_bon' },
        { mData: 'etat_vente' },
        { mData: 'date_vente' },
        { mData: 'prix_vente' }
      ],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
      },
      columnDefs: [{
        render: $.fn.dataTable.render.moment(FROM_PATTERN, TO_PATTERN),
        targets: 5
      }],
    });
  });
  $(function () {
    $("#ref").autocomplete({
      source: 'autocomplete/filtre_ref.php',
      delay: 30
    });
  });
  $(document).ready(function(){
    $("#ref").on("change", function(){
      var ref = $("#ref").val();
      $.ajax({
        type: "POST",
        url: 'autocomplete/get_type.php',
        data: {ref:ref},
        success:function(msg) {
            $('#type').val(msg);
        }
      }); 
    });
  });
  $(function () {
    $("#type").autocomplete({
        source: 'autocomplete/filtre_type.php',
        delay: 30
    });
  });
  $(function () {
    $("#fourn").autocomplete({
        source: 'autocomplete/filtre_fourn.php',
        delay: 30
    });
  });
  $('#div_show').click(function() {
    if ($('#saisie_stock').css('display') == 'none') {
      $('#saisie_stock').toggle('slow');
      $("#show").removeClass("fa-angle-double-down").addClass("fa-angle-double-up");
    }else{
      $('#saisie_stock').hide(500)
      $("#show").removeClass("fa-angle-double-up").addClass("fa-angle-double-down");
    }
  });
  $(document).keypress(function(e){
    if (e.which == 13){
        $("#valider").click();
    }
  });
  function ajoute_stock(){
    var ref = $('#ref').val();
    var type = $('#type').val();
    var fourn = $('#fourn').val();
    var n_serie = $('#n_serie').val();
    if(ref == '' || type == '' || fourn == '') {
      alert_error(" Remplir Tous les Champs S'il vous Plait");
    }else{
      $.ajax({
        type: "POST",
        url: 'ajoute_stock.php',
        data: {ref:ref,type:type,fourn:fourn,n_serie:n_serie},
        success:function(msg) {
          if (msg == 'Enregitrement Efféctué' || msg == 'Mise à Jour Effectuée'){
            alert_success(msg);
            table.ajax.reload(null, false);
            $("#n_serie").val("");
            $("#n_serie").focus();
          }else{
            alert_error(" "+msg);
          }
        }
      });
    }
  }
</script>
<?php }
?>