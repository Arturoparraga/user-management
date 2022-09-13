<?php
namespace DataBase;
use \PDO as PDO;

class DataBase {
    const host= 'localhost';
    const db= 'usermgmt';
    const user= 'root';
    const password='';
    protected static $bd = null;
    
    public function __construct() {
        try {
            self::$bd = new PDO("mysql:host=" . self::host . ";dbname=" . self::db, self::user, self::password);
            self::$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public static function getConexion() {
        if (!self::$bd) {
            new DataBase();
        }
        return self::$bd;
    }
}