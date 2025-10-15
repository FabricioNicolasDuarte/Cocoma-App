#!/bin/sh

# Ejecuta las migraciones de la base de datos de forma segura para producción
echo "Running database migrations..."
php artisan migrate --force

# Inicia el servidor de Laravel para atender las peticiones
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=10000
