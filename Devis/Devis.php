<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT * FROM client ORDER BY id DESC";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card bg-gray-200">
            <div class="container-fluid">
                <div class="p-2 d-flex row ">
                    <span class="badge badge-danger badge-counter" id='prix_vente' style="display:none;"></span>
                    <div class="row p-2 col-lg-12 d-flex justify-content-center"> 
                        <label class="form-label p-2" for="societe">Société :</label>
                        <div class="col-lg-4 mt-1">
                            <select class="form-control js-example-basic-single" id="societe">
                                    <?php
                                    foreach ($data as $row){ ?>
                                    <option value='<?php echo $row['id'];?>'><?php echo $row['societe'];?></option>
                                    <?php   } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2 col-lg-12 d-flex justify-content-center">
                        <label class="form-label p-2" for="reference">Référence :</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" id="reference">
                        </div>
                        <label class="form-label p-2" for="type">Type :</label>
                        <div class="col-lg-3">
                            <input type="text" class='form-control' id='type'>
                        </div>
                    </div>
                    <div class="row p-2 col-lg-9 d-flex justify-content-center">
                        <label class="form-label p-2" for="qte">Quantité :</label>
                        <div class="col-lg-3">
                            <input type='number' class="form-control" id="qte">
                        </div>
                        <label class="form-label p-2" for="prix_TTC" id='lbl_prix'>Prix TTC :</label>
                        <div class="col-lg-3">
                            <input type="number" class='form-control prix_TTC' id='prix_TTC'>
                        </div>
                        <span class="badge badge-danger badge-counter" id='prix_vente' style="display:none;"></span>
                    </div>
                    <div class="p-2">
                        <button type="button" id="btnAdd" class="btn btn-primary" >Ajouter</button>
                        <button type="button" class="btn btn-success" id='print'>Imprimer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2 float-left">
            <input id='total' class="bg-primary text-white form-control rounded" disabled>
        </div>           
        <div class="pt-2">
            <div class="col-md-12 col-sm-12 col-12 p-2 table-responsive">
                <table id="tblData" class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Type</th>
                            <th>Quantite</th>
                            <th>Prix TTC</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive" id="devis_liste">

            </div>
        </div>
    </div>
</div>



<?php include '../includes/footer.php'; ?>
<script>

$(function () {
    $("#reference").autocomplete({
        source: 'autocomplete_reference.php',
        delay: 30
    });
});
$(function () {
    $("#type").autocomplete({
        source: 'autocomplete_type.php',
        delay: 30
    });
});

$(document).ready(function(){
    $("#reference").on("change", function(){
      var reference = $("#reference").val();
      $.ajax({
        type: "POST",
        url: 'get_type.php',
        data: {reference:reference},
        success:function(msg) {
            $('#type').val(msg);
        }
      });
    });
});

$(document).ready(function(){
    $("#reference").on("change", function(){
        var reference = $("#reference").val();
      $.ajax({
        type: "POST",
        url: 'get_prix.php',
        data: {reference:reference},
        success:function(msg) {
           // $('#lbl_prix').attr('title', msg);
           $("#lbl_prix").mouseover(function(){
                $("#prix_vente").css("display", "block");
                $("#prix_vente").html(msg);
            });
            $("#lbl_prix").mouseout(function(){
                $("#prix_vente").css("display", "none");
            });
        }
      }) 
    });
});

    var emptyRow = "<tr><td colspan='5' class='text-center'>Aucune Données Saisie !</td></tr>";
        $(document).ready(function () {
            //debugger;
            $("#tblData tbody").append(emptyRow); // adding empty row on page load

            $("#btnAdd").click(function () { 
                var reference = $("#reference").val().trim();
                var type = $("#type").val().trim();
                var qte = $("#qte").val().trim();
                var prix_ttc = $("#prix_TTC").val().trim();

                if (reference != "" && type != "" && qte != "" && prix_ttc != "") { // validation
                   // debugger;
                    if ($("#tblData tbody").children().children().length == 1) {
                        $("#tblData tbody").html("");
                    }
                   // var srNo = $("#tblData tbody").children().length + 1;
                    // creating dynamic html string
                    var dynamicTr = "<tr><td>"+reference+"</td><td>" + type + "</td><td>" + qte + "</td><td>" + prix_ttc + "</td><td> <i role='button' class='fas fa-trash-alt text-danger btn-sm'></i> </td></tr>";
                    // dynamicTr += "<tr><td>"+Calculer()"</td><td>" ;
                    //debugger; 
                    $("#tblData tbody").append(dynamicTr); // appending dynamic string to table tbody
                    $("#reference").val("");
                    $("#type").val("");
                    $("#qte").val("");
                    $("#prix_TTC").val("");
                    $(".btn-sm").click(function () { // registering function for delete button
                        //debugger;
                        $(this).parent().parent().remove();
                        if ($("#tblData tbody").children().children().length == 0) {
                            $("#tblData tbody").append(emptyRow);
                        }
                        Calculer();
                    });
                    $('#reference').focus();

                    Calculer();

                } else {
                    alert_error("Merci de Remplir Tous les Champs !");
                }
            });

        });
        function Calculer() {
            var sum = 0;
            $('tr:not(:first)').each(function(){
                sum += parseFloat($('td:eq(2)',$(this)).text()) * parseFloat($('td:eq(3)',$(this)).text());
            });
            if (sum) {
                $('#total').val(sum.toFixed(2));
            }
            else{
                $('#total').val('');
            }         
        }
    $("document").ready(function() {
        $("#print").click(function () { 
            <?php
                $num_devis_req = $pdo->query("CALL Inc_devis()");
                $num_devis = $num_devis_req->fetch(PDO::FETCH_ASSOC);
                $num_devis_req->closeCursor();
                $num_devis = $num_devis['num']; 
            ?>
            var id_client = $('#societe').val();
            var societe = $('#societe :selected').text();
            var total = $('#total').val();
            var TableData = new Array();
            var num_devis = '<?php echo $num_devis; ?>';
            $('#tblData tbody tr').each(function(row, tr) {
                TableData[row] = {
                    "reference": $(tr).find('td:eq(0)').text(),
                    "type": $(tr).find('td:eq(1)').text(),
                    "qte": $(tr).find('td:eq(2)').text(),
                    "prix": $(tr).find('td:eq(3)').text()
                }
            });
            var Data;
            Data = JSON.stringify(TableData);
            $.ajax({
                type: "POST",
                url: "../pdf/devis_pdf.php",
                data: {pTableData:Data,societe:societe,id_client:id_client,num_devis:num_devis,total:total},
                success: function(msg) {
                    window.open('../Files/Devis/Devis '+num_devis.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
                    window.location.reload();
                }
            });
        });
    });
</script>
<?php }
?>