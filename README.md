# DataAuditLabs – Sistema Web de Gestión de Tareas

**Tercer Desafío Práctico | DSS404 – Universidad Don Bosco**

Sistema web para la gestión de tareas personales de empleados, desarrollado con PHP MVC nativo y Laravel.

---

## Integrantes

| Nombre | Carné |
|---|---|
| Bryan Alexis Peña Bustillo | PB243032 |
| Guillermo Antonio Hernández Guerrero | HG243080 |

---

## Repositorio

[https://github.com/Alexis-K30/Desafio03DSS404](https://github.com/Alexis-K30/Desafio03DSS404.git)

---

## Estructura del Proyecto

```
DataAuditLabs/
├── mvc_nativo/          → Autenticación + CRUD (PHP puro con MVC)
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── libs/
│   ├── public/
│   └── .htaccess
├── laravel_tareas/      → CRUD de tareas con Laravel
│   ├── app/
│   ├── database/
│   ├── resources/
│   └── routes/
├── database/
│   └── script.sql
├── screenshots/
│   ├── registro.png
│   ├── login.png
│   ├── tareas.png
│   ├── crear.png
│   └── editar.png
└── README.md
```

---

## Tecnologías Utilizadas

- PHP 8.x
- Laravel 11
- MySQL
- Bootstrap 5.3
- Bootstrap Icons
- AJAX (Fetch API)
- WAMP Server (entorno local)

---

## Requisitos Previos

- WAMP / XAMPP instalado y corriendo
- PHP 8.1 o superior
- Composer instalado globalmente
- MySQL activo

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Alexis-K30/Desafio03DSS404.git
cd Desafio03DSS404
```

### 2. Base de datos

Importar el script SQL en phpMyAdmin o desde consola:

```sql
-- Desde phpMyAdmin: importar el archivo database/script.sql
-- O desde consola MySQL:
mysql -u root -p < database/script.sql
```

Esto crea dos bases de datos:
- `Tareas` → para el proyecto MVC nativo
- `tareas_laravel` → para el proyecto Laravel

### 3. Proyecto MVC Nativo

Colocar la carpeta `mvc_nativo/` dentro de `C:/wamp64/www/DSS404/DataAudiLabs/`.

Verificar que la URL base en `config/database.php` coincida:

```php
define('BASE_URL', '/DSS404/DataAudiLabs/mvc_nativo/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'Tareas');
define('DB_USER', 'root');
define('DB_PASS', '');
```

Acceder en el navegador:
```
http://localhost/DSS404/DataAudiLabs/mvc_nativo/
```

### 4. Proyecto Laravel

```bash
cd laravel_tareas

# Instalar dependencias
composer install

# Copiar variables de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

Configurar `.env` con los datos de la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tareas_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Ejecutar migraciones:

```bash
php artisan migrate
```

Levantar el servidor:

```bash
php artisan serve
```

Acceder en el navegador:
```
http://localhost:8000
```

---

## Funcionalidades

### MVC Nativo (`mvc_nativo/`)
- Registro e inicio de sesión de usuarios con contraseñas encriptadas (`password_hash`)
- CRUD completo de tareas (crear, listar, editar, eliminar)
- Cada usuario solo ve sus propias tareas
- Cambio de estado de tarea **sin recargar la página** (AJAX con Fetch API)
- Toast de confirmación al cambiar el estado
- Indicadores visuales de tareas vencidas y por vencer

### Laravel (`laravel_tareas/`)
- Autenticación con Laravel Breeze
- CRUD completo de tareas con Eloquent ORM
- Rutas protegidas con middleware `auth`
- Cambio de estado vía AJAX con token CSRF
- Toast de confirmación al cambiar el estado
- Indicadores visuales de tareas vencidas y por vencer en tiempo real
- Redirección al login con mensaje de éxito tras el registro

---

## Credenciales de Prueba

Puedes registrar un usuario desde la pantalla de registro en ambas versiones. No hay usuario de demostración preconfigurado.

---

## Declaración de Uso de Inteligencia Artificial

| Herramienta | Parte del proyecto | Tipo de ayuda | ¿Entiende el código? |
|---|---|---|---|
| Claude (Anthropic) | `RegisteredUserController.php` | Depuración: error `Route [dashboard] not defined` al registrarse | Sí |
| Claude (Anthropic) | `AuthenticatedSessionController.php` | Depuración: error de argumentos en `redirect()` tras login | Sí |
| Claude (Anthropic) | `TareaController.php` + `web.php` | Ejemplo de sintaxis para añadir ruta y método AJAX de cambio de estado | Sí, lo modificamos |
| Claude (Anthropic) | `index.blade.php` | Depuración: toast con fondo blanco por conflicto con CDN de Bootstrap | Sí |
| Claude (Anthropic) | `app.blade.php` | Depuración: ícono hamburguesa invisible por estilos del CDN | Sí |
| Grok (xAI) | `mvc_nativo/public/css/app.css` | Sugerencia de colores y estilos para elementos del frontend | Sí, lo ajustamos |

Declaramos que: Todo el código entregado ha sido comprendido, modificado cuando fue necesario, y podemos explicar su funcionamiento en la defensa.

**Firma del integrante 1:** Bryan Alexis Peña Bustillo

**Firma del integrante 2:** Guillermo Antonio Hernández Guerrero