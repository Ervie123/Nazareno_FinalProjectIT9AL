FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

# IMPORTANT: ensure public permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# 🔥 PRODUCTION SAFE SERVER
CMD php -S 0.0.0.0:10000 -t public