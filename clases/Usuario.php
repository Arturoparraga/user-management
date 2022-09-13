<?php

use \PDO as PDO;

class Usuario {
    public $id;
    public $name;
    public $password;
    public $email;
    public $painter;
    
    
    public function __construct($id = null, $name = null, $password = null, $email = null, $painter = null) {
        if (!is_null($id)) {       
            $this->id = $id;              
        }
        if (!is_null($name)) {       
            $this->name = $name;
        }
        if (!is_null($password)) {
            $this->password = $password;
        }
        if (!is_null($email)) {
            $this->email = $email; 
        }
        if (!is_null($painter)) {
            $this->painter = $painter;
        }
    }
    
    public function setId($id) {
        $this->id=$id;
    }
    public function getId() {
        return $this->id;
    }
    public function setNombre($name) {
        $this->name=$name;
    }
    public function getNombre():string {
        return $this->name;
    }
    public function setContraseña($password) {
        $this->password=$password;
    }
    public function getContraseña() {
        return $this->password;
    }
    public function setEmail($email) {
        $this->email=$email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setPintor($painter) {
        $this->painter=$painter;
    }
    public function getPintor() {
        return $this->painter;
    }
    
    public static function recuperaUsuarioPorCredenciales(PDO $DataBase, $name, $password) {
        $DataBase->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM users WHERE name = :name AND password = :password";
        $statement = $DataBase->prepare($sql);
        $statement->execute([':name' => $name, ':password' => $password]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario=($statement->fetch()) ?: null;
        if($usuario) {
            $usuario->setPintor(Pintor::recuperaPintorPorId($DataBase, $usuario->painter_fk));
        }
        return $usuario;
        
    }

    
    public function persiste(PDO $DataBase) {
        if($this->id) {
            $sql = "UPDATE users SET name = :name, password = :password , email = :email , painter_fk = :painter_fk WHERE id = :id";
            $statement = $DataBase->prepare($sql);
            $result=$statement->execute([":name" => $this->name, ":password" => $this->password, ":email" => $this->email, ":painter_fk" => $this->painter, ":id" => $this->id]); 
        }else {
            $sql = "INSERT INTO users(name, password, email, painter_fk) VALUES (:name, :password, :email, :painter_fk)";
            $statement = $DataBase->prepare($sql);
            $result=$statement->execute([':name' => $this->name, ':password' => $this->password, ':email' => $this->email, ':painter_fk' => $this->painter]);
            if($result)$this->id = $DataBase->lastInsertId();
        }
        
        return $result;
    }
    
    public function borra($DataBase,$nombre) {
        $sql = 'DELETE FROM users WHERE name=:name';
        $statement = $DataBase->prepare($sql);
        $statement->execute([':name'=>$nombre]);
    }
    
}
