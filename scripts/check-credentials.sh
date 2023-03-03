#!/command/with-contenv sh

if [ ! -f "$NGINX_WEB_ROOT"/config/credentials.php ]; then


    echo "FATAL: Credentials File 'credentials.php' not found!"
    echo "Please create a credentials file inside the config directory and mount the directory into $WEB_DOCUMENT_ROOT/config for the application to work."
    echo "Exiting..."

    exit 1

fi
