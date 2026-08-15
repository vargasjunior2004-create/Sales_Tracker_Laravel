FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip nginx \
    libpng-dev libonig-dev libxml2-dev libpq-dev \
    libzip-dev libicu-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install \
        pdo_pgsql mbstring exif pcntl bcmath gd zip xml intl fileinfo dom opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction

COPY . .

RUN composer dump-autoload --optimize --no-interaction \
    && cd frontend && npm install && npm run build && cd .. \
    && cp -r frontend/dist/* public/ \
    && chmod +x start.sh

RUN cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.bak && \
    rm /etc/nginx/sites-enabled/default

COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 8000

CMD service php8.4-fpm start && nginx -g "daemon off;"
