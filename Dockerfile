FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies + build assets (THIS FIXES CSS)
RUN npm install
RUN npm run build

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

# Laravel optimizations
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:cache

EXPOSE 10000

# Run Laravel
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]