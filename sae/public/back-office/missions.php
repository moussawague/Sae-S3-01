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
// Récupération des bénévoles
//
$repo = new MariaDBBenevoleRepository($pdo);
$missions = $repo->getAll("mission");
$benevoles = $repo->getparticipeMission();
$_SESSION['id_update'] ="id_mission";
$_SESSION['table'] ="mission";

// --- LOGIQUE DE TRI ---
$sort_column = $_GET['sort'] ?? null;
$sort_direction = strtolower($_GET['dir'] ?? 'asc');

if (!empty($missions) && $sort_column) {
    if (in_array($sort_column, array_keys($missions[0]))) {

        usort($missions, function ($a, $b) use ($sort_column, $sort_direction) {
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
    <title>Gestion des Missions - Armée du Salut</title>
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
                    <a class="nav-link active" href="#">Missions & Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">M'engager</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Faire un don</a>
                </li>
            </ul>
            <div class="btn-container">
                <button class="btn custom-btn1">Connexion</button>
                <button class="btn custom-btn2">Espace Bénévole</button>
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
                            <i class="fas fa-users"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-hands-helping"></i> Bénévoles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Adhérents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
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
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="fas fa-tasks"></i> Gestion des Missions</h1>
                <p>Consultez et gérez toutes les missions de l'Armée du Salut.</p>
            </div>

            <a href="espace_participant.php" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>

            <?php Messages::messageFlash(); ?>

            <a href="mission_add.php" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Ajouter une mission
            </a>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                            <thead class="table-dark">
                            <?php if (!empty($missions)): ?>
                                <tr>
                                    <th class="text-center" style="width: 120px;">Actions</th>

                                    <?php foreach (array_slice(array_keys($missions[0]), 0, 3) as $col):
                                        $new_dir = ($sort_column === $col && $sort_direction === 'asc') ? 'desc' : 'asc';
                                        $icon = '';
                                        if ($sort_column === $col) {
                                            $icon = $sort_direction === 'asc' ? '<i class="bi bi-caret-up-fill ms-1"></i>' : '<i class="bi bi-caret-down-fill ms-1"></i>';
                                        }
                                        ?>
                                        <th>
                                            <a href="?sort=<?= urlencode($col) ?>&dir=<?= $new_dir ?>"
                                               class="text-white d-flex justify-content-between align-items-center">
                                                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $col))) ?>
                                                <?= $icon ?>
                                            </a>
                                        </th>
                                    <?php endforeach; ?>

                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            <?php endif; ?>
                            </thead>

                            <tbody>
                            <?php foreach ($missions as $m): ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="detail_mission.php?id_mission=<?= $m['id_mission'] ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Voir mission
                                        </a>
                                    </td>

                                    <?php foreach (array_slice($m, 0, 3, true) as $key => $val): ?>
                                        <td><?= !empty($val) ? htmlspecialchars($val) : '<span class="text-muted fst-italic">non renseigné</span>' ?></td>
                                    <?php endforeach; ?>

                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm benevoles"
                                                data-id-mission="<?= $m['id_mission'] ?>">
                                            <i class="bi bi-people-fill"></i> Bénévoles
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALE BÉNÉVOLES -->
<div class="modal fade" id="benevolesModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="bi bi-people-fill me-2"></i> Bénévoles de la mission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                    </tr>
                    </thead>
                    <tbody id="benevolesBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const benevoles = <?= json_encode($benevoles) ?>;

        const buttons = document.querySelectorAll('.benevoles');
        const tbody   = document.getElementById('benevolesBody');
        const modal   = new bootstrap.Modal(document.getElementById('benevolesModal'));

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const idMission = button.dataset.idMission;
                tbody.innerHTML = '';

                const liste = benevoles.filter(b =>
                    b.id_mission == idMission
                );

                if (liste.length === 0) {
                    tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-muted fst-italic">
                            Aucun bénévole pour cette mission
                        </td>
                    </tr>
                `;
                } else {
                    liste.forEach(b => {
                        tbody.innerHTML += `
                        <tr>
                            <td>${b.nom}</td>
                            <td>${b.prenom}</td>
                        </tr>
                    `;
                    });
                }

                modal.show();
            });
        });
    });
</script>

</body>
</html>