<?php

class coneccion
{

    public static $host = "localhost";
    public static $user = "root";
    public static $pass = "1234";
    public static $db = "parcial";
    public static $port = "3307";
    public static $con;

    public static function conectarBd()
    {

        $con = mysqli_connect(self::$host, self::$user, self::$pass, self::$db,self::$port);
        if ($con) {
            return $con;
        } else {
            return false;
        }
    }
}
