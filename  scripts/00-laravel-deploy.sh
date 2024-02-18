#!/usr/bin/env bash

# Set permissions for storage directory
chmod -R  775 /var/www/html/storage

# Copy environment file
echo "Running composer"
cp /etc/secrets/.env .env

# Install dependencies
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "generating application key..."
php artisan key:generate --show

# Create symbolic link for public storage
php artisan storage:link

# Clear caches
echo "Clearing caches..."
php artisan optimize:clear



# Cache configurations and routes
echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

echo "done deploying"
