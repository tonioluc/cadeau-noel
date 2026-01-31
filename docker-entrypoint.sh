#!/bin/bash
set -e

echo "=== Démarrage du service MagiCadeaux ==="

# Installation des dépendances si nécessaire
composer install --no-interaction --optimize-autoloader
echo "Installation des dépendances PHP avec Composer terminée."

# Génération de la clé
php artisan key:generate --force || true

echo "=== Réinitialisation de la base de données ==="
# Exécute les migrations fresh avec seed pour nettoyer les données des anciens utilisateurs
php artisan migrate:fresh --seed --force

echo "=== Migrations et seed terminés ==="

# Vérifier si nginx est installé (pour Render/Dockerfile)
if command -v nginx &> /dev/null; then
    echo "=== Démarrage de Nginx et PHP-FPM ==="
    nginx -g 'daemon off;' &
    exec php-fpm -F
else
    # Pour docker-compose (nginx est un service séparé)
    echo "=== Démarrage de PHP-FPM ==="
    exec php-fpm
fi