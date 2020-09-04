FROM immediate/php:7.4-fpm AS app

ARG COMPOSER_AUTH="{}"

ENV APP_ENV=prod COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:1.9 /usr/bin/composer /usr/bin/composer

RUN set -eux; \
    composer global require hirak/prestissimo --prefer-dist --no-progress --no-suggest --no-plugins --no-scripts -a; \
    composer clear-cache;

COPY --chown=www-data:www-data app/composer.* app/symfony.lock ./

RUN set -xe; \
    apk --update add --no-cache git; \
    composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest --ignore-platform-reqs --no-interaction; \
    composer clear-cache;

COPY --chown=www-data:www-data app ./

RUN composer dump-autoload -a; \
    composer run-script --no-dev post-install-cmd; \
    composer dump-env prod; \
    chmod -R 777 var;

COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

USER www-data

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

FROM app AS app_dev

USER root
