<?php
class Acctdetails {
    use Db, Validate;
    private static $table = 'acctdetails';
    private $columns = ['id', 'acctname', 'acctnumber', 'bank'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        if(isset($fields['acctname'])) {
            $data['acctname'] = $this->validate_itemname($fields['acctname'], true, 'acctname');
        }
        if(isset($fields['acctnumber'])) {
            $data['acctnumber'] = $this->validate_number($fields['acctnumber'], true, 'acctnumber');
        }
        //totalamount
        if(isset($fields['bank'])) {
            $data['bank'] = $this->validate_itemname($fields['bank'], true, 'bank');
        }
        return [$data, $this->err];
    }
}