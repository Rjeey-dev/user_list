FROM php:7.4-fpm-alpine

# install deps
RUN set -xe \
    && apk add --no-cache \
        ${PHPIZE_DEPS} \
        openssh \
        openssl \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libxml2-dev \
        libmemcached-dev \
        libressl-dev \
        pkgconfig \
        zlib-dev \
        cyrus-sasl-dev \
        openjdk7-jre \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && docker-php-ext-install \
        intl \
        pcntl \
        sockets \
        opcache \
        zip \
    && pecl install -f \
        mongodb \
    && docker-php-ext-enable \
        mongodb \
    && apk add --no-cache --virtual .imagick-runtime-deps \
    && apk del ${PHPIZE_DEPS} \
    && rm -rf /tmp/*

# configure timezone
ARG TZ=America/New_York

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
    && echo "${TZ}" > /etc/timezone \
    && echo "date.timezone=${TZ}" > "${PHP_INI_DIR}/conf.d/date_tz.ini"

WORKDIR /var/www/app