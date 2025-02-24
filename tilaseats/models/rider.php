<?php
class Rider {
    use Db, Validate;
    private static $table = 'rider';
    private $columns = ['id'];

    public function validate(array $fields) {
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        return [$data, $this->err];
    }
}