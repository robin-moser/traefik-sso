<?php 

/**
 * Custom Secret Class
 *
 * Manages the Secret to generate hashes for the cookies and define delimimters
 * @author Robin Moser <mail@robinmoser.de>
 */

class Secret {

    # the storage of the sso secret
    protected static $file = '/tmp/sso_secret';

    /**
     * returns the secret and creates one, if it doesn't exist yet
     *
     * @return string
     */
    public static function get() {

        if(!file_exists(self::$file)) {
            self::change();
        }
        return file_get_contents(self::$file);
    }

    /**
     * returns a substring of the secret
     *
     * @param int $charcount  number of characters to return from the secret
     * @return string
     */
    public static function gettiny( int $charcount = 6 ) {

        return substr(self::get(), 0, $charcount);

    }

    /**
     * generates a new secret and stores it in the permanent storage
     *
     * @return int|bool
     */
    public static function change() {

        $secret = md5(microtime().rand());
        return file_put_contents(self::$file, $secret);

    }
}

