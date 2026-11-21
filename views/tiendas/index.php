<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Tienda.php';

try {
    $tiendaModel = new Tienda((new Database())->getConnection());
    $tiendas = $tiendaModel->getAll();
} catch (Throwable $e) {
    $tiendas = [];
    $loadError = 'No fue posible cargar las tiendas. Verifique la conexión y el esquema.';
}

$pageTitle = 'Tiendas';
$activePage = 'tiendas';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div><h1 class="h3 mb-1">Tiendas</h1><p class="text-secondary mb-0">Red de distribución</p></div>
    <a class="btn btn-primary" href="crear.php"><i class="bi bi-plus-lg"></i> Nueva tienda</a>
</div>
<?php renderFlash(); ?>
<?php if (!empty($loadError)): ?><div class="alert alert-danger"><?= e($loadError) ?></div><?php endif; ?>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Ciudad</th><th>Teléfono</th><th>Email</th><th class="text-end">Acciones</th></tr></thead>
            <tbody>
            <?php if (!$tiendas): ?>
                <tr><td colspan="7" class="text-center text-secondary py-4">No hay tiendas registradas.</td></tr>
            <?php else: foreach ($tiendas as $tienda): ?>
                <tr>
                    <td><?= e($tienda['id_tienda']) ?></td>
                    <td class="fw-semibold"><?= e($tienda['nombre_tienda']) ?></td>
                    <td><?= e($tienda['direccion']) ?></td>
                    <td><?= e($tienda['ciudad']) ?></td>
                    <td><?= e($tienda['telefono']) ?></td>
                    <td><?= e($tienda['email']) ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary action-btn" title="Editar" href="editar.php?id=<?= e($tienda['id_tienda']) ?>"><i class="bi bi-pencil"></i></a>
                        <a class="btn btn-sm btn-outline-danger action-btn" title="Eliminar" href="eliminar.php?id=<?= e($tienda['id_tienda']) ?>"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
