<?php

class Database
{
    protected function connect() {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
            $db = new PDO("mysql:host=$servername;dbname=hollenbe_vesuvio", $username, $password);
            return $db;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}