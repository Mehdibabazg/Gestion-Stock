<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="../assets/dist/img/inventory.png"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Gestion<sup>Stock</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link active" href="../Acceuil/Acceuil.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de Bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="../Saisie_Stock/Saisie_Stock.php">
            <i class="fas fa-barcode"></i>
            <span>Produits Avec Code à Barre</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="../Articles/Articles.php">
        <i class="fas fa-fw fa-archive"></i>
            <span>Produits Sans Code à Barre</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="../Ventes/Vente.php">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span>Ventes</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../Client/Client.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Clients</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../Changer_Prix/changer_prix.php">
            <i class="fas fa-fw fa-tags"></i>
            <span>Changer Prix</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <li class="nav-item">
        <a class="nav-link" href="../Paiement/Paiement.php">
        <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Paiements</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="../Cheque_Emis/cheque_emis.php">
        <i class="fas fa-fw fa-money-check-alt"></i>
            <span>Chéque Emis</span>
        </a>
    </li>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_recap"
            aria-expanded="true" aria-controls="collapse_recap">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Récapitulatif</span>
        </a>
        <div id="collapse_recap" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Récapitulatif:</h6>
                <a class="collapse-item" href="../Recap_Facture/Recap_Facture.php">Factures</a>
                <a class="collapse-item" href="../Recap_BL/Recap_BL.php">BL</a>
                <a class="collapse-item" href="../Devis/liste_devis.php">Devis</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="../Verification_bon/verification_bon.php">
        <i class="fas fa-fw fa-check-circle"></i>
            <span>Vérification Bons</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="../Devis/Devis.php">
            <i class="fas fa-fw fa-clipboard"></i>
            <span>Devis</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="../Caisse/Caisse.php">
        <i class="fas fa-fw fa-cash-register"></i>
            <span>Caisse</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="../Recherche_Detaille/recherche_detaille.php">
        <i class="fas fa-fw fa-search"></i>
            <span>Recherche Détaillé</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../Recherche_Stock/recherche_stock.php">
        <i class="fas fa-search-dollar"></i>
            <span>Recherche Dans Stock</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">