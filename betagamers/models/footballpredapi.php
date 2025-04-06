<?php
class Footballpredapi {
    use db, validate;
    protected static $table = 'footballpredapi';
    protected $columns;
    
    public function __construct() {
        $this->columns = ['id', 'date', 'leagues', date('Y')];
    }
}