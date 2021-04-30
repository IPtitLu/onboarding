FROM phpdockerio/php72-fpm:latest

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update --fix-missing && apt-get install -y --no-install-recommends apt-utils

RUN apt-get install --reinstall --yes --force-yes -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" php7.2-fpm php7.2-cli

RUN apt-get -y install php7.2-imagick php7.2-gd php7.2-mysql php7.2-xdebug php7.2-mbstring php7.2-sqlite3 php7.2-intl --fix-missing

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

ADD files /

RUN cat /etc/php/7.2/php.ini.add >> /etc/php/7.2/cli/php.ini
RUN cat /etc/php/7.2/php.ini.add >> /etc/php/7.2/fpm/php.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN useradd --create-home --shell /bin/bash --user-group dev
RUN echo "export TERM=xterm" >> /home/dev/.bashrc

RUN chmod -R 777 /var/log

ENV DEBIAN_FRONTEND teletype