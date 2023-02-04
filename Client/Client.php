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
<div id="modal_new_client" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="nom">Nom :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="nom"></div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="societe">Société :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="societe"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="phone">Telephone :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="phone"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="email">Email :</label></div>
                    <div class="col-md-6"><input type="email" class="form-control" id="email"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="adresse">Adresse :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="adresse"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="ajoute_btn" onclick="ajoute_client()">Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal EDIT Stock OPEN -->
<div id="modal_edit_client" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
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
<div id="modal_delete_client" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
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
        <h6 class="m-0 font-weight-bold text-primary">Liste des clients</h6>
        <a href="" class="btn btn-primary btn-md float-right" data-target="#modal_new_client" data-toggle="modal"><i class="fas fa-plus-circle"></i> Nouveau Client</a> 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>Id</center></th>
                        <th><center>Nom</center></th>
                        <th><center>Societe</center></th>
                        <th><center>Téléphone</center></th>
                        <th><center>Email</center></th>
                        <th><center>Adresse</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo($row['id']);  ?></center></td>
                        <td><center><?php echo ucwords($row['nom']); ?></center></td>
                        <td><center><?php echo ucwords($row['societe']); ?></center></td>
                        <td><center><?php echo ucwords($row['gsm']); ?></center></td>
                        <td><center><?php echo ucwords($row['email']); ?></center></td>
                        <td><center><?php echo ucwords($row['adresse']); ?></center></td>
                        <td class="col-md-2"><center>
                            <a title="Historique Des Ventes" href="historique_vente.php?id_client=<?php echo($row['id']);?>&societe=<?php echo($row['societe']);?>" class="btn btn-sm btn-success">
                            <i class="fas fa-file-alt"></i></a>
                            <button title="Modifier" data-toggle="modal" data-target="#modal_edit_client" class="btn btn-sm btn-warning" onclick="modal_edit_client(<?php echo $row['id']; ?>);">
                            <i class="fas fa-edit"></i></button>
                            <button title="Supprimer" data-toggle="modal" data-target="#modal_delete_client" class="btn btn-sm btn-danger" onclick="modal_delete_client(<?php echo $row['id']; ?>);">
                            <i class="fas fa-times-circle"></i></button>
                        </center></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
    function ajoute_client(){
        var nom = $('#nom').val();
        var societe = $('#societe').val();
        var phone = $('#phone').val();
        var email = $('#email').val();
        var adresse = $('#adresse').val();
        if (nom == '' || societe == '') {
                alert("S'il Vous Plaît Remplir Nom et Société!!");
        }else{
            $.ajax({
                type: "POST",
                url: 'add_client.php',
                data: {nom:nom,societe:societe,phone:phone,email:email,adresse:adresse},
                success:function(msg) {
                    alert_success('Enregistrement Effectué Avec Succés');
                    setTimeout(function() {
                        window.location.href="Client.php";
                    }, 750);
                }
            });
        }
    }
    function modal_edit_client(id){
        $.ajax({
            type: "POST",
            url: 'modal_edit_client.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_edit').html(msg);
            }
        });
    }
    function modal_delete_client(id){
        $.ajax({
            type: "POST",
            url: 'modal_delete_client.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_delete').html(msg);
            }
        });
    }
</script>
<?php }
?>