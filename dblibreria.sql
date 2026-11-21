CREATE DATABASE IF NOT EXISTS dblibreria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dblibreria;

CREATE TABLE IF NOT EXISTS publicadores (
    id_pub INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre_pub VARCHAR(100) NOT NULL,
    direccion VARCHAR(150) NULL,
    ciudad VARCHAR(100) NULL,
    PRIMARY KEY (id_pub)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tiendas (
    id_tienda INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre_tienda VARCHAR(100) NOT NULL,
    direccion VARCHAR(150) NULL,
    ciudad VARCHAR(100) NULL,
    telefono VARCHAR(30) NULL,
    email VARCHAR(100) NULL,
    PRIMARY KEY (id_tienda)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS titulos (
    id_titulo INT UNSIGNED NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    tipo VARCHAR(50) NULL,
    id_pub INT UNSIGNED NULL,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0,
    fecha_publicacion DATE NULL,
    notas TEXT NULL,
    PRIMARY KEY (id_titulo),
    CONSTRAINT fk_titulos_publicador
        FOREIGN KEY (id_pub) REFERENCES publicadores(id_pub)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO publicadores (nombre_pub, direccion, ciudad) VALUES
('Editorial Alfa', 'Av. Central 100', 'Santo Domingo'),
('Editorial Beta', 'Calle Norte 25', 'Santiago'),
('Ediciones Literarias', 'Av. Independencia 450', 'Santo Domingo');

INSERT INTO tiendas (nombre_tienda, direccion, ciudad, telefono, email) VALUES
('Librería Central', 'Calle Comercio 10', 'Santo Domingo', '809-555-0101', 'central@example.com'),
('La Plaza del Libro', 'Plaza Principal 5', 'Santiago', '809-555-0102', 'plaza@example.com');

INSERT INTO titulos (titulo, tipo, id_pub, precio, fecha_publicacion, notas) VALUES
('Fundamentos de PHP', 'tecnico', 1, 850.00, '2025-01-15', 'Introducción práctica a PHP y POO'),
('Diseño con Bootstrap', 'tecnico', 3, 720.50, '2025-03-10', 'Interfaces responsivas modernas');
