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

//
// Connexion BDD
//
try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

//
// Récupération des adhérents
//
$repo = new MariaDBBenevoleRepository($pdo);
$adherents = $repo->getAdherent();
$_SESSION['id_update'] = "id_adherent";
$_SESSION['table'] = "adherent";

// --- LOGIQUE DE TRI ---
$sort_column = $_GET['sort'] ?? null;
$sort_direction = strtolower($_GET['dir'] ?? 'asc');

if (!empty($adherents) && $sort_column) {
    if (in_array($sort_column, array_keys($adherents[0]))) {
        usort($adherents, function ($a, $b) use ($sort_column, $sort_direction) {
            $val_a = $a[$sort_column];
            $val_b = $b[$sort_column];

            $val_a = is_numeric($val_a) ? (float)$val_a : (string)$val_a;
            $val_b = is_numeric($val_b) ? (float)$val_b : (string)$val_b;

            if ($val_a == $val_b) {
                return 0;
            }

            $comparison = ($val_a < $val_b) ? -1 : 1;

            return ($sort_direction == 'desc') ? -$comparison : $comparison;
        });
    }
}
// --- FIN LOGIQUE DE TRI ---

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Adhérents - Armée du Salut</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <h2 class="highlight">Armée du Salut</h2>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Nos Actions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Missions & Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Adhérents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Faire un don</a>
                </li>
            </ul>
            <div class="btn-container">
                <button class="btn custom-btn1">Connexion</button>
                <button class="btn custom-btn2">Espace Administrateur</button>
            </div>
        </div>
    </div>
</nav>

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
                        <a class="nav-link" href="espace_participant.php">
                            <i class="fas fa-home"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-hands-helping"></i> Bénévoles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adherent.php">
                            <i class="fas fa-users"></i> Adhérents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tasks"></i> Missions & Événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-invoice-dollar"></i> Cotisations
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
                    <div class="avatar">AD</div>
                    <div class="user-info">
                        <strong>Administrateur</strong>
                        <small>Gestion Adhérents</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="fas fa-users"></i> Gestion des Adhérents</h1>
                <p>Consultez et gérez tous les adhérents de l'Armée du Salut.</p>
            </div>

            <a href="espace_participant.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>

            <?php Messages::messageFlash(); ?>

            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="adherent_add.php" class="btn btn-success">
                        <i class="bi bi-person-plus-fill"></i> Ajouter un adhérent
                    </a>
                    <a href="cotisations.php" class="btn btn-primary">
                        <i class="bi bi-cash-coin"></i> Gérer les cotisations
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher un adhérent...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-filter"></i> Filtres
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?filter=actif">Adhérents actifs</a></li>
                            <li><a class="dropdown-item" href="?filter=inactif">Adhérents inactifs</a></li>
                            <li><a class="dropdown-item" href="?filter=tous">Tous les adhérents</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="row mb-4">
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

                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-subtitle">Nouveaux (30j)</h6>
                                    <h3 class="card-title">0</h3>
                                </div>
                                <i class="fas fa-user-plus fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                            <thead class="table-dark">
                            <?php if (!empty($adherents)): ?>
                                <tr>
                                    <th class="text-center">Actions</th>
                                    <th>
                                        <a href="?sort=nom&dir=<?= ($sort_column === 'nom' && $sort_direction === 'asc') ? 'desc' : 'asc' ?>"
                                           class="text-white d-flex justify-content-between align-items-center">
                                            Nom
                                            <?php if ($sort_column === 'nom'): ?>
                                                <i class="bi bi-caret-<?= $sort_direction === 'asc' ? 'up' : 'down' ?>-fill ms-1"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?sort=prenom&dir=<?= ($sort_column === 'prenom' && $sort_direction === 'asc') ? 'desc' : 'asc' ?>"
                                           class="text-white d-flex justify-content-between align-items-center">
                                            Prénom
                                            <?php if ($sort_column === 'prenom'): ?>
                                                <i class="bi bi-caret-<?= $sort_direction === 'asc' ? 'up' : 'down' ?>-fill ms-1"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            <?php endif; ?>
                            </thead>

                            <tbody>
                            <?php if (empty($adherents)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-people display-6 d-block mb-2"></i>
                                        Aucun adhérent enregistré pour le moment.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($adherents as $a):

                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="window.location.href='detail_benevole.php?id_benevole=<?= $a['id_benevole'] ?>'"
                                                    title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($a['nom'] ?? 'Non renseigné') ?></strong>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($a['prenom'] ?? 'Non renseigné') ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm"
                                                    title="Supprimer"
                                                    onclick="confirmDelete(<?= $a['id_benevole'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet adhérent ?</p>
                <p class="text-muted"><small>Cette action est irréversible. Toutes les données associées (cotisations, etc.) seront également supprimées.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Supprimer définitivement</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Confirmation de suppression
    function confirmDelete(idAdherent) {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        confirmBtn.href = 'adherent_delete.php?id_adherent=' + idAdherent;
        deleteModal.show();
    }

    // Recherche en temps réel (exemple basique)
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[type="text"]');
        const tableRows = document.querySelectorAll('tbody tr');

        if (searchInput && tableRows.length > 0) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchTerm) ? '' : 'none';
                });
            });
        }
    });
</script>

</body>
</html>