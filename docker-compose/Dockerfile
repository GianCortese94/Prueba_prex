FROM php:8.3-fpm

# Shell setup
SHELL [ "/bin/bash", "-l", "-c" ]

# Configurar todo como root
USER root

# Argumentos con valores predeterminados
ARG USER_ID
ARG GROUP_ID
ARG WORK_DIR

# Variables de entorno
ENV TZ=America/Argentina/Misiones

# Asegurarse de que www-data tenga los UID y GID correctos
RUN userdel -f www-data
RUN if getent group www-data ; then groupdel www-data; fi
RUN groupadd -g ${GROUP_ID} www-data
RUN useradd -l -u ${USER_ID} -g www-data www-data
RUN chown -R www-data:www-data /var/www

RUN install -d -m 0755 -o www-data -g www-data /home/www-data
RUN chown -R www-data:www-data /home/www-data

# Actualizar e instalar todas las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev locales zip jpegoptim optipng pngquant gifsicle \
    vim curl libxml2-dev nano cron pkg-config git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip exif pcntl soap calendar \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

RUN export EDITOR="/usr/bin/nano"

# Configurar la zona horaria
RUN ln -sf /usr/share/zoneinfo/${TZ} /etc/localtime

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# Instalar la versión estable de Node.js
RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs
RUN npm update -g
RUN npm install -g vite

# Configuración de PHP (incluyendo Xdebug si es necesario)
# COPY xdebug.ini /usr/local/etc/php/conf.d/50_xdebug.ini
COPY php.ini /usr/local/etc/php/php.ini

# Instalar Node.js & npm
COPY --from=node:latest /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:latest /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Configurar alias para un entorno Ubuntu
RUN echo "alias ll='ls -alF'" >> /etc/bash.bashrc

# Crear el directorio de trabajo y establecer permisos
RUN mkdir -p ${WORK_DIR}
RUN chown -R www-data:www-data ${WORK_DIR}

# Establecer directorio de trabajo
WORKDIR ${WORK_DIR}

# Volver a www-data para ejecutar php-fpm
USER www-data

CMD ["php-fpm"]