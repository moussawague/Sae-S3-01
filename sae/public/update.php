<?php
if (!session_id()) session_start();

require_once '../../vendor/autoload.php';


use sae\BddConnect;
use sae\Exceptions\BddConnectException;
use sae\Messages;

$id_update = $_SESSION['id_update'];
$table = $_SESSION['table'];

//
// Vérification que l’ID existe
//
if (!isset($_POST[$id_update])) {
    Messages::goBack("ID du bénévole manquant.", "danger");
}

$id = $_POST[$id_update];

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
unset($data[$id_update]); // On ne met pas à jour l'ID

$set = [];
$values = [];

foreach ($data as $col => $val) {
    $set[] = "$col = :$col";
    $values[$col] = ($val === "" ? null : $val);
}

$values[$id_update] = $id;


$sql = "UPDATE $table SET " . implode(", ", $set) . " 
        WHERE $id_update = :$id_update";

$stmt = $pdo->prepare($sql);

if ($stmt->execute($values)) {
    Messages::goBack("Mise à jour effectué avec succès !");
} else {
    Messages::goBack("Erreur lors de la mise à jour.", "danger");
}

