FROM php:8.1-fpm-alpine

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --no-cache \
      libzip-dev \
      zip \
    && docker-php-ext-install zip

RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/lib/ \
        --with-png-dir=/usr/lib/ \
        --with-jpeg-dir=/usr/lib/ \
        --with-gd

RUN NUMPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-install -j${NUMPROC} gd