# Yibun - Sistema de Gestión Personal

Yibun es una plataforma moderna y minimalista diseñada para la gestión integral de tu vida personal y profesional. Permite organizar notas, tareas, proyectos, contactos y eventos en una interfaz intuitiva basada en Bootstrap 5.

![Yibun Preview](avatar.png)

## 🚀 Características Principales

- **Dashboard Inteligente**: Vista rápida de tus pendientes, notas recientes y estadísticas generales.
- **Gestión de Notas**: Crea y organiza apuntes rápidos con soporte para proyectos y categorías.
- **Lista de Tareas**: Controla tus actividades pendientes con estados (completado/pendiente).
- **Proyectos**: Agrupa tus notas y tareas por metas o trabajos específicos.
- **Agenda de Eventos**: Calendario para gestionar tus citas y recordatorios importantes.
- **Directorio de Contactos**: Administra tu red de contactos de manera centralizada.
- **Control de Usuarios**: Sistema de autenticación con perfiles de administrador y usuario estándar.
- **Diseño Moderno**: Interfaz limpia, responsiva y optimizada con **Bootstrap 5** y **CoreUI**.

## 🛠️ Tecnologías Utilizadas

- **Lenguaje**: PHP 8.x
- **Base de Datos**: MariaDB / MySQL
- **Frontend**: Bootstrap 5, CoreUI v4
- **Librerías JS**: SweetAlert2 (Alertas), Datatables (Tablas interactivas)
- **Arquitectura**: Patrón MVC simplificado

## 📋 Requisitos del Sistema

- Servidor Web (Apache/Nginx)
- PHP 7.4 o superior (Recomendado PHP 8.2)
- MySQL o MariaDB
- Extensión `mysqli` habilitada en PHP

## 🔧 Instalación

1.  **Clonar o descargar** el repositorio en tu servidor local (ej. htdocs en XAMPP).
2.  **Importar la base de datos**:
    - Crea una base de datos llamada `yibun`.
    - Importa el archivo `schema.sql` ubicado en la raíz del proyecto.
3.  **Configurar la conexión**:
    - Edita el archivo `core/controller/Database.php` con tus credenciales de base de datos.
4.  **Acceder al sistema**:
    - Abre tu navegador y dirígete a `http://localhost/yibun`.
    - **Credenciales por defecto**:
        - Usuario: `admin`
        - Contraseña: `admin`

## 🤝 Contribución

Si deseas contribuir a este proyecto, siéntete libre de hacer un fork y enviar tus pull requests. ¡Toda ayuda es bienvenida!

---

Desarrollado con ❤️ por [Evilnapsis](https://github.com/evilnapsis)
