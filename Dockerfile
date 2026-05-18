FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Copy files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies
RUN npm install

# Build frontend assets
RUN npm run build

# Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

# Router script
RUN echo '<?php \
$uri = urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)); \
if ($uri !== "/" && file_exists(__DIR__."/public".$uri)) { \
    return false; \
} \
require_once __DIR__."/public/index.php"; \
' > router.php

# Expose port
EXPOSE 8080

# Start Laravel server
CMD ["php", "-S", "0.0.0.0:8080", "router.php"]