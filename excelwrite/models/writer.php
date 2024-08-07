<?php
class Writer {
    use Db, Validate;
    private static $table = 'writer';
    private $columns = ['id', 'userid', 'subject1', 'subject2', 'subject3', 'subject4', 'subject5', 'active'];

    public function validate(array $fields) {
        $data = [];
        unset($fields['submit']);
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if(in_array($key, $this->columns)) {
                $data[$key] = $this->validate_id($fields[$key], $key);
            }
        }

        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], true, 'active');
        }
        return [$data, $this->err];
    }
}