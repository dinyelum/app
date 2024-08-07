<?php
class Admins {
    use Db, Validate;
    private static $table = 'admins';
    private $columns = ['id', 'userid', 'level', 'active'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if($key=='id' || $key=='userid') {
                $data[$key] = $this->validate_id($fields[$key], $key);
            }
        }

        if(isset($fields['level'])) {
            $data['link'] = $this->validate_alphanumeric($fields['link'], false, 'level');
        }

        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], true, 'active');
        }
        return [$data, $this->err];
    }
}