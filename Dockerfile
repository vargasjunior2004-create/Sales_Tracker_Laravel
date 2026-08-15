FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libpq-dev \
    libzip-dev libicu-dev libfreetype6-dev libjpeg64-turbo-dev libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
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

EXPOSE 8000

CMD ["./start.sh"]
