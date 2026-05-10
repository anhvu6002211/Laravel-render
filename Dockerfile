FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
        libjpeg-dev \
            libfreetype6-dev \
                zip \
                    unzip \
                        git \
                            curl \
                                libpq-dev \
                                    libonig-dev \
                                        libxml2-dev \
                                            libzip-dev \
                                                libicu-dev \
                                                    nodejs \
                                                        npm

                                                        # Clear cache
                                                        RUN apt-get clean && rm -rf /var/lib/apt/lists/*

                                                        # Install PHP extensions
                                                        RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

                                                        # Install composer
                                                        COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

                                                        # Set working directory
                                                        WORKDIR /var/www/html

                                                        # Copy project files
                                                        COPY . .

                                                        # Install PHP dependencies
                                                        RUN composer install --no-interaction --optimize-autoloader --no-dev

                                                        # Set permissions
                                                        RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

                                                        # Enable apache mod_rewrite
                                                        RUN a2enmod rewrite

                                                        # Update apache config
                                                        RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

                                                        # Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 80

# Start apache via entrypoint
CMD ["/usr/local/bin/entrypoint.sh"]
