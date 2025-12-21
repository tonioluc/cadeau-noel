composer install --no-interaction --optimize-autoloader
echo "Installation des dépendances PHP avec Composer terminée."
php artisan key:generate
echo "Migration et lancer les seeders"
# Exécute les migrations et seed
php artisan migrate:fresh --seed --force

echo "Migrations et seed terminés."

# Démarre php-fpm
exec php-fpm