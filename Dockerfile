FROM node:20-slim AS node_builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./
COPY public ./public

RUN npm run build

FROM serversideup/php:8.3-fpm-nginx

WORKDIR /var/www/html

# Install additional PHP extensions if needed (serversideup image comes with most)
# RUN install-php-extensions intl bcmath

# Switch to root to copy files and set permissions
USER root

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

