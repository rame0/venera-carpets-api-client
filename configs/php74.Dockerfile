FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /
ENV PHP_IDE_CONFIG Docker

RUN apt-get update && apt-get install -y zip wget git curl zlib1g-dev libpng-dev apt-transport-https \
    && apt-get install -y libfreetype6-dev \
    && apt-get install -y libjpeg62-turbo-dev \
    && apt-get install -y libpng-dev \
    && pecl install xdebug-3.0.2 mongodb\
    && docker-php-ext-enable xdebug mongodb \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-enable pdo \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-install -j$(nproc) json \
    && docker-php-ext-enable json \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apt-get install -y libicu-dev \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-enable intl \
    && apt-get install -y libxml2-dev \
    && CFLAGS="-I/usr/src/php" docker-php-ext-install xmlreader xmlwriter \
    && docker-php-ext-enable xmlwriter xmlreader \
    && a2enmod ssl rewrite


# install the xhprof extension to profile requests
RUN git clone "https://github.com/tideways/php-xhprof-extension.git" ./php-xhprof-extension
RUN cd ./php-xhprof-extension \
    && phpize \
    && ./configure \
    && make \
    && make install
RUN rm -rf ./php-xhprof-extension
RUN docker-php-ext-enable tideways_xhprof


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

WORKDIR /var/www/k-tex

EXPOSE 80
RUN echo "ServerName ${PHP_IDE_CONFIG}" >> /etc/apache2/apache2.conf \
    && sed -ri 's/^www-data:x:33:33:/www-data:x:1000:1000:/' /etc/passwd \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

USER "${USER_ID}:${GROUP_ID}"
#USER www-data
