FROM php:7.4-fpm-alpine

COPY app/composer.json /var/www/html

RUN ln -sf /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
		\
		apk --no-cache --upgrade add nginx supervisor pcre-dev zlib-dev libzip-dev freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev ${PHPIZE_DEPS} && \
		\
    curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer && \
    mkdir /.composer && \
    \
    pecl install xdebug && \
    \
    docker-php-ext-install zip && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install gd && \
    docker-php-ext-enable xdebug && \
    apk del pcre-dev ${PHPIZE_DEPS} && \
    rm -rf /var/cache/apk/* && \
    addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www && \
    chown -R www. /run /var/lib/nginx /var/log/nginx /.composer /var/www/html && \
    composer install --no-interaction --no-ansi --no-progress && \
    composer clearcache

COPY app ./
COPY --chown=www:www app ./

USER www

COPY docker/fpm-pool.conf /usr/local/etc/php-fpm.d/app.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

VOLUME /var/www/html

EXPOSE 8080

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
