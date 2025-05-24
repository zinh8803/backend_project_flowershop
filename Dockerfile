FROM php:8.1.10-fpm

# Cài extensions cần thiết
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy toàn bộ mã nguồn Laravel (nếu cần)

# Set quyền
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
