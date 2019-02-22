FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y libcurl3-dev libxml2-dev wget \
    && docker-php-ext-install dom curl \
    && docker-php-ext-enable dom curl

COPY /docker/install-composer.sh /tmp/install-composer.sh
RUN chmod a+x /tmp/install-composer.sh
RUN /tmp/install-composer.sh
RUN rm /tmp/install-composer.sh