<?php
if (!session_id()) session_start();

require_once '../../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

/* ======================
   PROTECTION ACCÈS
   ====================== */
if (!isset($_SESSION['part']) || $_SESSION['part'] !== true) {
    Messages::goBack("Accès refusé", "danger");
    exit;
}

/* ======================
   CONNEXION BDD
   ====================== */
try {
    $bdd = new BddConnect();
    $pdo = $bdd->connexion();
} catch (BddConnectException $e) {
    Messages::goHome($e->getMessage(), "danger", "connecte.php");
}

$repo = new MariaDBBenevoleRepository($pdo);

/* ======================
   TRAITEMENT FORMULAIRE
   ====================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre = trim($_POST['titre']);
    $date  = $_POST['date'];
    $lieu  = trim($_POST['lieu']);
    $materiel = $_POST['materiel'] ?? null;
    $description = $_POST['description'] ?? null;
    $benevoles = $_POST['benevoles'] ?? [];

    if (empty($titre) || empty($date) || empty($lieu)) {
        Messages::goBack("Champs obligatoires manquants", "danger");
        exit;
    }

    // 1️⃣ Création mission
    $idMission = $repo->addMission(
        $titre,
        $date,
        $lieu,
        $materiel,
        $description,
        1
    );

    // 2️⃣ Association bénévoles
    foreach ($benevoles as $idBenevole) {
        $repo->addBenevoleToMission($idMission, $idBenevole);
    }

    // 3️⃣ Upload médias
    if (!empty($_FILES['documents']['name'][0])) {

        $uploadDir = "../../uploads/missions/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['documents']['tmp_name'] as $key => $tmpName) {

            if ($_FILES['documents']['error'][$key] === UPLOAD_ERR_OK) {

                $originalName = basename($_FILES['documents']['name'][$key]);
                $fileName = time() . "_" . $originalName;
                $targetPath = $uploadDir . $fileName;

                move_uploaded_file($tmpName, $targetPath);

                $repo->addMediaToMission(
                    $idMission,
                    $originalName,
                    $fileName
                );
            }
        }
    }

    Messages::goBack(
        "Mission créée avec succès",
        "success",
        "detail_mission.php?id_mission=$idMission"
    );
    exit;
}

/* ======================
   DONNÉES FORMULAIRE
   ====================== */
$listeBenevoles = $repo->getAll("benevole");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une mission</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h1><i class="bi bi-plus-circle me-2"></i>Ajouter une mission</h1>
    <hr>

    <?php Messages::messageFlash(); ?>

    <form method="POST" enctype="multipart/form-data">

        <!-- INFOS MISSION -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning fw-bold">
                Informations de la mission
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date et heure *</label>
                    <input type="datetime-local" name="date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lieu *</label>
                    <input type="text" name="lieu" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Matériel</label>
                    <textarea name="materiel" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

            </div>
        </div>

        <!-- BÉNÉVOLES -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning fw-bold">
                Bénévoles participants
            </div>
            <div class="card-body">

                <?php if (empty($listeBenevoles)): ?>
                    <p class="text-muted fst-italic">Aucun bénévole disponible</p>
                <?php else: ?>

                    <!-- Recherche -->
                    <input type="text"
                           id="searchBenevole"
                           class="form-control mb-3"
                           placeholder="Rechercher un bénévole (nom ou prénom)">

                    <!-- Liste -->
                    <div class="border rounded p-2"
                         style="max-height: 250px; overflow-y: auto;">

                        <?php foreach ($listeBenevoles as $b): ?>
                            <div class="form-check benevole-item"
                                 data-nom="<?= strtolower($b['nom']) ?>"
                                 data-prenom="<?= strtolower($b['prenom']) ?>">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="benevoles[]"
                                       value="<?= $b['id_benevole'] ?>"
                                       id="benevole<?= $b['id_benevole'] ?>">

                                <label class="form-check-label"
                                       for="benevole<?= $b['id_benevole'] ?>">
                                    <?= htmlspecialchars($b['prenom'] . " " . $b['nom']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>
        </div>

        <!-- MÉDIAS -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning fw-bold">
                Documents / Médias
            </div>
            <div class="card-body">
                <input type="file" name="documents[]" class="form-control" multiple>
                <small class="text-muted">
                    Affiches, comptes rendus, photos…
                </small>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="d-flex gap-2">
            <a href="missions.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Créer la mission
            </button>
        </div>

    </form>

</div>

<script>
    document.getElementById('searchBenevole')?.addEventListener('input', function () {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.benevole-item').forEach(item => {
            const nom = item.dataset.nom;
            const prenom = item.dataset.prenom;
            item.style.display = (nom.includes(search) || prenom.includes(search)) ? '' : 'none';
        });
    });
</script>

</body>
</html>
