FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache || true

RUN php artisan optimize:clear
RUN php artisan config:clear
RUN php artisan route:clear
EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]