FROM php:8.0-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev openssl \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip 
RUN mkdir -p /usr/local/bin
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring

WORKDIR /app
COPY composer.json .
RUN composer install --no-scripts
COPY . .

EXPOSE 8080
CMD php artisan serve --host=0.0.0.0
