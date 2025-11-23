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

# Fix permissions for the web user (www-data/1000)
# serversideup image uses user 1000 by default for application
RUN chown -R 9999:9999 /var/www/html/storage /var/www/html/bootstrap/cache

# Switch back to the application user
USER 9999

# Set custom entrypoint for Laravel caching
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
USER root
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
USER 9999

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

