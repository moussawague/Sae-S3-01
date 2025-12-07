<?php

require_once '../../vendor/autoload.php';


use sae\BddConnect;
use sae\Exceptions\BddConnectException;
use sae\Messages;

//
// Vérification que l’ID existe
//
if (!isset($_POST['id_benevole'])) {
    Messages::goBack("ID du bénévole manquant.", "danger");
}

$id = $_POST['id_benevole'];

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
// Préparation des données à mettre à jour
//
$data = $_POST;
unset($data['id_benevole']); // On ne met pas à jour l'ID

$set = [];
$values = [];

foreach ($data as $col => $val) {
    $set[] = "$col = :$col";
    $values[$col] = ($val === "" ? null : $val);
}

$values['id_benevole'] = $id;

$sql = "UPDATE benevole SET " . implode(", ", $set) . " 
        WHERE id_benevole = :id_benevole";

$stmt = $pdo->prepare($sql);

if ($stmt->execute($values)) {
    Messages::goBack("Bénévole mis à jour avec succès !");
} else {
    Messages::goBack("Erreur lors de la mise à jour.", "danger");
}

