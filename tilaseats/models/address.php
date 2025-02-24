<?php
class Address {
    use Db, Validate;
    private static $table = 'address';
    private $columns = ['id', 'address', 'clientid', 'locationid'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        foreach ($fields as $key => $val) {
            if($key=='id'|| $key=='clientid' || $key=='locationid') {
                $data[$key] = $this->validate_id($fields[$key], $key);
            }
        }
        if(isset($fields['address'])) {
            $data['address'] = $this->validate_text($fields['address'], true, 'address');
        }
        if(!isset($this->err)) {
            if(isset($fields['submit']) && $fields['submit']=='Add Address') {
                $check = $this->exists([
                    'address'=>$data['address'], 
                    'clientid'=>$data['clientid'],
                    'locationid'=>$data['locationid']], 'and');
                    if($check) {
                        $this->err['address'] = 'This address already exists on this account.';
                    }
            }
        }
        return [$data, $this->err];
    }
}