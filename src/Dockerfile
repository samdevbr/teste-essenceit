FROM prooph/composer:7.3

COPY . /app

WORKDIR /app

RUN cd /app && \
    composer install

EXPOSE 3000

ENTRYPOINT [ "php", "-S", "0.0.0.0:3000", "-t", "/app/Public"]