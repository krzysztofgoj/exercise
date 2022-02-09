FROM php:7.4-fpm-alpine

ENV PROJECT_PATH /app

RUN apk add --update zlib-dev icu icu-libs icu-dev nginx bash git curl g++ make libzip-dev

RUN docker-php-ext-install zip intl mysqli pdo pdo_mysql

RUN rm -rf /var/cache/apk/*

RUN mkdir -p /tmp/nginx/client-body

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

RUN mkdir -p $PROJECT_PATH

WORKDIR $PROJECT_PATH

EXPOSE 80