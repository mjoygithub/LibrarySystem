# Use official PHP with Apache
FROM php:8.2-apache

# Install system tools and PHP extensions
RUN apt-get update && apt-get install -y git unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY ./libsystem /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install PHP dependencies (PHPMailer, etc.)
RUN composer install --no-interaction --no-dev || true

# Expose port 80
EXPOSE 80
