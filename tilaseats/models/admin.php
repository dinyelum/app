<?php
class Admin {
    use Db, Validate;
    private static $table = 'admin';
    private $columns = ['id', 'clientid'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if($key=='id' || $key=='clientid') {
                $data[$key] = $this->validate_id($fields[$key], $key);
            }
        }
        return [$data, $this->err];
    }
}