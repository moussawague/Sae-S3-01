<?php

namespace sae;

use DateTime;
class Benevole
{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $password;
    private DateTime $dateNaissance;
    private string $mail;

    public function __construct(int $id, string $nom, string $prenom, DateTime $dateNaissance,
                                string $mail, String $password
    )
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->mail = $mail;
        $this->dateCreation = new DateTime();
        $this->password = $password;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getDateNaissance(): DateTime
    {
        return $this->dateNaissance;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getDateArrivee(): DateTime{
        return $this->dateCreation;
    }

    public function getId(): int{
        return $this->id;
    }
}
