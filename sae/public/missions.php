<?php
if (!session_id()) session_start();

require_once '../../vendor/autoload.php';

use sae\BddConnect;
use sae\MariaDBBenevoleRepository;
use sae\Exceptions\BddConnectException;
use sae\Messages;

if (!($_SESSION['part']===true)) {
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
$_SESSION['id_update'] ="id_mission";
$_SESSION['table'] ="mission" ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>

    <nav class="navbar navbar-expand-xxl navbar-light bg-white">
        <div class="container-fluid">
            <a href="index.php">
                <img src="img/logo.png" alt="Armée du Salut" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Armée du salut</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actualite.html">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actions_sociales.html">Nos Actions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="m'engager.html">M'engager</a>
                    </li>
                </ul>
                <div class="btn-container">
                    <a class="nav-link" href="espace_donateur.php"><img src="img/compte.svg" alt="compte"> Espace donateur</a>
                    <a class="btn custom-btn2" href="faireDon.html">Faire un don</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-4">

    <h1>Liste des bénévoles</h1>
    <hr>

    <?php Messages::messageFlash(); ?>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <?php if (!empty($missions)): ?>
            <tr>
                <?php foreach (array_keys($missions[0]) as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            </tr>
        <?php endif; ?>
        </thead>

        <tbody>
        <?php foreach ($missions as $b): ?>
            <tr>

                <?php foreach ($b as $key => $val): ?>
                    <td><?= !empty($val) ? htmlspecialchars($val) : "non renseigné" ?></td>
                <?php endforeach; ?>

                <!-- Bouton Modifier -->
                <td>
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                        <?php foreach ($b as $col => $val): ?>
                            data-<?= strtolower($col) ?>="<?= htmlspecialchars($val) ?>"
                        <?php endforeach; ?>
                    >
                        Modifier
                    </button>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- =======================
      MODAL MODIFICATION
========================= -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Modifier un bénévole</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="update.php" method="POST">
                <div class="modal-body">

                    <?php foreach ($missions[0] as $col => $val): ?>

                        <?php if ($col === 'id_mission'): ?>
                            <!-- ID caché -->
                            <input type="hidden" name="<?= $col ?>" id="edit-<?= $col ?>">
                        <?php else: ?>

                            <div class="mb-3">
                                <label class="form-label"><?= ucfirst($col) ?></label>
                                <input type="text"
                                       class="form-control"
                                       name="<?= $col ?>"
                                       id="edit-<?= $col ?>">
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>


        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour remplir le modal -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');

        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;

            for (const attr of button.attributes) {
                if (attr.name.startsWith('data-') &&
                    attr.name !== 'data-bs-toggle' &&
                    attr.name !== 'data-bs-target') {

                    let field = attr.name.replace('data-', '');

                    const input = document.getElementById(`edit-${field}`);

                    if (input) {
                        input.value = attr.value === "null" ? "" : attr.value;
                    }
                }
            }
        });
    });

</script>


</body>
</html>
