# Usar la imagen oficial de PHP con Apache
FROM php:8.0-apache

# Instalar dependencias necesarias para compilar Phalcon
RUN apt-get update && apt-get install -y \
    libpcre3-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Phalcon
RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash \
    && apt-get install -y php8.0-phalcon

# Copiar el código de la aplicación al contenedor
COPY . /var/www/html/

# Configurar Apache para que use el directorio de trabajo correcto
WORKDIR /var/www/html/

# Exponer el puerto 80 para que el contenedor esté accesible
EXPOSE 80
