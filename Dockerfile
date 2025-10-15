# Usa una imagen oficial de PHP 8.2 con FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Instala dependencias del sistema necesarias para las extensiones de PHP y Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    # --- AÑADIMOS LA LIBRERÍA DE POSTGRESQL ---
    libpq-dev

# Limpia la caché de apt para reducir el tamaño de la imagen
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala las extensiones de PHP más comunes para Laravel
# --- ¡AQUÍ AÑADIMOS EL DRIVER DE POSTGRESQL! ---
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instala Composer (el gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo de la aplicación
WORKDIR /var/www

# Copia los archivos de la aplicación al contenedor
COPY . .

# --- PROCESO DE BUILD CORRECTO ---
# 1. Crea el archivo .env a partir del ejemplo.
RUN cp .env.example .env

# 2. Instala las dependencias de Composer PRIMERO.
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 3. AHORA, genera la clave de aplicación.
RUN php artisan key:generate
# --- FIN DEL PROCESO ---

# Instala las dependencias de Node.js y compila los assets para producción
RUN npm install && npm run build

# Copia el script de inicio al contenedor
COPY entrypoint.sh /usr/local/bin/
# Le da permisos de ejecución al script
RUN chmod +x /usr/local/bin/entrypoint.sh
# Establece el script como el punto de entrada del contenedor
ENTRYPOINT ["entrypoint.sh"]

# Expone el puerto en el que correrá la aplicación
EXPOSE 10000

