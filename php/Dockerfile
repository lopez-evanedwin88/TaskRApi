FROM php:7.3-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
# Install git
RUN apt-get install -y git
RUN apt-get update \
     && apt-get install -y libzip-dev \
     && docker-php-ext-install zip
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
