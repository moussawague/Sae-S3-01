<?php
if (!session_id()) session_start();

require_once '../../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

/* PROTECTION ACCÈS */
if (!isset($_SESSION['part']) || $_SESSION['part'] !== true) {
    Messages::goBack("Vous n'avez pas accès à cette page", "danger");
    exit;
}

/* CONNEXION BDD */
try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

/* RÉCUP ID MISSION */
$idMission = $_GET['id_mission'] ?? null;

if (!$idMission) {
    Messages::goBack("Mission introuvable", "danger");
    exit;
}

/* REPOSITORY */
$repo = new MariaDBBenevoleRepository($pdo);

/* AJOUT BÉNÉVOLE (POST) */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_benevole'])) {
    $idBenevole = (int) $_POST['id_benevole'];

    if ($idBenevole > 0) {
        $repo->addBenevoleToMission($idBenevole, $idMission);
        Messages::goBack(
                "Bénévole ajouté à la mission",
                "success",
                "mission_detail.php?id_mission=$idMission"
        );
    }
}

/* DONNÉES */
$mission          = $repo->getMissionById($idMission);
$benevoles        = $repo->getBenevoleByMission($idMission);
$benevolesDispo   = $repo->getBenevoleSauf($idMission);
$media            = $repo->getMediaByMission($idMission);

if (!$mission) {
    Messages::goBack("Mission inexistante", "danger");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de la mission</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- TITRE -->
    <h1>
        <i class="bi bi-calendar-event-fill me-2"></i>
        Détail de la mission
    </h1>
    <hr>

    <!-- ACTIONS -->
    <div class="d-flex gap-2 mb-3">
        <a href="missions.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>

        <a href="mission_edit.php?id_mission=<?= $idMission ?>" class="btn btn-warning">
            <i class="bi bi-pencil-fill"></i> Modifier la mission
        </a>
    </div>

    <?php Messages::messageFlash(); ?>

    <!-- INFOS MISSION -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning">
            <i class="bi bi-info-circle-fill me-2"></i>
            Informations générales
        </div>
        <div class="card-body">
            <p><strong>Nom :</strong> <?= htmlspecialchars($mission['titre']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($mission['date']) ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($mission['lieu']) ?></p>
            <p><strong>Matériel :</strong> <?= htmlspecialchars($mission['materiel']) ?></p>
            <p><strong>Description :</strong><br>
                <?= nl2br(htmlspecialchars($mission['description'])) ?>
            </p>
        </div>
    </div>

    <div class="row">

        <!-- BÉNÉVOLES -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">

                <div class="card-header">
                    <i class="bi bi-people-fill me-2"></i>
                    Bénévoles inscrits
                </div>

                <!-- AJOUT BÉNÉVOLE -->
                <div class="card-body border-bottom">
                    <?php if (!empty($benevolesDispo)): ?>
                        <form method="post" class="d-flex gap-2">
                            <select name="id_benevole" class="form-select" required>
                                <option value="">-- Ajouter un bénévole --</option>
                                <?php foreach ($benevolesDispo as $bd): ?>
                                    <option value="<?= $bd['id_benevole'] ?>">
                                        <?= htmlspecialchars($bd['nom']) ?>
                                        <?= htmlspecialchars($bd['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="text-muted mb-0">
                            Tous les bénévoles sont déjà inscrits
                        </p>
                    <?php endif; ?>
                </div>

                <!-- LISTE BÉNÉVOLES -->
                <ul class="list-group list-group-flush">
                    <?php if (empty($benevoles)): ?>
                        <li class="list-group-item text-muted">
                            Aucun bénévole inscrit
                        </li>
                    <?php else: ?>
                        <?php foreach ($benevoles as $b): ?>
                            <li class="list-group-item">
                                <?= htmlspecialchars($b['nom']) ?>
                                <?= htmlspecialchars($b['prenom']) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

            </div>
        </div>

        <!-- MÉDIAS -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-file-earmark-text-fill me-2"></i>
                        Documents associés
                    </span>
                    <a href="media_add.php?id_mission=<?= $idMission ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-upload"></i> Ajouter
                    </a>
                </div>

                <ul class="list-group list-group-flush">
                    <?php if (empty($media)): ?>
                        <li class="list-group-item text-muted">
                            Aucun document
                        </li>
                    <?php else: ?>
                        <?php foreach ($media as $m): ?>
                            <li class="list-group-item">
                                <a href="<?= htmlspecialchars($m['chemin']) ?>" target="_blank">
                                    <?= htmlspecialchars($m['nom']) ?>
                                </a>
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
