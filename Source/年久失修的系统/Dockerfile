FROM frankli0324/php:7.2-fpm-alpine-nginx-openrc

RUN apk add --no-cache mariadb mariadb-client

RUN rc-update add mariadb default && /etc/init.d/mariadb setup

RUN docker-php-source extract && docker-php-ext-install mysqli && docker-php-source delete

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i -e 's/mysqli.default_socket.*/mysqli.default_socket = \/var\/run\/mysqld\/mysqld.sock/g' \
    "$PHP_INI_DIR/php.ini"

COPY init.sql /init.sql
COPY html /var/www/html
COPY site.conf /etc/nginx/conf.d/default.conf
RUN chown -R www-data:www-data /var/www/html

COPY docker-php-entrypoint /etc/docker-php-entrypoint
RUN chmod +x /etc/docker-php-entrypoint

EXPOSE 80

CMD ["/etc/docker-php-entrypoint"]
