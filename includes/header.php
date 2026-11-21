<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
$projectRoot = realpath(__DIR__ . '/..');
$basePath = '';
if ($documentRoot && $projectRoot && str_starts_with(str_replace('\\', '/', $projectRoot), str_replace('\\', '/', $documentRoot))) {
    $basePath = substr(str_replace('\\', '/', $projectRoot), strlen(str_replace('\\', '/', $documentRoot)));
}
$basePath = rtrim($basePath, '/');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'BookManager') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= e($basePath) ?>/assets/css/styles.css">
</head>
<body>
<div class="app-shell d-flex">
    <aside class="sidebar">
        <a class="brand" href="<?= e($basePath) ?>/index.php">
            <i class="bi bi-book-half"></i>
            <span>BookManager</span>
        </a>
        <nav class="nav flex-column">
            <a class="nav-link <?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>" href="<?= e($basePath) ?>/index.php">
                <i class="bi bi-speedometer2"></i> Inicio
            </a>
            <a class="nav-link <?= ($activePage ?? '') === 'tiendas' ? 'active' : '' ?>" href="<?= e($basePath) ?>/views/tiendas/index.php">
                <i class="bi bi-shop"></i> Tiendas
            </a>
            <a class="nav-link <?= ($activePage ?? '') === 'titulos' ? 'active' : '' ?>" href="<?= e($basePath) ?>/views/titulos/index.php">
                <i class="bi bi-book"></i> Títulos
            </a>
        </nav>
    </aside>
    <main class="main-content flex-grow-1">
