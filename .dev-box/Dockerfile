FROM php:7.3-alpine

# instalar psalm
RUN curl -sS -L https://github.com/vimeo/psalm/releases/latest/download/psalm.phar -o /usr/local/bin/psalm
RUN chmod a+rx /usr/local/bin/psalm

# instala phpunit
RUN curl -sS -L https://phar.phpunit.de/phpunit-9.5.phar -o /usr/local/bin/phpunit
RUN chmod a+rx /usr/local/bin/phpunit

# instalar php composer
RUN curl -k -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/ \
  && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

ENV HOME /app
WORKDIR /app
