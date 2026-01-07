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

    public function getparticipeMission(): array {
        $sql = "SELECT nom, prenom, participe_mission.id_mission FROM (participe_mission 
                INNER JOIN mission ON participe_mission.id_mission = mission.id_mission) 
                INNER JOIN benevole ON participe_mission.id_benevole = benevole.id_benevole";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBenevoleByMission($id_mission): array {
        $sql = "SELECT * FROM participe_mission 
                INNER JOIN benevole ON participe_mission.id_benevole = benevole.id_benevole
                WHERE id_mission = :id_mission";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_mission' => $id_mission]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBenevoleSauf($id_mission): array {
        $sql = "SELECT * FROM participe_mission 
                INNER JOIN benevole ON participe_mission.id_benevole = benevole.id_benevole
                WHERE id_mission <> :id_mission";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_mission' => $id_mission]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMissionById(int $id_mission): ?array
    {
        $sql = "SELECT * FROM mission WHERE id_mission = :id_mission";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_mission' => $id_mission]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function getMediaByMission(int $id_mission): ?array
    {
        $sql = "SELECT * FROM media WHERE id_mission = :id_mission";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_mission' => $id_mission]);

        return $stmt->fetchall(\PDO::FETCH_ASSOC) ?: null;
    }

    public function addBenevoleToMission($idBenevole, $idMission)
    {
        $sql = "INSERT INTO participe_mission (id_benevole, id_mission)
            VALUES (?, ?)";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute([$idBenevole, $idMission]);
    }

    public function updateMission(mixed $idMission, string $titre, mixed $date, string $lieu, string $materiel, string $description): void {
        // Sécurité : conversion si datetime-local (YYYY-MM-DDTHH:MM)
        $date = str_replace('T', ' ', $date);

        $sql = "
        UPDATE mission
        SET
            titre = :titre,
            date = :date,
            lieu = :lieu,
            materiel = :materiel,
            description = :description
        WHERE id_mission = :id
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':date' => $date,
            ':lieu' => $lieu,
            ':materiel' => $materiel,
            ':description' => $description,
            ':id' => $idMission
        ]);
    }

    public function addMission(
        string $titre,
        string $date,
        string $lieu,
        ?string $materiel,
        ?string $description,
        int $idResponsable
    ): int
    {
        $sql = "
        INSERT INTO mission (
            titre,
            date,
            lieu,
            materiel,
            description,
            id_responsable
        ) VALUES (
            :titre,
            :date,
            :lieu,
            :materiel,
            :description,
            :id_responsable
        )
    ";

        $stmt = $this->dbConnexion->prepare($sql);

        $stmt->execute([
            ':titre'          => $titre,
            ':date'           => $date,
            ':lieu'           => $lieu,
            ':materiel'       => $materiel,
            ':description'    => $description,
            ':id_responsable' => $idResponsable
        ]);

        return (int) $this->dbConnexion->lastInsertId();
    }

    public function getBenevoleById(mixed $idBenevole)
    {
        $sql = "SELECT * FROM benevole WHERE id_benevole = :id_benevole";
        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_benevole' => $idBenevole]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }


    public function getMissionsAVenirByBenevole(int $idBenevole)
    {
        $sql = "
        SELECT m.*
        FROM mission m
        INNER JOIN participe_mission pm
            ON pm.id_mission = m.id_mission
        WHERE pm.id_benevole = :id_benevole
          AND m.date >= CURDATE()
        ORDER BY m.date ASC
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_benevole' => $idBenevole]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function getMissionsPasseesByBenevole(int $idBenevole)
    {
        $sql = "
        SELECT m.*
        FROM mission m
        INNER JOIN participe_mission pm
            ON pm.id_mission = m.id_mission
        WHERE pm.id_benevole = :id_benevole
          AND m.date < CURDATE()
        ORDER BY m.date DESC
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_benevole' => $idBenevole]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCotisationsBientotEcheanceByBenevole(int $idBenevole): array
    {
        $sql = "
    SELECT c.*
    FROM Cotisation c
    INNER JOIN sengager s ON s.id_cotisation = c.id_cotisation
    WHERE s.id_benevole = :id_benevole
      AND DATE_ADD(c.date_, INTERVAL c.duree MONTH) 
          BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY c.date_ ASC
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_benevole' => $idBenevole]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAutresCotisationsByBenevole(int $idBenevole): array
    {
        $sql = "
    SELECT c.*
    FROM Cotisation c
    INNER JOIN sengager s ON s.id_cotisation = c.id_cotisation
    WHERE s.id_benevole = :id_benevole
      AND DATE_ADD(c.date_, INTERVAL c.duree MONTH) > DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY c.date_ ASC
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute(['id_benevole' => $idBenevole]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAdherent()
    {
        $sql = "
    SELECT *
    FROM benevole b
    INNER JOIN sengager a ON b.id_benevole = a.id_benevole
    ORDER BY b.nom, b.prenom
    ";

        $stmt = $this->dbConnexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}