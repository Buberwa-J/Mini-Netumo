# Use an official PHP FPM image with Alpine Linux for a smaller size
ARG PHP_VERSION=8.2
FROM php:${PHP_VERSION}-fpm-alpine

# Arguments defined in docker-compose.yml
ARG USER_ID
ARG GROUP_ID

# Set working directory
WORKDIR /var/www/html


RUN apk update && apk add --no-cache \
    bash \
    curl \
    git \
    supervisor \
    libzip-dev \
    zlib-dev \
    oniguruma-dev \
    libxml2-dev \
    mariadb-dev \
    # For GD extension
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    # For intl extension
    icu-dev \
    # For sockets extension
    linux-headers \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    bcmath \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pcntl \
    pdo_mysql \
    sockets \
    xml \
    zip \
    && apk del .build-deps \
    # Install gosu
    && GOSU_VERSION=1.16 \
    && wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/1.16/gosu-amd64" \
    && chmod +x /usr/local/bin/gosu \
    && gosu nobody true

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a non-root user and group
RUN addgroup -g ${GROUP_ID} laravel_group && \
    adduser -u ${USER_ID} -G laravel_group -s /bin/sh -D laravel_user

# Copy existing application directory contents
COPY . /var/www/html

# Copy a custom php.ini if needed (optional)
# COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Set permissions for composer cache and laravel storage/bootstrap cache
# This needs to be done before composer install if composer needs to write to cache
RUN mkdir -p /home/laravel_user/.composer && \
    chown -R laravel_user:laravel_group /home/laravel_user && \
    chown -R laravel_user:laravel_group /var/www/html

# Switch to non-root user for subsequent commands
USER laravel_user

# Install Composer dependencies.
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Switch back to root to change permissions that laravel_user might not be able to
USER root

# Set permissions for storage and bootstrap/cache directories
# These directories need to be writable by the web server (nginx/php-fpm) and the queue worker.
RUN chown -R laravel_user:laravel_group /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000
EXPOSE 9000

# Copy our custom php-fpm config
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy and set up entrypoint
USER root
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
# Default CMD, will be overridden by docker-compose.yml for app vs worker
CMD ["php-fpm"] 