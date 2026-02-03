# Libreria Patty

Sistema de gestion de biblioteca con catalogo de libros, comentarios y puntuaciones.

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- XAMPP (opcional para desarrollo local)

## Instalacion

1. Clonar el repositorio
```bash
git clone <url-del-repo>
cd libreria-patty
```

2. Copiar archivo de configuracion
```bash
cp .env.example .env
```

3. Editar `.env` con tus credenciales de base de datos

4. Importar base de datos
```bash
mysql -u root -p < database/database.sql
```

## Ejecucion

### Con PHP built-in server
```bash
cd public
php -S localhost:8000
```

### Con XAMPP
1. Copiar proyecto a `C:\xampp\htdocs\libreria-patty`
2. Iniciar Apache y MySQL desde XAMPP
3. Abrir `http://localhost/libreria-patty/public`

## Credenciales por defecto

- **Admin**: admin@libreria.com / admin123


