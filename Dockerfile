FROM dunglas/frankenphp:1-php8.2-alpine

# Install required system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libpq-dev \
    postgresql-dev \
    bash

# Enable PDO PostgreSQL extension
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies (adjust flags if you need dev deps)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress || true

# Copy the rest of the application code
COPY . .

# Set document root to the public directory so FrankenPHP serves public/index.php
ENV DOCUMENT_ROOT=/app/public

# Railway will provide PORT; FrankenPHP uses SERVER_NAME to bind.
# Default to :8000 if PORT is not set.
ENV PORT=8000
ENV SERVER_NAME=:${PORT}

# Expose default port (Railway will map this)
EXPOSE 8000

# Use FrankenPHP's built-in HTTP server (not Caddy's "serve" command)
# "run" uses the default embedded configuration and serves DOCUMENT_ROOT.
CMD ["frankenphp", "run"]
