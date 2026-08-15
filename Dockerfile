FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
    && cd frontend && npm install && npm run build && cd .. \
    && cp -r frontend/dist/* public/ \
    && chmod +x start.sh

EXPOSE 8000

CMD ["./start.sh"]
