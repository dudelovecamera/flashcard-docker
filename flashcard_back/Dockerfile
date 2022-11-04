FROM php:8.1-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev git
RUN apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libxml2-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml
RUN docker-php-ext-install soap
RUN apt-get install procps -y

#install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install pdo

WORKDIR /home/web/app
COPY ./src/composer*.json ./
COPY ./src/.env.example ./.env
COPY ./src .
# COPY wait-for .
RUN composer install
COPY docker-entrypoint.sh .

RUN addgroup web
RUN adduser --system --group web

# RUN chown -R web:web .
# RUN chmod -R 755 .
# RUN chmod -R 755 /opt
# USER web

EXPOSE 8000
