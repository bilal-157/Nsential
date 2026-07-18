FROM php:8.4-fpm-alpine

# System packages needed to build PHP extensions
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make

# PHP extensions Laravel + this project need
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        zip \
        gd \
        bcmath \
        pcntl \
        mbstring

# Redis extension via PECL (not bundled with base image)
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer (copied from official composer image, not installed via curl)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy the rest of the app
COPY . .

RUN composer dump-autoload --optimize \
    && php artisan config:cache || true

# Correct permissions for Laravel's writable dirs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]