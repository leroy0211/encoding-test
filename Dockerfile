FROM php:7.2 as build

RUN mkdir -p /app/build

WORKDIR /app/build

COPY --from=composer:1.6 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip zlib1g-dev && \
    docker-php-ext-install zip

COPY composer.json composer.lock ./

RUN composer install -n --no-dev --no-scripts --no-suggest --no-progress --no-autoloader

COPY . .

RUN composer dump-autoload


FROM php:7.2

RUN mkdir -p /app

WORKDIR /app

COPY --from=build /app/build /app

CMD php -S 0.0.0.0:80 -t .