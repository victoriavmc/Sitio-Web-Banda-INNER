# Usar una imagen base de PHP
FROM php:8.3-fpm

# Instalar las extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libcurl4-openssl-dev \
    pkg-config \
    libonig-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install curl \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install fileinfo

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar el archivo de configuración php.ini
COPY ./php.ini /usr/local/etc/php/conf.d/

# Copiar el contenido de tu proyecto al contenedor
COPY . .

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto
EXPOSE 9000

CMD ["php-fpm"]
