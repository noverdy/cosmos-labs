FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip

RUN a2enmod rewrite headers

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]