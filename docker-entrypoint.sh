#!/bin/bash
set -e

# Install composer dependencies if vendor directory doesn't exist
if [ ! -d "/var/www/html/vendor" ]; then
    echo "Installing Composer dependencies..."
    cd /var/www/html
    composer install --no-interaction
fi

# Always regenerate autoloader to fix autoloading issues
echo "Regenerating Composer autoloader..."
cd /var/www/html
composer dump-autoload -o

# Start Apache in foreground
echo "Starting Apache..."
apache2-foreground