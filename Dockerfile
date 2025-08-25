# Dockerfile Final de Diagnóstico

FROM composer:2 as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

FROM node:18-alpine as frontend
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

RUN apk add --no-cache nginx supervisor postgresql-dev libzip-dev zip; \
    docker-php-ext-install pdo pdo_pgsql zip bcmath

# Mostra a versão e módulos do Nginx nos logs de deploy
RUN nginx -V

COPY --from=frontend /app /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage

EXPOSE 8080
ENTRYPOINT ["entrypoint.sh"]
