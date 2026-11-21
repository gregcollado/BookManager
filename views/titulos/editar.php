<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../models/Titulo.php';

$errors = [];
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { redirect('index.php'); }

try {
    $model = new Titulo((new Database())->getConnection());
    $titulo = $model->getById($id);
    $publicadores = $model->getPublicadores();
    if (!$titulo) { redirect('index.php'); }
} catch (Throwable $e) {
    $titulo = false;
    $publicadores = [];
    $errors[] = 'No fue posible cargar el título.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $precio = filter_var($_POST['precio'] ?? null, FILTER_VALIDATE_FLOAT);
    $idPub = filter_var($_POST['id_pub'] ?? null, FILTER_VALIDATE_INT);
    if (trim((string) ($_POST['titulo'] ?? '')) === '') { $errors[] = 'El título es obligatorio.'; }
    if ($precio === false || $precio < 0) { $errors[] = 'El precio debe ser igual o mayor que cero.'; }
    if (!$idPub || $idPub < 1) { $errors[] = 'Debe seleccionar una editorial.'; }
    if (!$errors) {
        try {
            $model->update($id, $_POST);
            flash('success', 'Título actualizado correctamente.');
            redirect('index.php');
        } catch (Throwable $e) {
            $errors[] = 'No fue posible actualizar el título.';
        }
    }
}

$pageTitle = 'Editar título';
$activePage = 'titulos';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-header"><h1 class="h3">Editar título</h1></div>
<?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?php if ($titulo): $values = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $titulo; ?>
<div class="card"><div class="card-body"><form method="post">
    <div class="row g-3">
        <div class="col-md-8"><label class="form-label">Título *</label><input class="form-control" name="titulo" required value="<?= e($values['titulo'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Tipo</label><input class="form-control" name="tipo" value="<?= e($values['tipo'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Editorial *</label><select class="form-select" name="id_pub" required><option value="">Seleccione...</option><?php foreach ($publicadores as $pub): ?><option value="<?= e($pub['id_pub']) ?>" <?= (($values['id_pub'] ?? '') == $pub['id_pub']) ? 'selected' : '' ?>><?= e($pub['nombre_pub']) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-3"><label class="form-label">Precio *</label><input type="number" min="0" step="0.01" class="form-control" name="precio" required value="<?= e($values['precio'] ?? '') ?>"></div>
        <div class="col-md-3"><label class="form-label">Fecha de publicación</label><input type="date" class="form-control" name="fecha_publicacion" value="<?= e($values['fecha_publicacion'] ?? '') ?>"></div>
        <div class="col-12"><label class="form-label">Notas</label><textarea class="form-control" name="notas" rows="3"><?= e($values['notas'] ?? '') ?></textarea></div>
    </div>
    <div class="mt-4"><button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Actualizar</button><a class="btn btn-outline-secondary" href="index.php">Cancelar</a></div>
</form></div></div>
<?php endif; ?>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
