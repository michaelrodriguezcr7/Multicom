# Usa una imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones requeridas por Laravel y herramientas comunes
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Establece el directorio actual de trabajo
WORKDIR /var/www/html

# Asigna permisos (muy importante para Laravel)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Habilita Apache Rewrite Module
RUN a2enmod rewrite

# Configura el VirtualHost
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf
