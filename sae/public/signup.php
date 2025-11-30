<?php

use sae\Authentification;
use sae\BddConnect;
use sae\Exceptions\AuthentificationException;
use sae\Exceptions\BddConnectException;
use sae\MariaDBBenevoleRepository;
use sae\Messages;

require_once __DIR__ . '/../../vendor/autoload.php';

$bdd = new BddConnect();

try {
    $pdo = $bdd->connexion();
}
catch(BddConnectException $e) {
    Messages::goHome(
        $e->getMessage(),
        $e->getType(),
        "connecte.php"
    );
    die();
}

$trousseau = new MariaDBBenevoleRepository($pdo);
$auth = new Authentification($trousseau);

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        if(empty($_POST['signup-name']) || empty($_POST['signup-firstname']) || empty($_POST['signup-email']) || empty($_POST['signup-pwd']) || empty($_POST['signup-repwd']) || empty($_POST['signup-birth'])) {
            throw new AuthentificationException("Accès interdit");
        }

        $retour = $auth->register($_POST['signup-name'], $_POST['signup-firstname'], $_POST['signup-email'], $_POST['signup-pwd'], $_POST['signup-repwd'], new DateTime($_POST['signup-birth']));
        $message = "Vous êtes enregistré. Vous pouvez vous authentifier";
        $type = "success";
    }
    catch(AuthentificationException $e) {
        $message = $e->getMessage();
        $type = $e->getType();
    }

}
else {
    $message = "Accès interdit";
    $type = "danger";
}

Messages::goHome($message, $type, "espace_donateur.html");
