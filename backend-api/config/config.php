<?php
class Constants {
    public static $DB_HOST = '';
    public static $DB_NAME = '';
    public static $DB_USER = '';
    public static $DB_PASS = '';

    // Optionally, initialize from environment or defaults
    public static function init() {
        self::$DB_HOST = getenv('DB_HOST') ?: 'localhost';
        self::$DB_NAME = getenv('DB_NAME') ?: 'isaac';
        self::$DB_USER = getenv('DB_USER') ?: 'root';
        self::$DB_PASS = getenv('DB_PASS') ?: 'root';
    }
}

Constants::init();