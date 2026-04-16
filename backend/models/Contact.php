<?php

class Contact
{
    private int $id_contact;
    private string $first_name;
    private string $last_name;
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $status = null;
    private DateTime $created_at;

// CONSTRUCTEUR
    public function __construct(int $id_contact, string $first_name, string $last_name, DateTime $created_at, ?string $email = null, ?string $phone = null, ?string $status = null)
    {
        $this->id_contact = $id_contact;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    //GETTERS
    public function getIdContact(): int
    {
        return $this->id_contact;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    //SETTERS
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    public function setPhone(?string $phone): void
    {
        filter_var(($phone), FILTER_SANITIZE_NUMBER_INT) or throw new InvalidArgumentException("Le numéro de téléphone doit être un entier.");
        $this->phone = $phone;
    }
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }


    //BASE DE DONNÉE
    public static function getAllFromDb(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM contacts");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $contacts = [];
        foreach ($rows as $row) {
            $contacts[] = new Contact(
                (int)$row['id_contact'],
                $row['first_name'],
                $row['last_name'],
                new DateTime($row['created_at']),
                $row['email'] ?? null,
                $row['phone'] ?? null,
                $row['status'] ?? null
            );
        }
        return $contacts;
    }

    public static function createInDb(PDO $pdo, array $data): void
    {

        $stmt = $pdo->prepare("
            INSERT INTO contacts (first_name, last_name, email, phone, status)
            VALUES (:first_name, :last_name, :email, :phone, :status)
        ");
        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':status' => $data['status'] ?? null
        ]);
    }

    public static function updateInDb(PDO $pdo, int $id, array $data): void
    {
        $stmt = $pdo->prepare("
            UPDATE contacts
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                phone = :phone,
                status = :status
            WHERE id_contact = :id
        ");
        $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':status' => $data['status'] ?? null,
            ':id' => $id
        ]);
    }

    public static function deleteFromDb(PDO $pdo, int $id): void
    {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id_contact = :id");
        $stmt->execute([':id' => $id]);
    }
}
