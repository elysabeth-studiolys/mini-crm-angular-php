<?php

class Company
{
    private int $id_company;
    private string $secteur;
    private string $name;
    private ?string $email;
    private ?string $phone;
    private ?string $adress;
    private DateTime $created_at;

//CONSTRUCTEUR

    public function __construct(int $id_company, string $name, string $secteur, DateTime $created_at, ?string $email = null, ?string $phone = null, ?string $adress = null)
    {
        $this->id_company = $id_company;
        $this->secteur = $secteur;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->adress = $adress;
        $this->created_at = $created_at;
    }

    //GETTERS
    public function getIdCompany(): int
    {
        return $this->id_company;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSecteur(): string
    {
        return $this->secteur;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getAdress(): ?string
    {
        return $this->adress;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    //SETTERS
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setSecteur(string $secteur): void
    {
        $this->secteur = $secteur;
    }
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    public function setPhone(?string $phone): void
    {
        filter_var(($phone), FILTER_SANITIZE_NUMBER_INT) or throw new InvalidArgumentException("Le numéro de téléphone doit être un entier.");
        $this->secteur = $phone;
    }
    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
    }

    //RELIE BASE DDD
    public static function getAllFromDb(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM companies");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $companies = [];

        foreach ($rows as $row) {
            $companies[] = new Company(
                (int)$row['id_company'],
                $row['name'],
                $row ['secteur'],
                new DateTime($row['created_at']),
                $row ['email'] ?? null,
                $row['phone'] ?? null,
                $row ['adress'] ?? null,
            );
        }
        return $companies;
    }

    public static function createInDb(PDO $pdo, array $data): void
    {

        $stmt = $pdo->prepare("
            INSERT INTO companies (name, secteur, email, phone, adress)
            VALUES (:name, :secteur, :email, :phone, :adress)
        ");
        $stmt->execute([
            ':name' => $data['name'],
            ':secteur' => $data['secteur'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':adress' => $data['status'] ?? null
        ]);
    }

    public static function updateInDb(PDO $pdo, int $id, array $data): void
    {
        $stmt = $pdo->prepare("
        UPDATE companies
        SET name = :name,
            secteur = :secteur,
            email = :email
            phone = :phone,
            adress = :adress
        WHERE id_company = :id");

        $stmt->execute([
            ':name' => $data['name'],
            ':secteur' => $data['secteur'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':adress' => $data['adress'] ?? null,
            'id' => $id
        ]);
    }

    public static function deleteFromDb(PDO $pdo, int $id): void
    {
        $stmt = $pdo->prepare("DELETE FROM companies WHERE id_company = :id");
        $stmt->execute([':id' => $id]);
    }
}
