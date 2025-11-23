#!/bin/bash

# Run standard Laravel production commands as the web user to avoid permission issues
su -s /bin/bash -c "php artisan config:cache" www-data
su -s /bin/bash -c "php artisan route:cache" www-data
su -s /bin/bash -c "php artisan view:cache" www-data
su -s /bin/bash -c "php artisan event:cache" www-data

# Run migrations
# su -s /bin/bash -c "php artisan migrate --force" www-data
