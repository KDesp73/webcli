FROM php:8.2-cli

# Install dependencies & composer
RUN apt-get update && apt-get install -y \
    git unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY src ./src
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy router
COPY router.php ./

# Expose port
EXPOSE 8000

# Start built-in PHP server
CMD ["php", "-S", "0.0.0.0:8000", "router.php"]
