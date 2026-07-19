# Use the official PHP image
FROM php:8.2-cli

# Install system dependencies required by standard PHP applications
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Set your working directory
WORKDIR /app

# Copy all your project files into the container
COPY . .

# Run Composer (Requires you to have your vendor folder ignored in .gitignore, which is standard)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Expose the port Render uses
EXPOSE $PORT

# The exact artisan command you requested
CMD php artisan serve --host=0.0.0.0 --port=$PORT