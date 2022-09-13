<?php

use \PDO as PDO;

class Pintor {
    public $id;
    public $name;
    public $paintings;
    
    public function __construct($name=null, $id=null, $paintings=null) {
        if (!is_null($id)) {
            $this->id = $id;
        }
        if (!is_null($name)) {
            $this->name = $name;
        }
        if (!is_null($paintings)) {
            $this->paintings = $paintings;
        }
    }
    
    public function getNombre() {
        return $this->name;
    }
    public function getId() {
        return $this->id;
    }
    public function setNombre($name) {
        $this->name=$name;
    }
    public function setPaintings($paintings) {
        $this->paintings=$paintings;
    }
    public function getPaintings() {
        return $this->paintings;
    }
    
    
    public static function recuperaPintorPorId($DataBase, $id) {
        $DataBase->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "Select name, id FROM painters WHERE id = :id";
        $statement = $DataBase->prepare($sql);
        $statement->execute([':id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Pintor::class);
        $pintor = ($statement->fetch()) ?: null;
        $pintor->setNombre($pintor->name);
        if($pintor) {
            $pintor->setPaintings(Cuadro::recuperaCuadrosPorId($DataBase, $pintor->id));
        }
        return $pintor;
    }

    public static function recuperaPintores($DataBase) {
        $DataBase->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "Select * FROM painters";
        $statement = $DataBase->prepare($sql);
        $statement->execute();
        $pintores=$statement->fetchAll(PDO::FETCH_CLASS, Pintor::class);
        
        return $pintores;
    }

}
