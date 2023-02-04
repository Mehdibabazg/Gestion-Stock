<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion Stock - Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/dist/Fonts/Nunito.css" rel="stylesheet">

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
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php 
                                        if(@$_GET['Empty']==true)
                                        {
                                    ?>
                                        <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Empty'] ?></div>                                
                                    <?php
                                        }
                                    ?>


                                    <?php 
                                        if(@$_GET['Invalid']==true)
                                        {
                                    ?>
                                        <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Invalid'] ?></div>                                
                                    <?php
                                        }
                                    ?>
                                    <form class="user" action="process.php" method="post">
                                        <div class="form-group">
                                            <input type="text" name="Uname" class="form-control form-control-user"
                                                placeholder="Enter Nom d'Utilisateur Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="Password" class="form-control form-control-user"
                                                placeholder="Password">
                                        </div>
                                        <button name="submit" class="btn btn-primary btn-user btn-block">
                                            Connexion
                                    </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Mot de Passe oublié?</a>
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