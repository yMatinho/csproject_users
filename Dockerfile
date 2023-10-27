FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    nginx \
    wget \
    supervisor

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

RUN mkdir -p /var/www/html
COPY . /var/www/html

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /var/www/html && \
    /usr/local/bin/composer install --no-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN chown -R www-data:www-data /var/www

CMD ["sh", "/var/www/html/docker/startup.sh"]