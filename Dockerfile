# Use PHP 8 with Apache
FROM php:8.1-apache

# Enable PDO and PostgreSQL extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# ✅ Point Apache to /public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80
