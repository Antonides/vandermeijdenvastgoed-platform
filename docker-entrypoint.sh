#!/bin/bash

# Exit on error
set -e

# Run standard Laravel production commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations (be careful with this in production if you have multiple instances starting at once)
# php artisan migrate --force

# Start the main process (delegates back to the base image's entrypoint)
exec /init
