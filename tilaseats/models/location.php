<?php
class Location {
    use Db, Validate;
    private static $table = 'location';
    private $columns = ['id', 'name', 'homedelivery', 'deliverycharge'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_text($fields['name'], true, 'name');
        }
        if(isset($fields['homedelivery'])) {
            $data['homedelivery'] = $this->validate_toggle($fields['homedelivery'], true, 'homedelivery');
        }
        if(isset($fields['deliverycharge'])) {
            $data['deliverycharge'] = $this->validate_number($fields['deliverycharge'], true, 'deliverycharge');
        }
        if(isset($fields['submit'])) {
            if(!isset($this->err['name'])) {
                //where name=... and category=... and not id=...;
                $check = $this->exists(['name'=>$data['name']]);
                if($check) {
                    $this->err['name'] = 'This Location already exists.';
                }
            }
            show ([$data, $this->err]);
            return [$data, $this->err];
        }
    }
}