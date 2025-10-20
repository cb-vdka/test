# Simple Laravel production image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy package files
COPY package.json package-lock.json ./
RUN npm ci

# Copy application files
COPY . .

# Build assets
RUN npm run build

# Set proper permissions and create all required directories
RUN mkdir -p storage/app/public \
    && mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Remove node_modules to reduce image size
RUN rm -rf node_modules

# Create startup script that works well with volume mounts
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "🚀 Starting Laravel application..."\n\
\n\
# Wait a moment for volumes to be mounted\n\
sleep 2\n\
\n\
# Create required directories (in case volumes are empty)\n\
mkdir -p storage/app/public\n\
mkdir -p storage/framework/cache/data\n\
mkdir -p storage/framework/sessions\n\
mkdir -p storage/framework/views\n\
mkdir -p storage/logs\n\
mkdir -p bootstrap/cache\n\
\n\
# Fix permissions for mounted volumes\n\
echo "🔧 Setting up permissions..."\n\
find storage -type d -exec chmod 775 {} \\;\n\
find storage -type f -exec chmod 664 {} \\;\n\
find bootstrap/cache -type d -exec chmod 775 {} \\;\n\
find bootstrap/cache -type f -exec chmod 664 {} \\;\n\
\n\
# Try to change ownership (may fail with volumes, thats ok)\n\
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "⚠️  Could not change ownership (this is normal with volume mounts)"\n\
\n\
# Check if .env exists and is readable\n\
if [ ! -f .env ]; then\n\
    echo "❌ .env file not found! Creating default..."\n\
    cp .env.example .env 2>/dev/null || echo "APP_KEY=" > .env\n\
    php artisan key:generate --force\n\
else\n\
    echo "✅ .env file found"\n\
fi\n\
\n\
# Clear any existing caches (important with volume mounts)\n\
echo "🧹 Clearing caches..."\n\
php artisan config:clear 2>/dev/null || true\n\
php artisan cache:clear 2>/dev/null || true\n\
php artisan view:clear 2>/dev/null || true\n\
php artisan route:clear 2>/dev/null || true\n\
\n\
# Run optimizations\n\
echo "⚡ Optimizing application..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Run migrations\n\
echo "🗄️  Running migrations..."\n\
php artisan migrate --force || echo "⚠️  Migrations failed or no database connection"\n\
\n\
# Create storage link\n\
echo "🔗 Creating storage link..."\n\
php artisan storage:link --force || echo "⚠️  Storage link failed"\n\
\n\
echo "✅ Laravel application setup completed!"\n\
echo "🌐 Starting server on http://0.0.0.0:8002"\n\
\n\
# Start Laravel server\n\
php artisan serve --host=0.0.0.0 --port=8002' > /start.sh \
    && chmod +x /start.sh

# Expose port
EXPOSE 8002

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:8002 || exit 1

# Start application
CMD ["/start.sh"]
