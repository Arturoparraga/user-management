<?php

use \PDO as PDO;

class Cuadro {
    public $id;
    public $title;
    public $img;
    public $description;
    public $period;
    public $technique;
    public $year;
    
    
    public function __construct($id=null, $title=null, $img=null,$description=null, $period=null, $year =null,$technique=null) {
        if (!is_null($id)) {
            $this->id = $id;
        }
        if (!is_null($title)) {
            $this->title = $title;
        }
        if (!is_null($img)) {
            $this->img = $img;
        }
        if (!is_null($description)) {
            $this->description = $description;
        }
        if (!is_null($period)) {
            $this->period = $period;
        }
        if (!is_null($year)) {
            $this->year = $year;
        }
        if (!is_null($technique)) {
            $this->technique = $technique;
        }
    }
    
    public function getId() {
        return $this->id;
    }
    public function getTitulo() {
        return $this->title;
    }
    public function getImagen() {
        return $this->img;
    }
    public function getDescripcion() {
        return $this->description;
    }
    public function getEpoca() {
        return $this->period;
    }
    public function getAño() {
        return $this->year;
    }
    public function getTecnica() {
        return $this->technique;
    }
    
    public static function recuperaCuadrosPorId($DataBase, $id) {
        $DataBase->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "Select * FROM paintings WHERE painter_fk = :id";
        $statement = $DataBase->prepare($sql);
        $statement->execute([':id' => $id]);
        $cuadros=$statement->fetchAll(PDO::FETCH_CLASS, Cuadro::class);

        return $cuadros;
    }
}

