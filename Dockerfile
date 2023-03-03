FROM robinmoser/nginx-php:latest
LABEL maintainer="mail@robinmoser.de"

ENV NGINX_WEB_ROOT=/app

COPY src/ /app/
COPY scripts/check-credentials.sh /etc/cont-init.d/check-credentials
