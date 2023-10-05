FROM php:8.2.5-apache

RUN apt-get update

# Install tools required for build stage
RUN apt-get install -fyqq \
    bash curl wget rsync ca-certificates openssl ssh git tzdata openntpd \
    libxrender1 fontconfig libc6 \
    mariadb-client gnupg binutils-gold autoconf \
    g++ gcc gnupg libgcc1 linux-headers-amd64 make python

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
 && chmod 755 /usr/bin/composer

# Install nodejs
RUN wget https://nodejs.org/dist/latest-v18.x/node-v18.18.0-linux-x64.tar.gz \
    && tar -C /usr/local --strip-components 1 -xf ./node-v18.18.0-linux-x64.tar.gz 

# Install additional PHP libraries
RUN docker-php-ext-install bcmath pdo pdo_mysql mysqli

# Install libraries for compiling GD, then build it
RUN apt-get install -fyqq libfreetype6 libfreetype6-dev libpng16-16 libpng-dev libjpeg62-turbo libjpeg62-turbo-dev \
 && docker-php-ext-install gd \
 && apt-get remove -fyqq libfreetype6-dev libpng-dev libjpeg62-turbo-dev

# Add ZIP archives support
RUN apt-get install -fyqq zip libzip-dev \
 && docker-php-ext-install zip \
 && apt-get remove -fyqq libzip-dev

# Install xdebug
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

# Enable XDebug
ADD xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN a2enmod rewrite && service apache2 restart

WORKDIR /var/www/html
