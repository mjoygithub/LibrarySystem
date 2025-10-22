# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# Install system dependencies and PostgreSQL extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql

# Enable Apache rewrite module (if needed)
RUN a2enmod rewrite

# Copy application code to Apache web root
COPY . /var/www/html/

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Expose port (Render handles port forwarding)
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
