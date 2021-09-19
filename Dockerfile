FROM php:8-fpm

LABEL maintainer="Ahmed Saleh <a.s.alsalali@gmail.com>"

WORKDIR /var/www/app/

##########################
# Core Installation
##########################
RUN apt-get update && apt install -y libonig-dev git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && php -r "unlink('composer-setup.php');"

#TODO: run the application as non root

RUN docker-php-ext-install pdo_mysql

COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
