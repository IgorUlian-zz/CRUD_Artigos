# Dockerfile para Laravel na Render.com (Versão Corrigida e Simplificada)

# Etapa 1: Instalar dependências do Composer
FROM composer:2 as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Etapa 2: Instalar dependências do Node e construir assets
FROM node:18-alpine as frontend
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Etapa 3: Montar a imagem final com PHP-FPM e Nginx
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Instalar extensões PHP e pacotes do sistema
RUN apk add --no-cache \
      nginx \
      supervisor \
      libzip-dev \
      zip \
      postgresql-dev; \
    docker-php-ext-install pdo pdo_pgsql zip bcmath

# --- INÍCIO DA CORREÇÃO PRINCIPAL ---
# Copia a aplicação inteira (com todos os arquivos) do estágio 'frontend'
COPY --from=frontend /app /var/www/html

# Copia as dependências do Composer já instaladas, sobrepondo a pasta 'vendor'
COPY --from=vendor /app/vendor /var/www/html/vendor
# --- FIM DA CORREÇÃO PRINCIPAL ---

# Copiar as configurações do Nginx, Supervisor e o script de entrypoint
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage

EXPOSE 8080

# Define o script de inicialização como o ponto de entrada
ENTRYPOINT ["entrypoint.sh"]
