#!/bin/sh

# Limpia cualquier caché antigua para asegurar un estado limpio.
echo "Clearing all Laravel caches..."
php artisan optimize:clear

# ¡EL PASO CLAVE!
# Crea una nueva caché de configuración leyendo las variables de entorno de Render.
# Esto "cocina" la configuración correcta (DB_CONNECTION=pgsql) en la aplicación.
echo "Caching configuration for production..."
php artisan config:cache

# Ejecuta las migraciones de la base de datos de forma segura.
echo "Running database migrations..."
php artisan migrate --force

# Inicia el servidor de Laravel.
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=10000

