# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpcre3-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql gd zip

# Instala PECL y las herramientas necesarias
RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && pecl install psr \
    && pecl install phalcon-5.2.1 \
    && docker-php-ext-enable psr phalcon

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación al contenedor
COPY . /var/www/html/

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configuración para la conexión con MySQL
ENV DB_HOST=crudbddv2.mysql.database.azure.com
ENV DB_PORT=3306
ENV DB_USERNAME=alswalker
ENV DB_PASSWORD=@dministrad0r
ENV DB_NAME=nombre_de_tu_base_de_datos

# Expone el puerto 80 para la aplicación
EXPOSE 80

# Inicia Apache cuando se inicie el contenedor
CMD ["apache2-foreground"]
