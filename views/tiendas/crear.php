<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Tienda.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim((string) ($_POST['nombre_tienda'] ?? ''));
    if ($nombre === '') {
        $errors[] = 'El nombre de la tienda es obligatorio.';
    }
    if (!isset($_POST['email']) || $_POST['email'] === '' || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // El email es opcional, pero debe ser válido si se informa.
    } else {
        $errors[] = 'El correo electrónico no es válido.';
    }

    if (!$errors) {
        try {
            $model = new Tienda((new Database())->getConnection());
            $model->create($_POST);
            flash('success', 'Tienda creada correctamente.');
            redirect('index.php');
        } catch (Throwable $e) {
            $errors[] = 'No fue posible guardar la tienda.';
        }
    }
}

$pageTitle = 'Nueva tienda';
$activePage = 'tiendas';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header"><h1 class="h3">Nueva tienda</h1></div>
<?php if ($errors): ?>
    <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
<div class="card"><div class="card-body">
<form method="post" novalidate>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nombre *</label><input class="form-control" name="nombre_tienda" required value="<?= e($_POST['nombre_tienda'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Ciudad</label><input class="form-control" name="ciudad" value="<?= e($_POST['ciudad'] ?? '') ?>"></div>
        <div class="col-md-8"><label class="form-label">Dirección</label><input class="form-control" name="direccion" value="<?= e($_POST['direccion'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Teléfono</label><input class="form-control" name="telefono" value="<?= e($_POST['telefono'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= e($_POST['email'] ?? '') ?>"></div>
    </div>
    <div class="mt-4"><button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Guardar</button><a class="btn btn-outline-secondary" href="index.php">Cancelar</a></div>
</form>
</div></div>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
