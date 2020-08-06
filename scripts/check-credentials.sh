#!/bin/sh

if [ ! -f "$WEB_DOCUMENT_ROOT"/credentials.php ]; then

    echo "FATAL: Credentials File 'credentials.php' not found!"
    echo "Please create a credentials File and mount it into $WEB_DOCUMENT_ROOT for the application to work."
    echo "Exiting..."

    exit 1

fi
