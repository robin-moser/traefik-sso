FROM webdevops/php-nginx:7.4-alpine
LABEL maintainer="mail@robinmoser.de"

ENV WEB_ROOT="/app/src"

COPY src /app/src
COPY scripts/check-credentials.sh /entrypoint.d/check-credentials.sh
