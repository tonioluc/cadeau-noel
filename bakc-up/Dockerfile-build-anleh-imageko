FROM php:8.2-fpm

# Installer les extensions PHP nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer en tant que root d'abord
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Créer l'utilisateur www-data avec UID/GID 1000
RUN groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 www-data

# Créer le dossier composer avec les bonnes permissions
RUN mkdir -p /var/www/.composer && \
    chown -R www-data:www-data /var/www/.composer

# Copier UNIQUEMENT les fichiers nécessaires pour Composer
COPY --chown=www-data:www-data composer.json composer.lock artisan ./

# Passer à l'utilisateur www-data POUR l'installation des dépendances
USER www-data

# Configurer Composer avec le bon HOME directory
ENV COMPOSER_HOME=/var/www/.composer

# Installer les dépendances (en tant que www-data)
RUN composer config -g repo.packagist composer https://packagist.org \
    && composer config -g github-protocols https \
    && composer install --no-dev --optimize-autoloader --no-progress --no-scripts

# Revenir à root pour copier les fichiers
USER root

# Copier TOUT le reste du code source
COPY --chown=www-data:www-data . .

# Exécuter les scripts Composer (artisan existe)
USER www-data
RUN composer run-script post-autoload-dump

# Donner les permissions CORRECTES (déjà fait avec --chown)
RUN chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod +x artisan

# Changer définitivement vers l'utilisateur www-data
USER www-data

# Commande par défaut
CMD ["php-fpm"]