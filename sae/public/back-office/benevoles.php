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

/* =========================
   CONNEXION BDD
========================= */
try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

/* =========================
   DONNÉES
========================= */
$repo = new MariaDBBenevoleRepository($pdo);
$benevoles = $repo->getAll("benevole");


/* =========================
   COLONNES AFFICHÉES
========================= */
$columns = [
        'id_benevole'    => 'ID',
        'nom'            => 'Nom',
        'prenom'         => 'Prénom',
        'date_naissance' => 'Date',
        'ville'          => 'Ville',
        'profession'     => 'Profession',
        'disponibilite'  => 'Disponibilité'
];

/* =========================
   FILTRES
========================= */
$filter_ville = $_GET['filter_ville'] ?? '';
$filter_profession = $_GET['filter_profession'] ?? '';
$filter_dispo = $_GET['filter_dispo'] ?? '';
$filter_age_min = (int)($_GET['filter_age_min'] ?? 0);
$filter_age_max = (int)($_GET['filter_age_max'] ?? 0);

$filtered_benevoles = array_filter($benevoles, function ($b) use (
        $filter_ville,
        $filter_profession,
        $filter_dispo,
        $filter_age_min,
        $filter_age_max
) {
    if ($filter_ville && stripos($b['ville'], $filter_ville) === false) return false;
    if ($filter_profession && stripos($b['profession'], $filter_profession) === false) return false;
    if ($filter_dispo !== '' && (int)$b['disponibilite'] !== (int)$filter_dispo) return false;

    if (($filter_age_min || $filter_age_max) && $b['date_naissance']) {
        $age = (new DateTime($b['date_naissance']))->diff(new DateTime())->y;
        if ($filter_age_min && $age < $filter_age_min) return false;
        if ($filter_age_max && $age > $filter_age_max) return false;
    }
    return true;
});

/* =========================
   TRI
========================= */
$sort_column = $_GET['sort'] ?? null;
$sort_direction = $_GET['dir'] ?? 'asc';

if ($sort_column && isset($columns[$sort_column])) {
    usort($filtered_benevoles, function ($a, $b) use ($sort_column, $sort_direction) {
        $cmp = $a[$sort_column] <=> $b[$sort_column];
        return $sort_direction === 'desc' ? -$cmp : $cmp;
    });
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des bénévoles - Armée du Salut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
                            <i class="fas fa-users"></i> accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-hands-helping"></i> Bénévoles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
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
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="fas fa-hands-helping"></i> Gestion des Bénévoles</h1>
                <p>Consultez et gérez tous les bénévoles de l'Armée du Salut.</p>
            </div>

            <!-- BOUTON AJOUTER UN BÉNÉVOLE (remplace le bouton Retour) -->
            <a href="benevole_add.php" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Ajouter un bénévole
            </a>

            <?php Messages::messageFlash(); ?>

            <!-- FILTRES -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="get" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Ville</label>
                            <input class="form-control form-control-sm" name="filter_ville"
                                   value="<?= htmlspecialchars($filter_ville) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Profession</label>
                            <input class="form-control form-control-sm" name="filter_profession"
                                   value="<?= htmlspecialchars($filter_profession) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Disponibilité</label>
                            <select class="form-select form-select-sm" name="filter_dispo">
                                <option value="">Toutes</option>
                                <option value="1" <?= $filter_dispo === '1' ? 'selected' : '' ?>>Disponible</option>
                                <option value="0" <?= $filter_dispo === '0' ? 'selected' : '' ?>>Non disponible</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Âge min</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="filter_age_min" value="<?= $filter_age_min ?: '' ?>">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Âge max</label>
                            <input type="number" class="form-control form-control-sm"
                                   name="filter_age_max" value="<?= $filter_age_max ?: '' ?>">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABLEAU -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th style="width:120px">Actions</th>
                            <?php foreach ($columns as $col => $label): ?>
                                <th>
                                    <a class="text-white text-decoration-none"
                                       href="?sort=<?= $col ?>&dir=<?= ($sort_column === $col && $sort_direction === 'asc') ? 'desc' : 'asc' ?>">
                                        <?= $label ?>
                                    </a>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($filtered_benevoles)): ?>
                            <tr>
                                <td colspan="<?= count($columns)+1 ?>" class="text-center text-danger fst-italic">
                                    Aucun bénévole trouvé
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($filtered_benevoles as $b): ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="detail_benevole.php?id_benevole=<?= urlencode($b['id_benevole']) ?>"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Détails
                                        </a>
                                    </td>

                                    <?php foreach ($columns as $key => $label): ?>
                                        <td>
                                            <?php
                                            if ($key === 'disponibilite') {
                                                echo $b[$key]
                                                        ? '<span class="badge bg-success">Disponible</span>'
                                                        : '<span class="badge bg-danger">Non disponible</span>';
                                            } elseif ($key === 'date_naissance') {
                                                echo (new DateTime($b[$key]))->format('d/m/Y');
                                            } else {
                                                echo htmlspecialchars($b[$key]);
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>