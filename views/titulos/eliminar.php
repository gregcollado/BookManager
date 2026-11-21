<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Titulo.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('index.php'); }
$error = null;

try {
    $model = new Titulo((new Database())->getConnection());
    $titulo = $model->getById($id);
} catch (Throwable $e) {
    $titulo = false;
    $error = 'No fue posible cargar el título.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $model->delete($id);
        flash('success', 'Título eliminado correctamente.');
        redirect('index.php');
    } catch (Throwable $e) {
        $error = 'No fue posible eliminar el título.';
    }
}

$pageTitle = 'Eliminar título';
$activePage = 'titulos';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header"><h1 class="h3">Eliminar título</h1></div>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<?php if ($titulo): ?>
    <p>¿Confirma que desea eliminar el título <strong><?= e($titulo['titulo']) ?></strong>?</p>
    <form method="post"><button class="btn btn-danger" type="submit"><i class="bi bi-trash"></i> Eliminar</button><a class="btn btn-outline-secondary" href="index.php">Cancelar</a></form>
<?php else: ?>
    <a class="btn btn-outline-secondary" href="index.php">Volver</a>
<?php endif; ?>
</div></div>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
