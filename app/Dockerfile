FROM php:8.0-apache

RUN apt update \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
            libfreetype6-dev \
		        libjpeg62-turbo-dev \
		        libpng-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install \
            -j$(nproc) gd \
            intl \
            opcache \
            pdo \
            pdo_mysql \
            pdo_pgsql \
            pgsql

WORKDIR /var/www

RUN a2enmod rewrite
RUN a2enmod negotiation

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
