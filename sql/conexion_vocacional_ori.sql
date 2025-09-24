-- Archivo: sql/conexion_vocacional.sql

CREATE DATABASE IF NOT EXISTS conexion_vocacional CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE conexion_vocacional;

-- Tabla de programas
CREATE TABLE programas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255) DEFAULT 'programacion.jpg',
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de colegios
CREATE TABLE colegios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    direccion TEXT,
    ciudad VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de estudiantes
CREATE TABLE estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(255) NOT NULL,
    documento VARCHAR(50) UNIQUE NOT NULL,
    colegio_id INT,
    grado VARCHAR(50),
    telefono VARCHAR(20),
    nombre_contacto VARCHAR(255),
    telefono_contacto VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (colegio_id) REFERENCES colegios(id) ON DELETE SET NULL
);

-- Tabla de preferencias (relación muchos a muchos entre estudiantes y programas)
CREATE TABLE preferencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estudiante_id INT,
    programa_id INT,
    prioridad INT CHECK (prioridad BETWEEN 1 AND 3),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (programa_id) REFERENCES programas(id) ON DELETE CASCADE,
    UNIQUE(estudiante_id, programa_id),
    UNIQUE(estudiante_id, prioridad)
);

-- Tabla de administradores
CREATE TABLE administradores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar datos de ejemplo
INSERT INTO colegios (nombre, direccion, ciudad) VALUES 
('Colegio Nacional', 'Calle 123 #45-67', 'Bogotá'),
('Instituto Técnico Central', 'Avenida Principal #100-23', 'Medellín'),
('Liceo Moderno', 'Carrera 56 #78-90', 'Cali');

INSERT INTO programas (nombre, descripcion, imagen) VALUES
('Técnico en Programación', 'Formación en desarrollo de software y aplicaciones. Aprenderás lenguajes de programación, bases de datos y desarrollo web.', 'programacion.jpg'),
('Técnico en Diseño Gráfico', 'Formación en diseño visual y multimedia. Desarrollarás habilidades en diseño editorial, identidad corporativa y animación.', 'diseno.jpg'),
('Técnico en Electricidad', 'Formación en instalaciones eléctricas residenciales e industriales. Aprenderás sobre circuitos, normativas y seguridad eléctrica.', 'electricidad.jpg'),
('Técnico en Mecánica Automotriz', 'Formación en mantenimiento y reparación de vehículos. Conocerás sobre motores, transmisión y sistemas electrónicos.', 'mecanica.jpg'),
('Técnico en Gastronomía', 'Formación en preparación de alimentos y técnicas culinarias. Desarrollarás habilidades en cocina nacional e internacional.', 'gastronomia.jpg');

INSERT INTO administradores (usuario, password_hash, nombre_completo) VALUES
('admin', '$2y$10$r3B7W/dhKkU6X6Z8QYqZNuY7JQcW9V2nT7sK6pL8mR1fS3vD5qG0C', 'Administrador Principal');
-- La contraseña es "admin123" (hash generado con password_hash)

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_estudiantes_documento ON estudiantes(documento);
CREATE INDEX idx_estudiantes_colegio ON estudiantes(colegio_id);
CREATE INDEX idx_preferencias_estudiante ON preferencias(estudiante_id);
CREATE INDEX idx_preferencias_programa ON preferencias(programa_id);