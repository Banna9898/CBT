# Use an official PHP image with Apache
FROM php:8.2-apache

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Enable Apache modules
RUN a2enmod rewrite

# Copy project files to web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Fix file permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Update Apache DocumentRoot to /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose web port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
