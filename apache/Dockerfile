FROM php:8.1.10-apache
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install mysqli pdo pdo_mysql