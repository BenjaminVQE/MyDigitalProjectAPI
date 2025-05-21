FROM php:8.3-fpm

RUN mkdir -p /usr/src/app \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    libxml2-dev \
    libonig-dev \
    acl \
    g++ \
    make \
    net-tools \
    autoconf \
    pkg-config \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --link --chmod=755 docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

WORKDIR /usr/src/app

COPY ../../composer.json /usr/src/app/composer.json

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ../../ .

RUN chown -R www-data:www-data /usr/src/app

ENTRYPOINT ["docker-entrypoint"]

CMD ["php-fpm"]