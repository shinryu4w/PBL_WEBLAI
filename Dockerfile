FROM dunglas/frankenphp:1-php8.2-alpine

RUN apk add --no-cache \
    git \
    unzip \
    libpq-dev \
    postgresql-dev \
    bash

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress || true

COPY . .

ENV DOCUMENT_ROOT=/app/public

ENV PORT=8000
ENV SERVER_NAME=:${PORT}

EXPOSE 8000

CMD ["frankenphp", "run"]
