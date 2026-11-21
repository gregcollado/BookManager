<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/models/Tienda.php';
require_once __DIR__ . '/models/Titulo.php';

$dbError = null;
$tiendas = 0;
$titulos = 0;

try {
    $db = (new Database())->getConnection();
    $tiendas = (new Tienda($db))->count();
    $titulos = (new Titulo($db))->count();
} catch (Throwable $e) {
    $dbError = 'No fue posible conectar a la base de datos. Revise la configuración.';
}

$pageTitle = 'BookManager - Inicio';
$activePage = 'inicio';
require __DIR__ . '/includes/header.php';
?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-1">Panel principal</h1>
        <p class="text-secondary mb-0">Gestión de inventario y distribución</p>
    </div>
</div>
<?php renderFlash(); ?>
<?php if ($dbError): ?>
    <div class="alert alert-danger"><?= e($dbError) ?></div>
<?php endif; ?>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-secondary">Tiendas</div>
                    <div class="display-6 fw-bold"><?= e($tiendas) ?></div>
                </div>
                <i class="bi bi-shop fs-1 text-primary"></i>
            </div>
            <div class="card-footer bg-white border-0">
                <a class="text-decoration-none" href="/views/tiendas/index.php">Administrar tiendas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-secondary">Títulos</div>
                    <div class="display-6 fw-bold"><?= e($titulos) ?></div>
                </div>
                <i class="bi bi-book fs-1 text-primary"></i>
            </div>
            <div class="card-footer bg-white border-0">
                <a class="text-decoration-none" href="/views/titulos/index.php">Administrar títulos <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
