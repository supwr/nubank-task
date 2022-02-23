FROM phpdockerio/php:8.1-fpm

WORKDIR /app

COPY --chown=www-data:www-data . /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer clearcache && composer install --no-dev --no-interaction --optimize-autoloader

RUN composer dump-autoload -o

CMD ["php", "/app/app/main.php"]