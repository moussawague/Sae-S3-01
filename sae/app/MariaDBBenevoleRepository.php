<?php

namespace sae;

class MariaDBBenevoleRepository implements IBenevoleRepository {

    public function __construct(private \PDO $dbConnexion) { }

    /**
     * Effectue l'enregistrement d'un utilisateur (email/password) dans la base MariaDB
     * retourne true en cas de succès et false en cas d'erreur
     * @param Benevole $benevole
     * @return bool
     */
    public function saveBenevole(Benevole $benevole) : bool {
        $sql = "INSERT INTO benevole 
            (nom, prenom, date_naissance, mail, password, date_arrivee) 
            VALUES 
            (:nom, :prenom, :date_naissance, :mail, :password, :date_arrivee)";

        $stmt = $this->dbConnexion->prepare($sql);

        return $stmt->execute([
            ':nom'           => $benevole->getNom(),
            ':prenom'        => $benevole->getPrenom(),
            ':date_naissance' => $benevole->getDateNaissance()->format('Y-m-d'),
            ':mail'          => $benevole->getMail(),
            ':password'      => $benevole->getPassword(),
            ':date_arrivee'   => $benevole->getDateArrivee()->format('Y-m-d')
        ]);
    }



    /**
     * Recherche un utilisateur à partir de son email dans la base MariaDB.
     * Retourne l'utilisateur si l'utilisateur est enregistré. Sinon null
     * @param string $email
     * @return Benevole|null
     */
    public function findUserByEmail(string $email) : ?Benevole {
        $sql = "SELECT * FROM benevole WHERE mail = :email";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute([':email' => $email]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Benevole(
            $data['id_benevole'],
            $data['nom'],
            $data['prenom'],
            new \DateTime($data['date_naissance']),  // <- CORRECTION
            $data['mail'],
            $data['password'],
            isset($data['dateArrivee']) ? new \DateTime($data['dateArrivee']) : null
        );
    }

    public function estParticipant(Benevole $benevole): bool
    {
        $sql = "SELECT COUNT(*) FROM est_participant WHERE id_benevole = :id";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute([':id' => $benevole->getId()]);

        return $stmt->fetchColumn() > 0;
    }

    public function getAll(string $table): array {
        $sql = "SELECT * FROM $table";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}