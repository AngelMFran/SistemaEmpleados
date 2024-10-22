# Usar la imagen oficial de PHP con Apache
FROM php:8.0-apache

# Instalar dependencias necesarias para compilar Phalcon
RUN apt-get update && apt-get install -y \
    libpcre3-dev \
    gcc \
    make \
    re2c \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Phalcon desde el código fuente
RUN git clone --depth=1 https://github.com/phalcon/cphalcon.git \
    && cd cphalcon/build \
    && ./install

# Habilitar Phalcon en PHP
RUN echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini

# Copiar el código de la aplicación al contenedor
COPY . /var/www/html/

# Configurar Apache para que use el directorio de trabajo correcto
WORKDIR /var/www/html/

# Exponer el puerto 80 para que el contenedor esté accesible
EXPOSE 80
