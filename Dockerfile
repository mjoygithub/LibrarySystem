# Use official php-apache image
FROM php:8.2-apache

# Install system deps and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql

# Enable Apache rewrite (if you use it)
RUN a2enmod rewrite

# Copy app to webroot
COPY . /var/www/html/

# Ensure proper ownership & permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Expose port (Render handles forwarding)
EXPOSE 8080

# Use apache on foreground
CMD ["apache2-foreground"]
