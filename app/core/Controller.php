<?php 

class Controller{

    protected $db = null;
    protected $table;

    public function __construct() {
        $this->db = new Database();
    }

}