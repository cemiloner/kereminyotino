FROM php:8.1-apache

# 1) Gerekli paketler: PostgreSQL dev, zip, unzip
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
 && docker-php-ext-install pdo pdo_pgsql

# 2) Apache mod_rewrite aktif
RUN a2enmod rewrite

# 3) DocumentRoot'u /var/www/html/public yap
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# 4) AllowOverride None -> All (Doğru dosya yolunu kullanma)
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 5) Composer kur
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# 6) Çalışma dizini
WORKDIR /var/www/html

# 7) Dosya izinlerini ayarla - Apache kullanıcısına yazma izni ver
RUN chown -R www-data:www-data /var/www/html
