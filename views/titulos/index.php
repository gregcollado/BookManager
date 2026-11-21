<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Titulo.php';

try {
    $model = new Titulo((new Database())->getConnection());
    $titulos = $model->getAll();
} catch (Throwable $e) {
    $titulos = [];
    $loadError = 'No fue posible cargar los títulos. Verifique la conexión y el esquema.';
}

$pageTitle = 'Títulos';
$activePage = 'titulos';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div><h1 class="h3 mb-1">Títulos</h1><p class="text-secondary mb-0">Catálogo de libros</p></div>
    <a class="btn btn-primary" href="crear.php"><i class="bi bi-plus-lg"></i> Nuevo título</a>
</div>
<?php renderFlash(); ?>
<?php if (!empty($loadError)): ?><div class="alert alert-danger"><?= e($loadError) ?></div><?php endif; ?>
<div class="card"><div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead><tr><th>ID</th><th>Título</th><th>Tipo</th><th>Editorial</th><th>Precio</th><th>Publicación</th><th class="text-end">Acciones</th></tr></thead>
    <tbody>
    <?php if (!$titulos): ?>
        <tr><td colspan="7" class="text-center text-secondary py-4">No hay títulos registrados.</td></tr>
    <?php else: foreach ($titulos as $titulo): ?>
        <tr>
            <td><?= e($titulo['id_titulo']) ?></td>
            <td class="fw-semibold"><?= e($titulo['titulo']) ?></td>
            <td><?= e($titulo['tipo']) ?></td>
            <td><?= e($titulo['nombre_pub'] ?? '') ?></td>
            <td>$<?= number_format((float) $titulo['precio'], 2) ?></td>
            <td><?= e($titulo['fecha_publicacion']) ?></td>
            <td class="text-end">
                <a class="btn btn-sm btn-outline-primary action-btn" title="Editar" href="editar.php?id=<?= e($titulo['id_titulo']) ?>"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-sm btn-outline-danger action-btn" title="Eliminar" href="eliminar.php?id=<?= e($titulo['id_titulo']) ?>"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div></div>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
