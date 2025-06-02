FROM php:8.2-fpm

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    npm \
    nodejs \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем проект
WORKDIR /var/www
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Генерируем ключ (если надо — вручную потом)
# RUN php artisan key:generate

# Указываем порт
EXPOSE 8000

# Стартуем Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
