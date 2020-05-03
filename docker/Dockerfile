FROM php:7.4-apache

MAINTAINER Simon Berton <simonberton@gmail.com>

RUN apt-get update
RUN apt-get install -y vim git libzip-dev zlib1g-dev zip unzip


# Install php extensions
RUN docker-php-ext-install -j$(nproc) opcache
RUN docker-php-ext-install pdo pdo_mysql zip
COPY php.ini /usr/local/etc/php/conf.d/app.ini
# Install pdo_pgsql
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql


# Install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_host=127.0.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.profiler_enable_trigger=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.max_nesting_level = 256" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Bashrc
RUN rm /root/.bashrc
COPY .bashrc /root/.bashrc

# Cleaning
RUN rm -rf /etc/apache2/sites-available/* && rm -rf /etc/apache2/sites-enabled/*
RUN service apache2 restart
RUN rm -rf /var/www/*

# Conf Apache2
RUN a2enmod rewrite
RUN mkdir /var/www/app
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY backend.conf /etc/apache2/sites-available/backend.conf
RUN usermod -u 1000 www-data
RUN a2ensite backend.conf
RUN service apache2 restart

WORKDIR /var/www/app

# EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
