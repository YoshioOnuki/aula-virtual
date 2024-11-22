# Aula Virtual de la Escuela de Posgrado

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---


## 🏫 Sobre el Proyecto

El **Aula Virtual de la Escuela de Posgrado** es una plataforma diseñada para gestionar los cursos y recursos educativos, promoviendo la interacción entre docentes y estudiantes. Utiliza tecnologías modernas para brindar un entorno accesible, eficiente y dinámico.

### ✨ Características Principales

- **Sílabus**  
  Gestión y visualización del plan de estudio de cada curso.

- **Recursos**  
  Subida, descarga y organización de materiales educativos.

- **Foros**  
  Espacios de interacción entre estudiantes y docentes.

- **Asistencia**  
  Registro y control automatizado de asistencia a clases.

- **Trabajos**  
  Presentación y retroalimentación de trabajos académicos.

- **Webgrafía**  
  Gestión de referencias bibliográficas y enlaces externos útiles.

- **Link de Clases**  
  Acceso rápido a las sesiones virtuales del curso.

- **Presentación del Curso**  
  Información introductoria sobre cada curso, incluyendo objetivos y metas.

---

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 11  
- **Frontend**: Livewire 3, Alpine.js  
- **Base de Datos**: MySQL  
- **Estilos**: Bootstrap 5  
- **Control de Versiones**: Git

---

## 🚀 Instalación

Sigue estos pasos para configurar el proyecto en tu máquina local:

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/aula-virtual-posgrado.git
cd aula-virtual-posgrado
```

### 2. Instalar Dependencias

Ejecuta el siguiente comando para instalar todas las dependencias necesarias:

```bash
composer install
```

### 3. Instalar Dependencias de JavaScript

Instala las dependencias de npm para el frontend con el siguiente comando:

```bash
npm install
```

### 4. Configurar el Archivo .env

Copia el archivo .env.example a .env y configura tus credenciales de base de datos y otras variables de entorno:

```bash
cp .env.example .env
```

Edita el archivo .env con los valores correctos para tu entorno local (por ejemplo, configuración de la base de datos, claves de API, etc.).

### 5. Generar la Clave de la Aplicación

Laravel necesita una clave de aplicación para funcionar correctamente. Ejecuta el siguiente comando para generarla:

```bash
php artisan key:generate
```

### 6. Ejecutar Migraciones

Asegúrate de que tu base de datos esté configurada y ejecuta las migraciones para crear las tablas necesarias:

```bash
php artisan migrate
```
