#!/bin/sh

# Mude para o diretório da aplicação
cd /var/www/html

# Limpa os caches antigos para garantir que as novas configurações e views sejam usadas
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Rode as migrations do banco de dados
php artisan migrate --force

# Inicie o supervisor (que gerencia o Nginx e o PHP-FPM)
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
