<?php

declare(strict_types=1);

class Titulo
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT t.id_titulo, t.titulo, t.tipo, t.id_pub, t.precio,
                    t.fecha_publicacion, t.notas, p.nombre_pub
             FROM titulos t
             LEFT JOIN publicadores p ON p.id_pub = t.id_pub
             ORDER BY t.titulo ASC'
        );
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT id_titulo, titulo, tipo, id_pub, precio, fecha_publicacion, notas
             FROM titulos WHERE id_titulo = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getPublicadores(): array
    {
        $stmt = $this->db->query(
            'SELECT id_pub, nombre_pub FROM publicadores ORDER BY nombre_pub ASC'
        );
        return $stmt->fetchAll();
    }

    public function create(array $datos): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO titulos (titulo, tipo, id_pub, precio, fecha_publicacion, notas)
             VALUES (:titulo, :tipo, :id_pub, :precio, :fecha, :notas)'
        );
        return $stmt->execute([
            'titulo' => trim((string) $datos['titulo']),
            'tipo' => trim((string) ($datos['tipo'] ?? '')),
            'id_pub' => (int) $datos['id_pub'],
            'precio' => (float) $datos['precio'],
            'fecha' => $datos['fecha_publicacion'] ?: null,
            'notas' => trim((string) ($datos['notas'] ?? '')),
        ]);
    }

    public function update(int $id, array $datos): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE titulos
             SET titulo = :titulo, tipo = :tipo, id_pub = :id_pub, precio = :precio,
                 fecha_publicacion = :fecha, notas = :notas
             WHERE id_titulo = :id'
        );
        return $stmt->execute([
            'id' => $id,
            'titulo' => trim((string) $datos['titulo']),
            'tipo' => trim((string) ($datos['tipo'] ?? '')),
            'id_pub' => (int) $datos['id_pub'],
            'precio' => (float) $datos['precio'],
            'fecha' => $datos['fecha_publicacion'] ?: null,
            'notas' => trim((string) ($datos['notas'] ?? '')),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM titulos WHERE id_titulo = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM titulos')->fetchColumn();
    }
}
