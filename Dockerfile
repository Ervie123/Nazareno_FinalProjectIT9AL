FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix storage permissions (important for Laravel)
RUN chmod -R 775 storage bootstrap/cache

# ⚠️ DO NOT run migrations or key generate in build
# RUN php artisan migrate --force ❌ REMOVE THIS
# RUN php artisan key:generate ❌ REMOVE THIS

# Expose Render port
EXPOSE 10000

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=10000