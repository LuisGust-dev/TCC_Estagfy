FROM php:8.2-cli

# deps do sistema + extensões
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev ca-certificates \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Node 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# deps PHP
RUN composer install --no-dev --optimize-autoloader

# deps Node + build Vite
RUN npm install
RUN npm run build

# ✅ PROVA no log (sem shell no free)
RUN echo "=== LIST public/build ===" \
 && ls -la public/build || true \
 && echo "=== LIST public/build/assets ===" \
 && ls -la public/build/assets || true

# permissões
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


RUN php artisan storage:link || true
# ✅ Render usa a env PORT (não fixe 10000)
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
