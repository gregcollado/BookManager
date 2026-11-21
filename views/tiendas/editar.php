<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Tienda.php';

$errors = [];
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('index.php'); }

try {
    $model = new Tienda((new Database())->getConnection());
    $tienda = $model->getById($id);
    if (!$tienda) { redirect('index.php'); }
} catch (Throwable $e) {
    $tienda = false;
    $errors[] = 'No fue posible cargar la tienda.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (trim((string) ($_POST['nombre_tienda'] ?? '')) === '') {
        $errors[] = 'El nombre de la tienda es obligatorio.';
    }
    $email = trim((string) ($_POST['email'] ?? ''));
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El correo electrónico no es válido.';
    }
    if (!$errors) {
        try {
            $model->update($id, $_POST);
            flash('success', 'Tienda actualizada correctamente.');
            redirect('index.php');
        } catch (Throwable $e) {
            $errors[] = 'No fue posible actualizar la tienda.';
        }
    }
}

$pageTitle = 'Editar tienda';
$activePage = 'tiendas';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header"><h1 class="h3">Editar tienda</h1></div>
<?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?php if ($tienda): $values = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $tienda; ?>
<div class="card"><div class="card-body"><form method="post">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nombre *</label><input class="form-control" name="nombre_tienda" required value="<?= e($values['nombre_tienda'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Ciudad</label><input class="form-control" name="ciudad" value="<?= e($values['ciudad'] ?? '') ?>"></div>
        <div class="col-md-8"><label class="form-label">Dirección</label><input class="form-control" name="direccion" value="<?= e($values['direccion'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Teléfono</label><input class="form-control" name="telefono" value="<?= e($values['telefono'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?= e($values['email'] ?? '') ?>"></div>
    </div>
    <div class="mt-4"><button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Actualizar</button><a class="btn btn-outline-secondary" href="index.php">Cancelar</a></div>
</form></div></div>
<?php endif; ?>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
