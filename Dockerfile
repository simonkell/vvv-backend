FROM php:7.3-apache
RUN docker-php-ext-install mysqli
#COPY . /var/www/html/
EXPOSE 80