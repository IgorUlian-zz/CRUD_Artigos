#!/bin/sh

# Mude para o diretório da aplicação
cd /var/www/html

# Limpa todos os caches antigos para um início limpo
echo "Clearing old cache and storage link..."
php artisan optimize:clear
rm -f public/storage

# Rode as migrations do banco de dados
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Crie o link de storage para as imagens e ficheiros
echo "Linking storage..."
php artisan storage:link

# Crie os caches otimizados para produção (importante para performance)
echo "Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server..."
# Inicie o supervisor (que gerencia o Nginx e o PHP-FPM)
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
