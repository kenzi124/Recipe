
FROM php:8.3.7-apache as final

WORKDIR /app

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY . /var/www/html

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql mysqli

USER www-data