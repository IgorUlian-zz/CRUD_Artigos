#!/bin/sh

# Mude para o diretório da aplicação
cd /var/www/html

# Rode as migrations do banco de dados
php artisan migrate --force

# Inicie o supervisor (que gerencia o Nginx e o PHP-FPM)
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
