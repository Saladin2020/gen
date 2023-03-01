<?php

namespace Saladin;

use PDO;
use PDOException;

class Connection
{

    public static function connectAll($dbSet)
    {
        $conn = null;
        try {
            $conn = new PDO(
                "mysql:host={$dbSet->hostname};",
                $dbSet->username,
                $dbSet->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $conn = $e->getMessage();
        }
        return $conn;
    }
    public static function connect($dbSet, $database=null)
    {
        if($database == null){
            $database = $dbSet->databasename;
        }
        $conn = null;
        try {
            $conn = new PDO(
                "mysql:host={$dbSet->hostname};dbname={$database}",
                $dbSet->username,
                $dbSet->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $conn = $e->getMessage();
        }
        return $conn;
    }
}
