# php:apache image for php application with index.php imported in www directory
FROM php:apache
COPY index.php /var/www/html/
RUN docker-php-ext-install mysqli
RUN apachectl restart
