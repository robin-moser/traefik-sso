<?php 

class Secret {

    protected static $file = '../secret';

    public static function get() {

        if(!file_exists(self::$file)) {
            self::change();
        }
        return file_get_contents(self::$file);
    }

    public static function gettiny( int $c = 6 ) {

        return substr(self::get(), 0, $c);

    }
    
    public static function change() {

        $secret = md5(microtime().rand());
        return file_put_contents(self::$file, $secret);

    }
}

