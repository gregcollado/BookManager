# BookManager

Sistema CRUD de gestión de una librería desarrollado con PHP 8, PDO y Bootstrap 5.

## Requisitos

- PHP 8.0 o superior
- MySQL 5.7+ o MariaDB
- Extensión PDO MySQL

## Instalación local

1. Copie la carpeta `bookmanager` dentro de la carpeta `htdocs` de XAMPP o del directorio público de su servidor.
2. Inicie Apache y MySQL.
3. Importe `dblibreria.sql` desde phpMyAdmin.
4. Ajuste `config/database.php` o configure las variables de entorno:

```text
DB_HOST=127.0.0.1
DB_NAME=dblibreria
DB_USER=root
DB_PASS=
```

En Apache/XAMPP acceda a `http://localhost/bookmanager/`.

## Arquitectura

- `config/database.php`: conexión PDO centralizada.
- `models/`: clases `Tienda` y `Titulo` con operaciones CRUD.
- `views/`: formularios y listados.
- `includes/`: diseño común y funciones auxiliares.
- `assets/`: recursos visuales.

Todas las consultas utilizan sentencias preparadas. Los formularios realizan validaciones básicas antes de ejecutar las operaciones.

## Despliegue en InfinityFree

1. Cree una base de datos MySQL desde el panel de control.
2. Importe `dblibreria.sql` desde phpMyAdmin.
3. Suba el contenido de `bookmanager` a la carpeta `htdocs`.
4. Configure las variables de entorno si el hosting las permite. Si no, sustituya los valores predeterminados de `config/database.php` por el host, nombre de base, usuario y contraseña remotos.
5. No publique credenciales reales en repositorios públicos.
