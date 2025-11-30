<?php

namespace sae;

use sae\Exceptions\AuthentificationException;
use DateTime;

class Authentification {

    public function __construct(private IBenevoleRepository $benevoleRepository) { }

    /**
     * @throws AuthentificationException
     */
    public function register(string $nom, string $prenom, string $email, string $password, string $repeat, DateTime $date) : bool {

        if (empty($email)) {
            throw new AuthentificationException("Email obligatoire");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AuthentificationException("Email invalide");
        }

        if (empty($password)) {
            throw new AuthentificationException("Mot de passe obligatoire");
        }

        if ($password !== $repeat) {
            throw new AuthentificationException("Les mots de passe ne correspondent pas");
        }

        if ($this->benevoleRepository->findUserByEmail($email) !== null) {
            throw new AuthentificationException("Cet utilisateur existe déjà");
        }

        // Hash du mot de passe
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        // ❗ ENREGISTRER LE HASH ET NON LE MOT DE PASSE EN CLAIR
        $benevole = new Benevole($prenom, $nom, $date, $email, $hashedPwd);

        return $this->benevoleRepository->saveBenevole($benevole);
    }


    /**
     * @throws AuthentificationException
     */
    public function authenticate(string $email, string $password) : string
    {
        // TODO : À compléter
        if (empty($email) || empty($password)) {
            throw new AuthentificationException("Email ou mot de passe manquant");
        }

        // Cherche l'utilisateur
        $user = $this->benevoleRepository->findUserByEmail($email);

        if ($user === null) {
            throw new AuthentificationException("Utilisateur inconnu");
        }

        // Vérifie le mot de passe
        if (!password_verify($password, $user->getPassword())) {
            throw new AuthentificationException("Mot de passe incorrect");
        }

        // Retourne un message ou token si nécessaire
        return "OK";
    }


}