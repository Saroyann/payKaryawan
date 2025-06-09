<?php
class Config {
    public static $db_host = 'localhost';
    public static $db_user = 'root';
    public static $db_pass = '';
    public static $db_name = 'dataKaryawan';

    public static function connect() {
        $conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
        if ($conn->connect_error) {
            die('Database connection failed: ' . $conn->connect_error);
        }
        return $conn;
    }
}