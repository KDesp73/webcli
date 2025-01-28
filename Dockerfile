FROM php:8.2-apache

COPY ./src/public /var/www/html
COPY ./src/php /var/www/html/php
COPY ./src/config.json /var/www/html/config.json

EXPOSE 80
