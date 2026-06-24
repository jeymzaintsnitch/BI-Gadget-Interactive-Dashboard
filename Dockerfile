FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER 1

# Ignore PHP version platform reqs (Docker image ships PHP 8.2, some locked
# packages declare PHP >=8.4 but work fine on 8.2 at runtime).
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Aiven SSL CA cert — copied from storage/aiven-ca.pem via COPY . .
ENV MYSQL_ATTR_SSL_CA /var/www/html/storage/aiven-ca.pem

CMD ["/start.sh"]