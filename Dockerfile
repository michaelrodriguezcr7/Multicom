FROM php:8.2-cli

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /app

# Copia todo el código
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Puerto por defecto
EXPOSE 10000

# Comando para iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
