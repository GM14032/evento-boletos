# Using PHP 8
FROM php:8-fpm

# install dependecies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip

# enable extensions for php
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql


# Install composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# set working directory
WORKDIR /var/www/html

# Set environment variables
ENV DATABASE_URL=${DATABASE_URL}
ENV DB_HOST=${DB_HOST}
ENV APP_KEY=${APP_KEY}
ENV DB_CONNECTION=${DB_CONNECTION}

# Copy files
COPY . .

# Install composer dependencies
RUN composer install

# Run commands
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan migrate --force

# Exponse port
EXPOSE 9000

CMD ["php-fpm"]