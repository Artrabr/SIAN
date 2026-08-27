<?php

class Atleta {
    public $ID;
    public $name;
    public $age;
    public $birthDate;
    public $sport;

    public function __construct($ID, $name, $birthDate, $sport) {
        $this->ID = $ID;
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->sport = $sport;

        $this->age = $this->getAge();
    }

    public function getAge() {
        if (empty($this->birthDate)) {
            return null;
        }

        try {
            $birthDate = new DateTime($this->birthDate);
            $today = new DateTime();
            return $today->diff($birthDate)->y;
        } catch (Exception $e) {
            return null;
        }
    }
}