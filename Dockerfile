# Use an official PHP image with Apache
FROM php:8.2-apache

# Install PDO and PDO MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy project files into the container
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
