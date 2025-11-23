# Stage 1: Install Composer Dependencies (needed for Filament assets)
FROM serversideup/php:8.3-fpm-nginx AS composer_deps
WORKDIR /app
USER root
COPY . .
RUN composer install --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs

# Stage 2: Build Frontend Assets
FROM node:20-slim AS node_builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
# Copy vendor directory so Tailwind can find Filament assets
COPY --from=composer_deps /app/vendor ./vendor

RUN npm run build

# Stage 3: Final Image
FROM serversideup/php:8.3-fpm-nginx

WORKDIR /var/www/html

# Install additional PHP extensions
USER root
RUN install-php-extensions intl bcmath zip

COPY . .
COPY --from=node_builder /app/public/build ./public/build

# Install composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Fix permissions for the web user
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Add custom startup script to serversideup's entrypoint system
COPY docker-entrypoint.sh /etc/entrypoint.d/99-laravel-deploy.sh
RUN chmod +x /etc/entrypoint.d/99-laravel-deploy.sh

EXPOSE 80

