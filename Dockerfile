# Dockerfile para Laravel na Render.com

# Etapa 1: Instalar dependências do Composer
FROM composer:2 as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Etapa 2: Instalar dependências do Node e construir assets
FROM node:18-alpine as frontend
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# Etapa 3: Montar a imagem final com PHP-FPM e Nginx
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Instalar extensões PHP necessárias para o Laravel
RUN apk add --no-cache \
      nginx \
      supervisor \
      libzip-dev \
      zip \
      postgresql-dev; \
    docker-php-ext-install pdo pdo_pgsql zip bcmath

# Copiar arquivos da aplicação e dependências
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /app/public/ /var/www/html/public/
COPY --from=frontend /app/resources/ /var/www/html/resources/
COPY --from=frontend /app/storage/ /var/www/html/storage/
COPY --from=frontend /app/vite.config.js /var/www/html/
COPY --from=frontend /app/package.json /var/www/html/
COPY --from=frontend /app/artisan /var/www/html/
COPY --from=frontend /app/config/ /var/www/html/config/
COPY --from=frontend /app/routes/ /var/www/html/routes/
COPY --from=frontend /app/app/ /var/www/html/app/
COPY --from=frontend /app/bootstrap/ /var/www/html/bootstrap/
COPY --from=frontend /app/database/ /var/www/html/database/

# Copiar configuração do Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage

EXPOSE 8080

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ... (tudo que já estava antes)

# Copiar configuração do Nginx e Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# === INÍCIO DAS MUDANÇAS ===

# Copia o script de inicialização e o torna executável
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage

EXPOSE 8080

# Define o script de inicialização como o ponto de entrada
ENTRYPOINT ["entrypoint.sh"]

# === FIM DAS MUDANÇAS ===
