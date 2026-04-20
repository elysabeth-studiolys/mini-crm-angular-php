<?php

class Project {
    private int $id_project;
    private string $name;
    private string $description;
    private string $status;

    private ?int $id_contact = null;
    private ?int $id_company = null;
    private ?string $contact_name = null;
    private ?string $company_name = null;

    private ?float $price = null;
    private ?DateTime $date = null;

    public function __construct(int $id_project,string $name, string $description, string $status, ?int $id_contact, ?int $id_company, ?float $price, ?DateTime $date ) {
        $this->id_project = $id_project;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->id_contact= $id_contact;
        $this->id_company = $id_company;
        $this->price = $price;
        $this->date = $date;
    }
//GETTERS
    public function getIdProject(): int {
        return $this->id_project;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getStatus(): string {
        return $this->status;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function getContactName(): string {
        return $this->contact_name;
    }
    public function getCompanyName(): string {
        return $this->company_name;
    }
    public function getPrice(): float {
        return $this->price;
    }
    public function getDate(): DateTime {
        return $this->date;
    }

//SETTERS

    public function setName(string $name): void {
        $this->name = $name;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }
    public function setStatus(string $status): void {
        $this->status = $status;
    }
    public function setContactName(?string $contact_name): void {
        $this->contact_name = $contact_name;
    }
    public function setCompanyName(?string $company_name): void {
        $this->company_name = $company_name;
    }
    public function setPrice(?float $price): void {
        $this->price = $price;
    }
    public function setDate(?DateTime $date): void {
        $this->date = $date;
    }


    public static function getAllFromDb(PDO $pdo): array
    {
        $stmt = $pdo->query(<<<SQL
            SELECT projects.*,
                CONCAT(contacts.first_name, ' ', contacts.last_name) AS contact_name,
                companies.name AS company_name
            FROM projects
            LEFT JOIN contacts ON projects.id_contact = contacts.id_contact
            LEFT JOIN companies ON projects.id_company = companies.id_company
            SQL);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];

        foreach ($rows as $row) {
            $project = new Project(
                (int) $row['id_project'],
                $row['name'],
                $row['description'],
                $row ['status'],
                $row['id_contact'] !== null ? (int) $row['id_contact'] : null,
                $row['id_company'] !== null ? (int) $row['id_company'] : null,
                (float) $row['price'],
                $row['date'] !== null ? new DateTime($row['date']) : null,
            );
            $project->setContactName($row['contact_name'] ?? null);
            $project->setCompanyName($row['company_name'] ?? null);

            $projects[] = $project;


        }
        return $projects;
    }

    public static function createInDb(PDO $pdo, array $data): void
    {
        $stmt = $pdo->prepare("
            INSERT INTO deals (name, description, status, id_contact, id_company, price, date)
            VALUES (:name, :description, :status, :id_contact, :id_company, :price, :date)
        ");
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':status' => $data['status'],
            ':id_contact' => $data['id_contact'],
            ':id_company' => $data['id_company'],
            ':price' => $data['price'] ?? null,
            ':date' => $data['date'] ?? null,
        ]);
    }

    public static function updateInDb(PDO $pdo, int $id, array $data): void
    {
        $stmt = $pdo->prepare("
        UPDATE projects
        SET name = :name, description = :description, status = :status,
            id_company = :id_company, id_contact = :id_contact, price = :price, date = :date,
        WHERE id_project = :id
    ");
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':status' => $data['status'],
            ':id_contact' => $data['id_contact'] ?? null,
            ':id_company' => $data['id_company'] ?? null,
            ':price' => $data['price'] ?? null,
            ':date' => $data['date'] ?? null,
            ':id' => $id
        ]);
    }

    public static function deleteFromDb(PDO $pdo, int $id): void
    {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id_project = :id");
        $stmt->execute([':id' => $id]);
    }
}