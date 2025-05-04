FROM php:8.2-apache

# Install ekstensi yang umum dipakai
RUN docker-php-ext-install mysqli

# Salin semua file ke direktori web Apache
COPY . /var/www/html/

# Hak akses yang benar
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Aktifkan mod_rewrite jika diperlukan
RUN a2enmod rewrite

EXPOSE 80
