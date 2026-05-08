# 🛍️ Kittpill — E-Commerce + CRM Platform

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-00758F?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

**Una plataforma integral de e-commerce y CRM para gestionar tienda y clientes en un solo lugar.**

[Características](#-características) • [Instalación](#-instalación) • [Rutas](#-rutas) • [Tech Stack](#-tech-stack)

</div>

---

## 📋 Tabla de Contenidos

- [Descripción](#descripción)
- [Características](#-características)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Estructura de Rutas](#-rutas)
- [Sistema de Roles](#-sistema-de-roles)
- [Módulos CRM](#-módulos-crm)
- [Tech Stack](#-tech-stack)
- [Deployment](#-deployment)
---

## Descripción

**Kittpill** es una aplicación Laravel 12 que combina una **tienda de e-commerce pública** con un **panel CRM administrativo completo**. Permite a los administradores gestionar contactos, ventas y actividades comerciales, mientras que los clientes tienen acceso a una tienda de productos y gestión de perfil.

Perfecta para negocios pequeños y medianos que necesitan vender online y gestionar relaciones con clientes desde una sola plataforma.

---

## ✨ Características

### 🏪 Tienda Pública
- 📱 Interfaz responsiva con Tailwind CSS
- 🛒 Catálogo de productos con filtros
- 🎯 Carrito de compras (persistente)
- 📧 Formulario de contacto
- 👤 Registro e inicio de sesión (Laravel Breeze)

### 📊 Panel CRM (Solo Administradores)
- **Gestión de Contactos** — Perfil completo con teléfono, empresa, cargo y notas
- **Seguimiento de Ventas** — Pipeline: `prospecto → negociación → cerrado | perdido`
- **Registro de Actividades** — Llamadas, emails, reuniones y notas con timestamp
- **Gestión de Usuarios** — Crear, editar y eliminar usuarios del sistema
- **Dashboard** — Métricas y resumen de actividad

### 🔐 Seguridad
- Autenticación con Laravel Breeze
- Sistema de roles: `admin` y `cliente`
- Middleware personalizado para rutas protegidas
- Protección CSRF y validación de inputs

---

## 📦 Requisitos

| Tecnología | Versión | Descripción |
|------------|---------|-------------|
| PHP | 8.2+ | Lenguaje backend |
| Composer | 2.x | Gestor de dependencias PHP |
| Node.js | 18+ | Entorno JavaScript |
| npm | 9+ | Gestor de paquetes |
| MySQL | 8.0+ | Base de datos |

---

## 🚀 Instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/David4tec/clase-Java-master.git
cd clase-Java-master
```

### 2️⃣ Instalar dependencias PHP

```bash
composer install
```

### 3️⃣ Instalar dependencias Node.js

```bash
npm install
```

### 4️⃣ Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 5️⃣ Crear base de datos

En MySQL:
```sql
CREATE DATABASE crm_merch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6️⃣ Configurar `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_merch
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://localhost:8000
```

### 7️⃣ Ejecutar migraciones

```bash
php artisan migrate
```

### 8️⃣ (Opcional) Cargar datos de prueba

```bash
php artisan db:seed
```

### 9️⃣ Crear usuario administrador

```bash
php artisan tinker
```

Dentro de Tinker:
```php
App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@test.com',
    'password' => bcrypt('password'),
    'role'     => 'admin'
]);
```

### 🔟 Iniciar servidor de desarrollo

**Terminal 1 — Servidor Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Assets (CSS, JS):**
```bash
npm run dev
```

Abre en tu navegador: **http://localhost:8000**

---

## ⚙️ Configuración

### Variables de entorno importantes

```env
APP_NAME=Kittpill
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxx

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=crm_merch
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
QUEUE_CONNECTION=database
```

### Comandos útiles

```bash
# Limpiar caché
php artisan config:cache
php artisan view:cache
php artisan route:cache

# Ejecutar pruebas
composer run test

# Ejecutar una prueba específica
php artisan test --filter TestClassName
```

---

## 📖 Uso

### Para clientes
1. Accede a `http://localhost:8000`
2. Registrate o inicia sesión
3. Explora la tienda y realiza compras
4. Gestiona tu perfil

### Para administradores
1. Inicia sesión con cuenta `admin`
2. Accede al dashboard: `http://localhost:8000/dashboard`
3. Gestiona contactos, ventas y actividades
4. Administra usuarios del sistema

---

## 🗺️ Rutas

### Públicas
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/` | Página principal y tienda |
| GET | `/register` | Formulario de registro |
| GET | `/login` | Formulario de login |
| GET | `/shop` | Catálogo completo |
| POST | `/contact` | Enviar contacto |

### Autenticadas (Cliente)
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/profile` | Mi perfil |
| GET | `/cart` | Mi carrito |
| POST | `/orders` | Realizar compra |

### Administrativas (Admin)
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/dashboard` | Dashboard CRM |
| GET/POST | `/admin/contacts` | Gestionar contactos |
| GET/POST | `/admin/sales` | Gestionar ventas |
| GET/POST | `/admin/activities` | Gestionar actividades |
| GET/POST | `/admin/users` | Gestionar usuarios |

---

## 🔐 Sistema de Roles

El sistema utiliza dos roles:

| Rol | Acceso |
|-----|--------|
| **cliente** | Tienda pública + Perfil personal |
| **admin** | Tienda + CRM completo + Usuarios |

**Promover usuario a admin:**
```bash
php artisan tinker
>>> App\Models\User::where('email', 'user@test.com')->update(['role' => 'admin']);
```

---

## 📊 Módulos CRM

### 👥 Contactos
- Crear, leer, actualizar, eliminar contactos
- Campos: nombre, teléfono, empresa, cargo, notas
- Vinculación automática con usuarios existentes

### 💰 Ventas
- Pipeline de estados: `prospecto` → `negociación` → `cerrado` | `perdido`
- Monto, fecha de cierre esperada, notas
- Historial completo por contacto

### 📝 Actividades
- Tipos: `llamada`, `email`, `reunión`, `nota`
- Timestamp automático
- Descripción y notas

---

## 🛠️ Tech Stack

| Capa | Tecnología |
|------|------------|
| **Backend** | Laravel 12, PHP 8.2 |
| **Frontend** | Blade, Tailwind CSS, Alpine.js |
| **Database** | MySQL 8.0+ |
| **Bundler** | Vite 5.x |
| **Auth** | Laravel Breeze |
| **Testing** | PHPUnit |

---

## 🌐 Deployment

### Railway (Recomendado)
```bash
# 1. Conecta tu GitHub a Railway
# 2. Selecciona este repositorio
# 3. Railway configura automáticamente PHP + MySQL
# 4. Deploy instantáneo en cada push
```

### Vercel + Supabase
```bash
# 1. Despliega en Vercel (solo frontend)
# 2. Conecta base de datos en Supabase
```

### Hosting tradicional (000webhost, InfinityFree)
```bash
# 1. Sube archivos por FTP
# 2. Configura .env
# 3. Ejecuta migraciones
```

