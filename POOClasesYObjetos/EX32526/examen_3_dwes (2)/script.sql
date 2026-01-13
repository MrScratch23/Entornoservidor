-- 1. CREACIÓN DE LA BASE DE DATOS
-- Eliminamos y creamos la BD
DROP DATABASE IF EXISTS examen_dwes_3;
CREATE DATABASE IF NOT EXISTS examen_dwes_3;
-- la marcamos como activa
USE examen_dwes_3;

-- 2. CREACIÓN DE LA TABLA 'usuarios'
-- Esta tabla se utiliza para el login. La contraseña se almacena con hash (MD5 en este ejemplo).
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre_completo` VARCHAR(100) NOT NULL,
    `usuario` VARCHAR(20) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL COMMENT 'Contraseña hasheada',
    `rol` ENUM('admin','user') NOT NULL DEFAULT 'user',
    `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ;

-- 3. INSERCIÓN DE USUARIOS DE EJEMPLO
-- Se insertan dos usuarios de ejemplo.
-- Las contraseñas están hasheadas con MD5 para simular un entorno real:
-- - '1234' -> hash: $2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety
-- - '1111'  -> hash: $2y$12$hjnQPM49616CFuI6L8UMOu9v..m.xKkEKKpyyXLKlaRgqeBVDDOO2

INSERT INTO `usuarios` (`nombre_completo`, `usuario`, `password`,`rol`) VALUES
('Administrador Principal', 'admin', '$2y$12$/RO5OP3pH2bT2.rgpIJ2OOtle/o2oEeECycuKjCWnVR31ofEgpety', 'admin'),
('Usuario de Prueba', 'pepe', '$2y$12$hjnQPM49616CFuI6L8UMOu9v..m.xKkEKKpyyXLKlaRgqeBVDDOO2', 'user');

-- 4. TABLA INCIDENCIAS
CREATE TABLE `incidencias` (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    asunto VARCHAR(100) NOT NULL COMMENT 'Título corto de la incidencia',
    tipo_incidencia ENUM ('Hardware','Software','Red','Otros') NOT NULL,
    horas_estimadas INT UNSIGNED NOT NULL DEFAULT 1,
    estado ENUM('Pendiente','En curso','Resuelta') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. INCIDENCIAS DE EJEMPLO
INSERT INTO `incidencias` (`asunto`, `tipo_incidencia`, `horas_estimadas`, `estado`) VALUES
('El PC no arranca', 'Hardware', 2, 'Pendiente'),
('Error al iniciar sesión en Moodle', 'Software', 1, 'En curso'),
('Sin conexión a Internet en el aula 5', 'Red', 3, 'Pendiente'),
('El correo institucional devuelve errores', 'Otros', 1, 'Resuelta'),
('Solicitud de instalación de impresora nueva', 'Hardware', 2, 'Pendiente');
-- 6. Creación del Usuario para la Aplicación y Asignación de Permisos

CREATE USER if not exists'dwes25'@'localhost' IDENTIFIED BY 'dwes';

-- Asignar permisos CRUD
GRANT SELECT, INSERT, UPDATE, DELETE ON examen_dwes_3.* TO 'dwes25'@'localhost';

FLUSH PRIVILEGES;