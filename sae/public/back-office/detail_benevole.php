<?php
if (!session_id()) session_start();

require_once '../../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

/* =========================
   PROTECTION ACCÈS
========================= */
if (!isset($_SESSION['part']) || $_SESSION['part'] !== true) {
    Messages::goBack("Vous n'avez pas accès à cette page", "danger");
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
   ID BÉNÉVOLE
========================= */
$idBenevole = $_GET['id_benevole'] ?? null;

if (!$idBenevole) {
    Messages::goBack("Bénévole introuvable", "danger");
    exit;
}

$repo = new MariaDBBenevoleRepository($pdo);

/* =========================
   DONNÉES
========================= */
$benevole = $repo->getBenevoleById($idBenevole);
$missionsAVenir = $repo->getMissionsAVenirByBenevole($idBenevole);
$missionsPassees = $repo->getMissionsPasseesByBenevole($idBenevole);
$cotisationsUrgentes = $repo->getCotisationsBientotEcheanceByBenevole($idBenevole);
$cotisationsAutres   = $repo->getAutresCotisationsByBenevole($idBenevole);


if (!$benevole) {
    Messages::goBack("Bénévole inexistant", "danger");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du bénévole</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- TITRE -->
    <h1>
        <i class="bi bi-person-badge-fill me-2"></i>
        Détail du bénévole
    </h1>
    <hr>

    <!-- ACTIONS -->
    <div class="d-flex gap-2 mb-3">
        <a href="benevoles.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <?php Messages::messageFlash(); ?>

    <!-- INFOS BÉNÉVOLE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <i class="bi bi-info-circle-fill me-2"></i>
            Informations du bénévole
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> <?= htmlspecialchars($benevole['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($benevole['prenom']) ?></p>
            <p><strong>Date de naissance :</strong>
                <?= (new DateTime($benevole['date_naissance']))->format('d/m/Y') ?>
            </p>
            <p><strong>Ville :</strong> <?= htmlspecialchars($benevole['ville']) ?></p>
            <p><strong>Profession :</strong> <?= htmlspecialchars($benevole['profession']) ?></p>
            <p>
                <strong>Disponibilité :</strong>
                <?= $benevole['disponibilite']
                    ? '<span class="badge bg-success">Disponible</span>'
                    : '<span class="badge bg-danger">Non disponible</span>' ?>
            </p>
        </div>
    </div>

    <div class="row">

        <!-- MISSIONS À VENIR -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-calendar-check-fill me-2"></i>
                    Missions à venir
                </div>

                <ul class="list-group list-group-flush">
                    <?php if (empty($missionsAVenir)): ?>
                        <li class="list-group-item text-muted">
                            Aucune mission à venir
                        </li>
                    <?php else: ?>
                        <?php foreach ($missionsAVenir as $m): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($m['titre']) ?></strong><br>
                                <small class="text-muted">
                                    <?= htmlspecialchars($m['date']) ?> – <?= htmlspecialchars($m['lieu']) ?>
                                </small>
                                <div class="mt-1">
                                    <a href="detail_mission.php?id_mission=<?= $m['id_mission'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir mission
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- MISSIONS PASSÉES -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="bi bi-clock-history me-2"></i>
                    Missions passées
                </div>

                <ul class="list-group list-group-flush">
                    <?php if (empty($missionsPassees)): ?>
                        <li class="list-group-item text-muted">
                            Aucune mission passée
                        </li>
                    <?php else: ?>
                        <?php foreach ($missionsPassees as $m): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($m['titre']) ?></strong><br>
                                <small class="text-muted">
                                    <?= htmlspecialchars($m['date']) ?> – <?= htmlspecialchars($m['lieu']) ?>
                                </small>
                                <div class="mt-1">
                                    <a href="detail_mission.php?id_mission=<?= $m['id_mission'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir mission
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>
    <div class="row mb-5">

        <!-- COTISATIONS URGENTES -->
        <div class="col-md-6">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Cotisations bientôt à échéance (≤ 1 mois)
                </div>

                <ul class="list-group list-group-flush">
                    <?php if (empty($cotisationsUrgentes)): ?>
                        <li class="list-group-item text-muted">
                            Aucune cotisation urgente
                        </li>
                    <?php else: ?>
                        <?php foreach ($cotisationsUrgentes as $c):
                            // Calcul de la date d'échéance
                            $dateCreation = new DateTime($c['date_']);
                            $dateEcheance = clone $dateCreation;
                            $dateEcheance->modify('+' . $c['duree'] . ' months');
                            ?>
                            <li class="list-group-item">
                                <strong><?= $c['montant'] ?> €</strong><br>
                                <small>
                                    <span class="text-muted">Date création :</span>
                                    <?= $dateCreation->format('d/m/Y') ?><br>
                                    <span class="fw-bold text-danger">Échéance :</span>
                                    <?= $dateEcheance->format('d/m/Y') ?>
                                    <span class="badge bg-danger ms-2"><?= $c['duree'] ?> mois</span>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- AUTRES COTISATIONS -->
        <div class="col-md-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-wallet-fill me-2"></i>
                    Autres cotisations
                </div>

                <ul class="list-group list-group-flush">
                    <?php if (empty($cotisationsAutres)): ?>
                        <li class="list-group-item text-muted">
                            Aucune autre cotisation
                        </li>
                    <?php else: ?>
                        <?php foreach ($cotisationsAutres as $c):
                            // Calcul de la date d'échéance
                            $dateCreation = new DateTime($c['date_']);
                            $dateEcheance = clone $dateCreation;
                            $dateEcheance->modify('+' . $c['duree'] . ' months');
                            ?>
                            <li class="list-group-item">
                                <strong><?= $c['montant'] ?> €</strong><br>
                                <small>
                                    <span class="text-muted">Date création :</span>
                                    <?= $dateCreation->format('d/m/Y') ?><br>
                                    <span class="fw-bold text-primary">Échéance :</span>
                                    <?= $dateEcheance->format('d/m/Y') ?>
                                    <span class="badge bg-primary ms-2"><?= $c['duree'] ?> mois</span>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
