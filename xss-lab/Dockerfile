FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-install zip mysqli pdo_mysql

RUN a2enmod rewrite headers

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]