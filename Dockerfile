FROM php:8.1-apache

# Laravel için gerekli PHP uzantılarını yükleyin
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer'ı kurun
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel dosyalarını kopyalayın
COPY . /var/www/html

# Laravel klasör izinlerini ayarlayın
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Varsayılan çalışma dizinini ayarlayın
WORKDIR /var/www/html

# Laravel'in başlatma komutunu çalıştırın
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
