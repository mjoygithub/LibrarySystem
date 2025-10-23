# Use official PHP with Apache image
FROM php:8.2-apache

# Enable commonly needed PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into Apache web root
COPY ./libsystem /var/www/html/

# Expose port 80
EXPOSE 80

# Set working directory
WORKDIR /var/www/html

# Optional: set timezone to Asia/Manila
RUN echo "date.timezone=Asia/Manila" > /usr/local/etc/php/conf.d/timezone.ini
