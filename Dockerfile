FROM php:7.4-cli-alpine3.11

RUN apk add --update --no-cache oniguruma-dev $PHPIZE_DEPS \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install mbstring;

ENV PHP_IDE_CONFIG "serverName=docker-server"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer;

COPY . /usr/app

WORKDIR /usr/app
ENTRYPOINT ["tail", "-f", "/dev/null"]
