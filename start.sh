#!/bin/bash

echo "Esperando conexión con la base de datos..."

# Espera opcional para evitar errores de conexión muy rápidos
sleep 5

# Ejecuta migraciones
php artisan migrate --force

# Arranca Apache
exec apache2-foreground
