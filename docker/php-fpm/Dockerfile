FROM phpdockerio/php:8.1-fpm
WORKDIR "/app"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ENTRYPOINT ["php", "/app/app/Infrastructure/Console/main.php"]