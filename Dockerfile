FROM php:8.4.7

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Установка рабочего каталога
WORKDIR /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
