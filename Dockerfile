FROM php:8.2-cli

# libs + extensões PHP
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Node (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# dependências PHP
RUN composer install --no-dev --optimize-autoloader

# dependências JS + build do Vite (gera public/build/manifest.json)
RUN npm ci || npm install
RUN npm run build

# permissões
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000
