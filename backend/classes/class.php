<?php

class Atleta {
    public $ID;
    public $name;
    public $age;
    public $birth;
    public $sport;
    public $paid;

    public function __construct($id, $name, $birth, $sport, $paid = false) {
        $this->ID = $id;
        $this->name = $name;
        $this->birth = $birth;
        $this->sport = $sport;
        $this->paid = $paid;

        $this->age = $this->getAge();
    }

    public function getAge() {
        $birthDate = new DateTime($this->birth);
        $today = new DateTime();

        return $today->diff($birthDate)->y;
    }
}

class AtletaVolei extends Atleta {
    public $position;

    public function __construct($id, $name, $birth, $sport, $position, $paid = false) {
        parent::__construct($id, $name, $birth, $sport, $paid);

        $this->position = $position;
    }
}