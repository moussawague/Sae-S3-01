<?php

namespace sae;

use DateTime;

class Mission
{
    private int $id;
    private string $titre;
    private string $description;
    private string $lieu;
    private DateTime $date;
    private int $nbBenevole;
    private string $materiel;
    private string $tache;


    public function construct__(int $id, string $titre, string $description, string $lieu, DateTime $date,
                                int $nbBenevole, string $materiel, string $tache){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->lieu = $lieu;
        $this->date = $date;
        $this->nbBenevole = $nbBenevole;
        $this->materiel = $materiel;
        $this->tache = $tache;

    }

    public function getId(): int{return $this->id;}
    public function getTitre(): string{return $this->titre;}
    public function getDescription(): string{return $this->description;}
    public function getLieu(): string{return $this->lieu;}
    public function getDate(): DateTime{return $this->date;}
    public function getNbBenevole(): int{return $this->nbBenevole;}
    public function getMateriel(): string{return $this->materiel;}
    public function getTache(): string{return $this->tache;}
}