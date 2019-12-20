FROM php:fpm

# Install modules
RUN apt-get update && apt-get install -y \
        git \
        libzip-dev \
        zip \
        && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /source

EXPOSE 9000
CMD ["php-fpm"]