FROM php:7.4-fpm

RUN pecl install xdebug-3.1.0 && docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo_mysql
# Download composer 2.1.12
RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/7eb36fbca44eafe780f225b3b005697b43feb3c0/web/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm /usr/local/etc/php/php.ini-production
RUN rm /usr/local/etc/php/php.ini-development
COPY dev/php.ini /usr/local/etc/php
