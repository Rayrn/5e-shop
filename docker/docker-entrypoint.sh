#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
  set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
  if [ "$APP_ENV" != 'prod' ]; then
    ln -sf "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
    composer install --prefer-dist --no-progress --no-suggest -o --no-interaction
    chmod -R 777 var
  fi
fi

exec docker-php-entrypoint "$@"
