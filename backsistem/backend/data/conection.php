<?php

class conection{
    private static $pdo;

    public static function conectar()
    {
        if (!self::$pdo) {
            self::$pdo = new PDO(
                "mysql:host=localhost;dbname=sian;charset=utf8mb4",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$pdo;
    }
}