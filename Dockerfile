FROM php:7.2.34-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# RUN apt-get update && apt-get -y​ upgrade 
COPY . /var/www/html/
