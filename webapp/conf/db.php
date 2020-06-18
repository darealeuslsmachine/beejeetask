<?php

/**
 * DB config
 */

class DB {

    const USER = "root";
    const PASS = "";
    const HOST = "localhost";
    const DBNAME = "webtasks";

    public static function connToDB() {
        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $dbname = self::DBNAME;

        $conn = new PDO("mysql:dbname=$dbname;host=$host;charset=UTF8", $user, $pass);
        return $conn;

    }
}