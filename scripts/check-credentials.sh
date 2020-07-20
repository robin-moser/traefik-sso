#!/bin/sh

if [ ! -f "$WEB_ROOT"/credentials.yml ]; then

    echo "FATAL: Credentials File 'credentials.yml' not found!"
    echo "Please create a credentials File and mount it into $WEB_ROOT for the application to work."
    echo "Exiting..."

    exit 1

fi
