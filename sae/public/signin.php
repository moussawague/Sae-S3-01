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
        // Si OK, authenticate() ne lance pas d’exception
        $auth->authenticate($email, $pwd);
        Messages::goHome("Connexion réussie !", "success", "connecte.php");

    } catch (AuthentificationException $e) {
        // Si mauvais mot de passe / email manquant / email introuvable
        Messages::goHome($e->getMessage(), "danger", "connecte.php");
    }
}
