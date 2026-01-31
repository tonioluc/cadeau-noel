FROM php:8.2-fpm

# Dépendances système
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl

# Extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Configurer PHP-FPM pour écouter sur 127.0.0.1:9000
RUN echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Code
WORKDIR /var/www/html
COPY . .

# Créer les dossiers nécessaires pour Nginx
RUN mkdir -p /etc/nginx/sites-available && \
    mkdir -p /etc/nginx/sites-enabled && \
    mkdir -p /var/log/nginx

# Nginx config - copie et crée le lien symbolique
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Supprime la config par défaut si elle existe
RUN rm -f /etc/nginx/sites-enabled/default.bak 2>/dev/null || true

# Test la configuration Nginx
RUN nginx -t

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Rendre le script d'entrée exécutable
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

EXPOSE 80

# Script de démarrage qui exécute les migrations puis lance les services
CMD ["/docker-entrypoint.sh"]