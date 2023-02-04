<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion Stock - Réinitialisation du mot de passe</title>

    <!-- Custom fonts for this template-->
    <link href="assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/dist/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Mot de Passe Oublié?</h1>
                                        <p class="mb-4">On comprend, il se passe des choses. 
                                        Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                                    </div>
                                    <form class="user" action="forgot-password" method='POST'>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <button name="submit" class="btn btn-primary btn-user btn-block">
                                            Réinitialiser le mot de passe
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Vous avez déja un compte? Connexion!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/plugins/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/dist/js/sb-admin-2.min.js"></script>

</body>

</html>
<?php 
if ($_POST['submit']) {
    $email = $_POST['email'];
    require 'DataSet/db.php';
    $query="select * from utilisateurs where email = '$email'";
    $result=$pdo->query($query);
    if($result){
        $body = 'Voila le lien pour Réinitialiser le mot de passe de votre compte :<br>'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'';
        $objet = 'Réinitialisation du mot de passe';
        mail($email,$objet,$body);
    }
}?>