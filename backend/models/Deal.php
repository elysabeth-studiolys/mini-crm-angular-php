<?php

class Deal
{
    private int $id_deals;
    private string $name;
    private ?int $id_contact = null;
    private ?int $id_company = null;
    private float $amount;
    private ?DateTime $date = null;
    private string $status;
    private DateTime $created_at;


    public function __construct(int $id_deals, string $name, float $amount, string $status, DateTime $created_at, ?int $id_contact = null, ?int $id_company = null, ?DateTime $date = null)
    {
        $this->id_deals = $id_deals;
        $this->name = $name;
        $this->id_contact = $id_contact;
        $this->id_company = $id_company;
        $this->amount = $amount;
        $this->date = $date;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    public function getIdDeal(): int
    {
        return $this->id_deals;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }
    public function getIdCompany(): ?int
    {
        return $this->id_company;
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
    public function getDate(): ?DateTime
    {
        return $this->date;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setIdContact(?int $id_contact): void
    {
        $this->id_contact = $id_contact;
    }
    public function setIdCompany(?int $id_company): void
    {
        $this->id_company = $id_company;
    }
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }


    public static function getAllFromDb(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM deals");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $deals = [];

        foreach ($rows as $row) {
            $deals[] = new Deal(
                (int) $row['id_deals'],
                $row['name'],
                (float) $row['amount'],
                $row['status'],
                new DateTime($row['created_at']),
                $row['id_contact'] !== null ? (int) $row['id_contact'] : null,
                $row['id_company'] !== null ? (int) $row['id_company'] : null,
                $row['date'] !== null ? new DateTime($row['date']) : null,
            );
        }
        return $deals;
    }

    public static function createInDb(PDO $pdo, array $data): void
    {
        $stmt = $pdo->prepare("
            INSERT INTO deals (name, amount, status, id_contact, id_company, date)
            VALUES (:name, :amount, :status, :id_contact, :id_company, :date)
        ");
        $stmt->execute([
            ':name' => $data['name'],
            ':amount' => $data['amount'],
            ':status' => $data['status'],
            ':id_contact' => $data['id_contact'],
            ':id_company' => $data['id_company'],
            ':date' => $data['date'] ?? null
        ]);
    }

    public static function updateInDb(PDO $pdo, int $id, array $data): void
{
    $stmt = $pdo->prepare("
        UPDATE deals
        SET name = :name, amount = :amount, status = :status,
            id_company = :id_company, id_contact = :id_contact, date = :date
        WHERE id_deal = :id
    ");
    $stmt->execute([   
        ':name'       => $data['name'],
        ':amount'     => $data['amount'],
        ':status'     => $data['status'],
        ':id_contact' => $data['id_contact'],
        ':id_company' => $data['id_company'] ?? null,
        ':date'       => $data['date'] ?? null,
        ':id'         => $id
    ]);
}

    public static function deleteFromDb(PDO $pdo, int $id): void
    {
        $stmt = $pdo->prepare("DELETE FROM deals WHERE id_deal = :id");
        $stmt->execute([':id' => $id]);
    }

}