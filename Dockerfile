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
    npm

# Limpia la caché de apt para reducir el tamaño de la imagen
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala las extensiones de PHP más comunes para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer (el gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo de la aplicación
WORKDIR /var/www

# Copia los archivos de la aplicación al contenedor
COPY . .

# Instala las dependencias de Composer (sin las de desarrollo) y optimiza el autoloader
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instala las dependencias de Node.js y compila los assets para producción
RUN npm install && npm run build

# Expone el puerto en el que correrá la aplicación dentro del contenedor
# Render redirigirá el tráfico externo al puerto 10000 internamente
EXPOSE 10000

# Comando para iniciar el servidor de Laravel cuando el contenedor se inicie
# Escucha en todas las interfaces de red (--host=0.0.0.0) en el puerto 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
