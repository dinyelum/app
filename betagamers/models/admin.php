<?php
class Admin {
    use Db, Validate;
    private static $table = 'agent';
    private $columns = ['id', 'name', 'email', 'phone', 'network', 'intl', 'country', 'countries', 'currency', 'level'];
}