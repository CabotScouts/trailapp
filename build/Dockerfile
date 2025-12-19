FROM composer:2.9 AS composer
WORKDIR /app
COPY ../app/composer.json ../app/composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader
COPY ../app .

FROM node:latest-alpine AS react



FROM php:8.3-apache

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
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    -j$(nproc) gd \
    intl \
    opcache \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    exif \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

RUN a2enmod rewrite
RUN a2enmod negotiation
RUN a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
