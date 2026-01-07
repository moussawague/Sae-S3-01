<?php
if (!session_id()) session_start();

require_once '../../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

if (!isset($_SESSION['part']) || $_SESSION['part'] !== true) {
    Messages::goBack("vous n'avez pas accès à cette page", "danger");
    exit;
}

// Connexion BDD
try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

// Récupération des adhérents
$repo = new MariaDBBenevoleRepository($pdo);
$adherents = $repo->getAll("sengager");
$missions = $repo->getAll("mission");
$benevoles = $repo->getAll("benevole");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Missions & Événements - Armée du Salut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-xxl navbar-light bg-white">
        <div class="container-fluid">
            <a href="../index.php">
                <img src="../img/logo.png" alt="Armée du Salut" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Armée du salut</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../actualite.html">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../actions_sociales.html">Nos Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../m'engager.html">M'engager</a>
                    </li>
                </ul>
                <div class="btn-container">
                    <a class="nav-link" href="espace_donateur.html"><img src="../img/compte.svg" alt="compte"> Espace donateur</a>
                    <a class="btn custom-btn2" href="../faireDon.html">Faire un don</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<?php Messages::messageFlash(); ?>

<div class="container-fluid mission-dashboard">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 col-md-4 sidebar-menu">
            <div class="sidebar-header">
                <h3><i class="fas fa-tachometer-alt"></i> Tableau de Bord</h3>
            </div>
            <div class="sidebar-content">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-hands-helping"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="benevoles.php">
                            <i class="fas fa-hands-helping"></i> Bénévoles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adherent.php">
                            <i class="fas fa-users"></i> Adhérents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="missions.php">
                            <i class="fas fa-tasks"></i> Missions & Événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-folder"></i> Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Paramètres
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="avatar">MD</div>
                    <div class="user-info">
                        <strong>Marie Dupont</strong>
                        <small>Administratrice</small>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="../espace_donateur.php" class="btn btn-outline-light btn-sm w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 main-content">
            <div class="page-header mb-4">
                <h1><i class="fas fa-users"></i> Gestion des Adhérents</h1>
                <p>Consultez et gérez tous les adhérents de l'Armée du Salut.</p>
            </div>

            <!-- Carte de statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-subtitle">Total benevoles</h6>
                                    <h3 class="card-title"><?= count($benevoles) ?></h3>
                                </div>
                                <i class="fas fa-user-plus fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-subtitle">Total missions</h6>
                                    <h3 class="card-title"><?= count($missions) ?></h3>
                                </div>
                                <i class="fas fa-user-plus fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-subtitle">Total Adhérents</h6>
                                    <h3 class="card-title"><?= count($adherents) ?></h3>
                                </div>
                                <i class="fas fa-users fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="newsletter-section">
            <h3>Restez informé</h3>
            <p class="newsletter-title">Recevez nos actualités et les prochaines missions</p>
            <form class="newsletter-form">
                <input type="email" class="email-input" placeholder="Votre email" required>
                <button type="submit" class="footer-btn">S'abonner</button>
            </form>
        </div>

        <div class="info-section">
            <div class="footer-column">
                <h4>Armée du Salut</h4>
                <p>Association humanitaire œuvrant pour la solidarité et l'entraide depuis 1878.</p>
            </div>
            <div class="footer-column">
                <h4>Liens rapides</h4>
                <p><a href="#">Nos actions</a></p>
                <p><a href="#">Devenir bénévole</a></p>
                <p><a href="#">Faire un don</a></p>
                <p><a href="#">Actualités</a></p>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <p><i class="fas fa-map-marker-alt"></i> 60 rue des Frères, 67000 Strasbourg</p>
                <p><i class="fas fa-phone"></i> 03 88 75 58 58</p>
                <p><i class="fas fa-envelope"></i> contact@armeedusalut.fr</p>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="legal-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">Cookies</a>
                <a href="#">Plan du site</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>