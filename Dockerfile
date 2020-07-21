FROM webdevops/php-nginx:7.4-alpine
LABEL maintainer="mail@robinmoser.de"

COPY src /app
COPY scripts/check-credentials.sh /entrypoint.d/check-credentials.sh
