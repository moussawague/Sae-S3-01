<?php
if (!session_id()) session_start();

require_once '../../vendor/autoload.php';

use sae\Messages;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<?php
// 🔥 AFFICHAGE DU MESSAGE FLASH
Messages::messageFlash();
?>

<h1>Bienvenue sur l'accueil</h1>

</body>
</html>
