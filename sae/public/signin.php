<?php

if(!session_id())
    session_start();

use sae\Authentification;
use sae\BddConnect;
use sae\Exceptions\BddConnectException;
use sae\Exceptions\AuthentificationException;
use sae\MariaDBBenevoleRepository;
use sae\Messages;

require_once '../../vendor/autoload.php';

$bdd = new BddConnect();

try {
    $pdo = $bdd->connexion();
} catch(BddConnectException $e) {
    Messages::goHome($e->getMessage(), $e->getType(), "connecte.php");
}

$trousseau = new MariaDBBenevoleRepository($pdo);
$auth = new Authentification($trousseau);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['signin-email'] ?? '';
    $pwd   = $_POST['signin-pwd'] ?? '';

    try {
        $user = $auth->authenticate($email, $pwd);


        // Après authentification réussie, vérifier participant
        if ($trousseau->estParticipant($user)) {
            $_SESSION['part']=true;
            Messages::goHome("Bienvenue participant !", "success", "espace_participant.php");
        } else {
            Messages::goHome("Bienvenue bénévole !", "success", "connecte.php");
        }

    } catch (AuthentificationException $e) {
        Messages::goHome($e->getMessage(), "danger", "espace_donateur.php");
    }

}
