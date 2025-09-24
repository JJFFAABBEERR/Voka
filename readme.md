# Conexión Vocacional SENA

Sistema web para la gestión de programas de formación del SENA dirigido a estudiantes de colegios.

## Características

- Carrusel interactivo de programas de formación
- Formulario de registro para estudiantes con validación
- Panel de administración para gestión de datos
- Reportes y estadísticas
- Diseño responsive basado en la plataforma Betowa del SENA

## Requisitos del sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache recomendado)
- Extensiones PHP: PDO, MySQLi, mbstring

## Instalación

1. Clonar o descargar el proyecto en el directorio web
2. Crear la base de datos ejecutando el archivo `sql/conexion_vocacional.sql`
3. Configurar las credenciales de la base de datos en `config/db.php`
4. Subir las imágenes de programas a la carpeta `assets/img/`
5. Asegurar permisos de escritura en los directorios necesarios

## Configuración de producción

- Cambiar las credenciales de la base de datos en `config/db.php`
- Configurar HTTPS para mayor seguridad
- Establecer valores apropiados para `max_execution_time` y `memory_limit` en php.ini
- Configurar backups regulares de la base de datos

## Credenciales por defecto

- Usuario administrador: `admin`
- Contraseña: `admin123`

## Estructura del proyecto
