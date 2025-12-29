FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Create a router script for static files
RUN echo '<?php \n\
$uri = urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)); \n\
if ($uri !== "/" && file_exists(__DIR__."/public".$uri)) { \n\
    $ext = pathinfo($uri, PATHINFO_EXTENSION); \n\
    $mimes = ["css" => "text/css", "js" => "application/javascript", "png" => "image/png", "jpg" => "image/jpeg", "gif" => "image/gif", "svg" => "image/svg+xml", "woff" => "font/woff", "woff2" => "font/woff2", "ttf" => "font/ttf"]; \n\
    if (isset($mimes[$ext])) { header("Content-Type: " . $mimes[$ext]); } \n\
    readfile(__DIR__."/public".$uri); \n\
    exit; \n\
} \n\
require_once __DIR__."/public/index.php"; \n\
' > /var/www/html/router.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "router.php"]
