<?php

declare(strict_types=1);

class Tienda
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id_tienda, nombre_tienda, direccion, ciudad, telefono, email
             FROM tiendas
             ORDER BY nombre_tienda ASC'
        );
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id_tienda, nombre_tienda, direccion, ciudad, telefono, email
             FROM tiendas WHERE id_tienda = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $datos): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tiendas (nombre_tienda, direccion, ciudad, telefono, email)
             VALUES (:nombre, :direccion, :ciudad, :telefono, :email)'
        );
        return $stmt->execute([
            'nombre' => trim((string) $datos['nombre_tienda']),
            'direccion' => trim((string) ($datos['direccion'] ?? '')),
            'ciudad' => trim((string) ($datos['ciudad'] ?? '')),
            'telefono' => trim((string) ($datos['telefono'] ?? '')),
            'email' => trim((string) ($datos['email'] ?? '')),
        ]);
    }

    public function update(int $id, array $datos): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE tiendas
             SET nombre_tienda = :nombre, direccion = :direccion, ciudad = :ciudad,
                 telefono = :telefono, email = :email
             WHERE id_tienda = :id'
        );
        return $stmt->execute([
            'id' => $id,
            'nombre' => trim((string) $datos['nombre_tienda']),
            'direccion' => trim((string) ($datos['direccion'] ?? '')),
            'ciudad' => trim((string) ($datos['ciudad'] ?? '')),
            'telefono' => trim((string) ($datos['telefono'] ?? '')),
            'email' => trim((string) ($datos['email'] ?? '')),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM tiendas WHERE id_tienda = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM tiendas')->fetchColumn();
    }
}
