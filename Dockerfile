FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Enable Apache Rewrite
RUN a2enmod rewrite

# Copy project
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-dev --optimize-autoloader

EXPOSE 80
