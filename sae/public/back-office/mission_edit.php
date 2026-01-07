<?php
if (!session_id()) session_start();

require_once '../../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

if (!isset($_SESSION['part']) || $_SESSION['part'] !== true) {
    Messages::goBack("Vous n'avez pas accès à cette page", "danger");
    exit;
}

try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

$idMission = $_GET['id_mission'] ?? null;

if (!$idMission) {
    Messages::goBack("Mission introuvable", "danger");
    exit;
}

$repo = new MariaDBBenevoleRepository($pdo);
$mission = $repo->getMissionById($idMission);

if (!$mission) {
    Messages::goBack("Mission inexistante", "danger");
    exit;
}

/* TRAITEMENT FORMULAIRE */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $date = $_POST['date'];
    $lieu = trim($_POST['lieu']);
    $materiel = trim($_POST['materiel']);
    $description = trim($_POST['description']);

    if (empty($titre) || empty($date) || empty($lieu)) {
        Messages::message("Champs obligatoires manquants", "danger");
    } else {
        $repo->updateMission(
            $idMission,
            $titre,
            $date,
            $lieu,
            $materiel,
            $description
        );

        Messages::goBack("Mission modifiée avec succès", "success", "mission_detail.php?id_mission=$idMission");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la mission</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1>
        <i class="bi bi-pencil-fill me-2"></i>
        Modifier la mission
    </h1>

    <hr>

    <a href="detail_mission.php?id_mission=<?= $idMission ?>" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    <?php Messages::messageFlash(); ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control"
                           value="<?= htmlspecialchars($mission['titre']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date et heure *</label>
                    <input type="datetime-local"
                           name="date"
                           class="form-control"
                           value="<?= date('Y-m-d\TH:i', strtotime($mission['date'])) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lieu *</label>
                    <input type="text" name="lieu" class="form-control"
                           value="<?= htmlspecialchars($mission['lieu']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Matériel</label>
                    <input type="text" name="materiel" class="form-control"
                           value="<?= htmlspecialchars($mission['materiel']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($mission['description']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save-fill"></i> Enregistrer les modifications
                </button>

            </form>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
