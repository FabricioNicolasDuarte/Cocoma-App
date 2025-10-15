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

# --- CORRECCIÓN PARA EL ERROR DE BUILD ---
# 1. Crea el archivo .env a partir del ejemplo para que los scripts de Artisan funcionen.
RUN cp .env.example .env
# 2. Genera una clave de aplicación temporal para el proceso de construcción.
#    La clave real será inyectada por Render en producción.
RUN php artisan key:generate
# --- FIN DE LA CORRECCIÓN ---

# Instala las dependencias de Composer (sin las de desarrollo) y optimiza el autoloader
RUN composer install --no-interaction --optimize-autoloader --no-dev

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

