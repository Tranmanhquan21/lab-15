<?php
/**
 * LAB 14 – Topic 1: Model có countAll() và getPage($limit, $offset) – LIMIT/OFFSET
 */
class Product
{
    private PDO $pdo;
    private string $table = 'products';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function countAll(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }

    public function getPage(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $name, string $description, ?string $imagePath = null): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (name, description, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $imagePath]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, string $name, string $description, ?string $imagePath = null): bool
    {
        if ($imagePath !== null) {
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET name = ?, description = ?, image_path = ? WHERE id = ?");
            return $stmt->execute([$name, $description, $imagePath, $id]);
        }
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
