FROM frankli0324/php:7.0-fpm-alpine-nginx-openrc

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories

RUN apk add --no-cache libxml2-dev
RUN docker-php-source extract && docker-php-ext-install soap && docker-php-source delete

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY html /var/www/html
COPY site.conf /etc/nginx/conf.d/default.conf
RUN chown -R www-data:www-data /var/www/html

COPY docker-php-entrypoint /etc/docker-php-entrypoint
RUN chmod +x /etc/docker-php-entrypoint

EXPOSE 80

CMD ["/etc/docker-php-entrypoint"]
