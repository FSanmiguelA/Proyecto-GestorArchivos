<?php

class coneccionDos
{

    public static $host = "localhost";
    public static $user = "root";
    public static $pass = "";
    public static $db = "user_iceberg";
    public static $con;

    public static function conectarBdDos()
    {

        $con = mysqli_connect(self::$host, self::$user, self::$pass, self::$db);
        if ($con) {
            return $con;
        } else {
            return false;
        }
    }
}
