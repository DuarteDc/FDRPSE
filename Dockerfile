FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/wwww/html/
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install
RUN composer dump-autoload

EXPOSE 8001

CMD [ "php", "./public/index.php" ]
