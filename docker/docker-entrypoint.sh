#!/bin/sh
set -e

echo "Starting PHP container with APP_ENV=${APP_ENV:-prod}"

# Composer install (only if vendor is missing)
if [ -z "$(ls -A 'vendor/' 2>/dev/null)" ]; then
    if [ "${APP_ENV}" = "prod" ]; then
        echo "Running composer install for production"
        composer install --no-dev --prefer-dist --no-progress --no-interaction --optimize-autoloader
    else
        echo "Running composer install for development"
        composer install --prefer-dist --no-progress --no-interaction
    fi
fi

# Wait for database if needed
if grep -q ^DATABASE_URL= .env; then
    echo 'Waiting for database to be ready...'
    ATTEMPTS_LEFT_TO_REACH_DATABASE=60
    until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php bin/console dbal:run-sql -q "SELECT 1" 2>&1); do
        if [ $? -eq 255 ]; then
            ATTEMPTS_LEFT_TO_REACH_DATABASE=0
            break
        fi
        sleep 1
        ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
        echo "  Still waiting... $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left"
    done

    if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
        echo 'The database is not up or not reachable:'
        echo "$DATABASE_ERROR"
        exit 1
    else
        echo 'Database is now ready'
    fi

    echo "Running doctrine migrations"
    php bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing

    if [ "${APP_ENV}" != "prod" ]; then
        echo "Loading fixtures..."
        php bin/console doctrine:fixtures:load --no-interaction
    fi
fi

# Set permissions for cache/logs
echo "Setting permissions on var/"
setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

echo 'PHP app ready!'

exec "$@"
