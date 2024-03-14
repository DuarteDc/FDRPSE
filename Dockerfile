FROM php:8.3

RUN apt-get update -y && \
    apt-get install -y openssl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql

COPY . ./app
WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install
RUN composer dump-autoload

EXPOSE 8001
