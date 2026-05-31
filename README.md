# SG-Store · Backoffice

Backoffice de gestión de productos desarrollado como prueba técnica para Studiogenesis.

**Stack:** Laravel 12 · Blade · Bootstrap 5 · MySQL  
**Autor:** Gabriel Junior Nivicela Masaco  
**Curso:** CFGS DAW 1r

---

## Requisitos previos

- PHP >= 8.0
- Composer
- Node.js + npm
- MySQL

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/sg-store.git
cd sg-store

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install && npm run build

# 4. Copiar el archivo de entorno
cp .env.example .env

# 5. Generar clave de aplicación
php artisan key:generate
```

---

## Configuración de la base de datos

Edita el archivo `.env` con tus credenciales MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sg_store
DB_USERNAME=root
DB_PASSWORD=
```

---

## Migraciones y datos de prueba

```bash
# Crear tablas y poblar con datos de ejemplo
php artisan migrate --seed
```

Esto ejecuta los seeders en orden:

| Seeder | Descripción |
|---|---|
| `CategorySeeder` | Categorías padre e hijas desde `catalog.json` |
| `ProductSeeder` | Productos desde `products.json` |
| `ProductImageSeeder` | Imágenes asociadas a cada producto |
| `RateSeeder` | 2 tarifas fake por producto mediante Factory |

---

## Arrancar el servidor

```bash
php artisan serve
```

La aplicación estará disponible en `http://127.0.0.1:8000`.

---

## Acceso al backoffice

| Campo | Valor |
|---|---|
| **URL** | `http://127.0.0.1:8000/login` |
| **Email** | `test@example.com` |
| **Contraseña** | `password` |

> Si quieres crear un usuario propio: `php artisan tinker` → `User::factory()->create(['email' => 'tu@email.com', 'password' => bcrypt('tupassword')])`

---

## Funcionalidades

### Categorías
- CRUD completo con jerarquía padre/hija
- Una categoría puede tener subcategorías ilimitadas
- Al eliminar una categoría padre se eliminan sus hijas

### Productos
- CRUD completo con categorías múltiples y tarifas por rango de fechas
- Gestión de imágenes (añadir, reemplazar, eliminar) en formulario independiente
- Al cambiar la subcategoría principal, las rutas físicas de las imágenes se reorganizan automáticamente
- Exportación del listado completo a **XLSX**
- Descarga de ficha individual en **PDF**

### Calendario de pedidos
- Vista mensual con FullCalendar en español
- Crear una cita indicando producto, fecha y unidades
- El coste se calcula automáticamente según la tarifa vigente del producto
- Los pedidos aparecen en el calendario una vez guardados

### API REST
Endpoints públicos que devuelven JSON:

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/api/products` | Listado de productos con categorías, tarifas e imágenes |
| GET | `/api/products/{id}` | Producto individual |
| GET | `/api/categories` | Categorías con subcategorías |
| GET | `/api/orders` | Pedidos con producto asociado |

Respuestas verificadas con Postman.

---

## Estructura de carpetas relevante

```
app/
├── Http/Controllers/
│   ├── CategoriesController.php      # CRUD categorías
│   ├── ProductsController.php        # CRUD productos + export XLS/PDF
│   ├── ProductCategoryController.php # Gestión categorías de un producto
│   ├── ProductsImagesController.php  # Gestión imágenes
│   ├── OrdersController.php          # Calendario de pedidos
│   └── ApiController.php            # API REST
├── Services/
│   └── ImageService.php             # Lógica de rutas y almacenamiento de imágenes
└── Models/
    ├── Category.php
    ├── Product.php
    ├── Rate.php
    ├── Order.php
    └── ProductsImage.php
```

---

## Paquetes utilizados

| Paquete | Uso |
|---|---|
| `laravel/breeze` | Autenticación |
| `rap2hpoutre/fast-excel` | Exportación XLSX |
| `barryvdh/laravel-dompdf` | Exportación PDF |
| `@fullcalendar/*` | Calendario de pedidos |

---

## Control de versiones

El repositorio usa tres ramas principales:

- `main` — código estable y funcional
- `dev` — corrección de errores y bugs
- `feature/controller` — desarrollo de CRUDs
- `feature/frontend` — plantillas Blade y formularios