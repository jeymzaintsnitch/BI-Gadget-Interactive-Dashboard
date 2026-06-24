FROM richarvey/nginx-php-fpm:3.1.6

# 1. Explicitly set the working directory FIRST
WORKDIR /var/www/html

# 2. Copy your project files into that directory
COPY . .

# 3. Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# 4. Install dependencies safely during the build phase
RUN composer install --no-dev --optimize-autoloader

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

CMD ["/start.sh"]