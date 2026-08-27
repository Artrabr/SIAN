<?php

include_once __DIR__ . "/athlete.php";

class AtletaVolei extends Atleta {
    public $position;

    public function __construct($ID, $name, $birth, $sport, $position) {
        parent::__construct($ID, $name, $birth, $sport);

        $this->position = $position;
    }
}