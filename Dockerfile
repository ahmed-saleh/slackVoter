FROM php:8-fpm

LABEL maintainer="Ahmed Saleh <a.s.alsalali@gmail.com>"

WORKDIR /var/www/app/

##########################
# Core Installation
##########################
RUN apt-get update && apt install -y libonig-dev git

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && php -r "unlink('composer-setup.php');"

#TODO: run the application as non root

RUN docker-php-ext-install pdo_mysql

COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
