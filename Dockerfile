# Use the official PHP image with PHP 8.3
FROM php:8.3

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www

# Copy existing Laravel project files into the container
COPY . /var/www

# Expose port 8000 for the Laravel development server
EXPOSE 8000
