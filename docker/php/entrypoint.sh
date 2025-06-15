#!/bin/bash
set -e

# Correct permissions for storage and cache directories.
# This is necessary because the volume mount can override the permissions set in the Dockerfile.
echo "Updating file permissions..."
chown -R laravel_user:laravel_group /var/www/html/storage /var/www/html/bootstrap/cache


if [ "$1" = "php-fpm" ] || [ "$1" = "php" ]; then
    # Running as root temporarily to ensure permissions if needed, then su to laravel_user

    echo "Running Laravel setup commands as laravel_user..."

    # As laravel_user:
    gosu laravel_user php artisan config:cache
    gosu laravel_user php artisan route:cache
    gosu laravel_user php artisan view:cache
    # gosu laravel_user php artisan event:cache # Uncomment if you use event discovery
    

    if [ "${IS_PRIMARY_APP_INSTANCE}" = "true" ]; then
        echo "Running database migrations (primary instance only)..."
        gosu laravel_user php artisan migrate --force --seed 
    else
        echo "Skipping migrations on this app instance."
    fi

    echo "Laravel setup commands complete."
fi

# If the command is php-fpm, we execute it as root.
# The php-fpm process will then read our www.conf and spawn workers as the 'laravel_user'.
if [ "$1" = "php-fpm" ]; then
    echo "Starting php-fpm..."
    exec "$@"
else
    # For any other command (like 'php artisan queue:work'),
    # we execute it as the laravel_user 
    echo "Executing command as laravel_user: $@"
    exec gosu laravel_user "$@"
fi 