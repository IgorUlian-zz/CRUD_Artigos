#!/bin/sh

# Mude para o diretório da aplicação
cd /var/www/html

# Primeiro, garanta que o banco de dados esteja atualizado
echo "Running database migrations..."
php artisan migrate --force

echo "Linking storage..."
php artisan storage:link

# Agora, crie os arquivos de cache otimizados para produção
echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Starting server..."
# Inicie o supervisor (que gerencia o Nginx e o PHP-FPM)
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
