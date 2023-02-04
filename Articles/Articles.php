<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT * FROM articles ORDER BY id DESC";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div id="modal_new_article" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="reference">Réference :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="reference"></div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="type">Type :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="type"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="qte">Quantite :</label></div>
                    <div class="col-md-6"><input type="number" class="form-control" id="qte"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="prix_achat">Prix Achat :</label></div>
                    <div class="col-md-6"><input type="number" step="0.01" class="form-control" id="prix_achat"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="tva">TVA :</label></div>
                    <div class="col-md-6"><input type="text" value="20.00 %" class="form-control" id="tva"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="fournisseur">Fournisseur :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="fournisseur"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="ajoute_btn" onclick="ajoute_article()">Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Modal EDIT Stock OPEN -->
        <div id="modal_edit_article" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
            <div class="modal-dialog modal-dialog-centered custom-width">
                <div class="modal-content">
                    <div class="modal-body ui-front justify-content-center">
                        <span id="modal_edit"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal EDIT Stock CLOSE -->

        <!-- Modal DELETE Stock OPEN -->
        <div id="modal_delete_article" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
            <div class="modal-dialog modal-dialog-centered custom-width">
                <div class="modal-content">
                    <div class="modal-body ui-front justify-content-center">
                        <span id="modal_delete"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal DELETE Stock CLOSE -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Articles</h6>
                <a href="" class="btn btn-primary btn-md float-right" data-target="#modal_new_article" data-toggle="modal"><i class="fas fa-plus-circle"></i> Nouveau Produit</a> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><center>#</center></th>
                                <th><center>Référence</center></th>
                                <th><center>Type</center></th>
                                <th><center>Quantité</center></th>
                                <th><center>Prix_Achat</center></th>
                                <th><center>TVA</center></th>
                                <th><center>Fournisseur</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($data as $row){ ?>
                            <tr>
                                <td><center><?php echo($row['id']); ?></center></td>
                                <td><center><?php echo ucwords($row['reference']); ?></center></td>
                                <td><center><?php echo ucwords($row['type']); ?></center></td>
                                <td><center><?php echo ucwords($row['quantite']); ?></center></td>
                                <td><center><?php echo number_format($row['prix_achat'],2,',',''); ?></center></td>
                                <td><center><?php echo ucwords($row['TVA']); ?></center></td>
                                <td><center><?php echo ucwords($row['fournisseur']); ?></center></td>
                                <td><center>
                                        <button data-toggle="modal" data-target="#modal_edit_article" 
                                            class="btn btn-sm rounded btn-warning" onclick="modal_edit_article(<?php echo $row['id']; ?>);">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#modal_delete_article" 
                                            class="btn btn-sm rounded btn-danger" onclick="modal_delete_article(<?php echo $row['id']; ?>);">
                                            <i class="fas fa-times-circle"></i>
                                        </button> 
                                    </center>
                                </td> 
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php include '../includes/footer.php'; ?>
<script>
        $(function () {
            $("#reference").autocomplete({
                source: 'autocomplete/autocomplete_ref.php',
                delay: 30
            });
        });
        $(function () {
            $("#type").autocomplete({
                source: 'autocomplete/autocomplete_type.php',
                delay: 30
            });
        });
        $(function () {
            $("#fournisseur").autocomplete({
                source: 'autocomplete/autocomplete_fourn.php',
                delay: 30
            });
        });
    function ajoute_article(){
        var ref = $('#reference').val();
        var type = $('#type').val();
        var qte = $('#qte').val();
        var prix = $('#prix_achat').val();
        var tva = $('#tva').val();
        var fourn = $('#fournisseur').val();
        $.ajax({
            type: "POST",
            url: 'add_article.php',
            data: {ref:ref,type:type,qte:qte,tva:tva,prix:prix,fourn:fourn},
            success:function(msg) {
                alert_success('Enregistrement Effectué Avec Succés');
                    setTimeout(function() {
                        window.location.href="Articles.php";
                    }, 750);
            }
        });
    }
    function modal_edit_article(id){
        $.ajax({
            type: "POST",
            url: 'modal_edit_article.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_edit').html(msg);
            }
        });
    }
    function modal_delete_article(id){
        $.ajax({
            type: "POST",
            url: 'modal_delete_article.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_delete').html(msg);
            }
        });
    }
</script>
<?php }
?>