FROM php:7.1.20-apache


RUN apt-get update
RUN apt-get upgrade -y


# Install tools & libraries
RUN apt-get -y install apt-utils nano wget dialog \
    build-essential git curl libcurl3 libcurl3-dev zip ssmtp libpng-dev

RUN echo 'TLS_CA_FILE=/etc/pki/tls/certs/ca-bundle.crt' >> /etc/ssmtp/ssmtp.conf
RUN echo 'root=hypertubematcha@gmail.com' >> /etc/ssmtp/ssmtp.conf
RUN echo 'mailhub=smtp.gmail.com:587' >> /etc/ssmtp/ssmtp.conf
RUN echo 'AuthUser=hypertubematcha@gmail.com' >> /etc/ssmtp/ssmtp.conf
RUN echo 'AuthPass=Test1337@' >> /etc/ssmtp/ssmtp.conf
RUN echo 'UseSTARTTLS=Yes' >> /etc/ssmtp/ssmtp.conf
RUN echo 'UseTLS=Yes' >> /etc/ssmtp/ssmtp.conf
RUN echo 'hostname=AAAA' >> /etc/ssmtp/ssmtp.conf

RUN echo 'root:hypertubematcha@gmail.com:smtp.gmail.com:587' >> /etc/ssmtp/revaliases

RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/php.ini



RUN docker-php-ext-install pdo_mysql



RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir \
    --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir \
    --enable-gd-native-ttf

RUN docker-php-ext-install gd



#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
#RUN docker-php-ext-install gd


RUN apt-get -y install vim

RUN a2enmod rewrite


COPY /app/. /var/www/html/.



RUN chown -R www-data:www-data /var/www/html/.
