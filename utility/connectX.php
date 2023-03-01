<?php

namespace Saladin;

use Medoo\Medoo;
use PDO;

class ConnectX
{
    public static function setup($dbSet, $database=null)
    {
        if($database == null){
            $database = $dbSet->databasename;
        }
        return new Medoo([
            'type' => 'mysql',
            'host' => $dbSet->hostname,
            'database' => $database,
            'username' => $dbSet->username,
            'password' => $dbSet->password,
            'option' =>  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"),
        ]);
    }
}
