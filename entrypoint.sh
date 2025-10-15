#!/bin/sh

# Limpia TODAS las cachés de Laravel (configuración, rutas, vistas, etc.)
# Esto asegura que la aplicación lea las variables de entorno frescas de Render en cada inicio.
echo "Clearing all Laravel caches for a fresh start..."
php artisan optimize:clear

# Ejecuta las migraciones de la base de datos de forma segura.
echo "Running database migrations..."
php artisan migrate --force

# Inicia el servidor de Laravel para atender las peticiones.
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=10000

