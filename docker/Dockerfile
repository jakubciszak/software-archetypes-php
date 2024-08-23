ARG PHP_VERSION=8.3
ARG XDEBUG_VERSION=3.3.2

FROM composer/composer:2-bin AS composer

FROM mlocati/php-extension-installer:latest AS php_extension_installer

#######################################################################################################

FROM php:${PHP_VERSION}-cli-alpine AS app

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1


WORKDIR /var/www/html

COPY --from=php_extension_installer --link /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer --link /composer /usr/bin/composer

RUN apk add --no-cache acl fcgi file gettext git shadow  nano openssh-client supervisor
RUN set -eux;  \
    install-php-extensions  \
        apcu  \
        intl  \
        iconv  \
        opcache  \
        zip  \
        amqp  \
        xml;

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
CMD ["cli"]

#######################################################################################################

FROM app AS php_dev

ARG UID=1000
ARG GID=1000
ENV XDEBUG_MODE=off
ARG XDEBUG_VERSION=3.3.2

RUN set -eux; install-php-extensions xdebug-${XDEBUG_VERSION}

RUN mv "$PHP_INI_DIR/php.ini" "$PHP_INI_DIR/php.ini-production"; \
	mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini";

COPY --link ./docker/app.dev.ini $PHP_INI_DIR/conf.d/

RUN mkdir -p /var/www/html

COPY --link ./app /var/www/html

RUN groupmod -g $GID www-data && \
    usermod -u $UID --shell /bin/bash www-data \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html
USER www-data

RUN composer install --no-interaction --no-progress --no-suggest --no-scripts

CMD ["cli"]
