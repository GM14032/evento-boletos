# Using PHP 8
FROM php:8.2-apache

RUN a2enmod rewrite

# install dependecies
## RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip
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
# ENV DATABASE_URL=postgres://igfevents:QG7APKFuzzGeltQIgUS6AwG39YP0OazF@dpg-ckm84i0710pc7380vbqg-a.oregon-postgres.render.com/igfevents
ENV APP_KEY=base64:3lUj/ZNpIIox/dKQO5cslz/GLOZR3sUtDnK5DdJQhyU=
ENV DB_CONNECTION=mysql
ENV DB_HOST=containers-us-west-150.railway.app
ENV DB_PORT=5819
ENV DB_DATABASE=railway
ENV DB_USERNAME=root
ENV DB_PASSWORD=clMjDWPbbq3ASGc6uner
ENV APP_ENV=production

ENV MAIL_MAILER=smtp
ENV MAIL_HOST=smtp.gmail.com
ENV MAIL_PORT=587
ENV MAIL_USERNAME=dsi.restaurante15@gmail.com
ENV MAIL_PASSWORD="rwty asam ttkg yisf"
ENV MAIL_FROM_ADDRESS="dsi.restaurante15@gmail.com"

# Copy files
COPY . .

RUN chmod -R 755 /var/www/html

# Install composer dependencies
RUN composer install

# Run commands
RUN php artisan config:cache
RUN php artisan route:cache
## RUN php artisan migrate --force

# Exponse port
EXPOSE 80
EXPOSE 443
EXPOSE 8000

# RUN php /var/www/html/artisan serve --host=0.0.0.0 &

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
# ENTRYPOINT ["apache2-foreground"]
