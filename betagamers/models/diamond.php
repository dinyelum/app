<?php
class Diamond {
    use db, validate;
    protected static $table = 'diamond';
    public $required = [];
    public $insertunique = [];
    public $strictmode = true;
    protected $columns = ['id', 'fullname', 'email', 'phone', 'currency', 'amount', 'regdate', 'expdate'];
    //ALTER TABLE `diamond` ADD UNIQUE(`filename`);

    public function validate(array $fields) {
        $data = [];
        //$this->get_submitmode($fields['submit'] ?? '');
        //$this->insertunique = $fields['dbunique'] ?? $this->insertunique;
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['fullname'])) {
            $data['fullname'] = $this->validate_name($fields['fullname'], required:false, fieldname:'fullname');
        }

        if(isset($fields['email'])) {
            $data['email'] = $this->validate_email(
                $fields['email'], 
                unique:(in_array('email', $this->insertunique) ? true : false), 
                required:(in_array('email', $this->required) ? true : false),
                strict:$this->strictmode
            );
        }
        /*
        if(isset($fields['email'])) {
            //strict or no strict
            if($this->insertunique=='email') {
                $data['email'] = $this->validate_email($fields['email'], required:(in_array('email', $this->required) ? true : false));
            } else {
                $data['email'] = $this->validate_email($fields['email'], unique:false, required:(in_array('email', $this->required) ? true : false));
            }
        }
        */
        if(isset($fields['phone'])) {
            $data['phone'] = str_replace(' ', '', $fields['phone']);
            $data['phone'] = $this->validate_phone($data['phone'], intformat:false, required:false);
        }

        if(isset($fields['currency'])) {
            $data['currency'] = $this->validate_alpha_iso(strtoupper($fields['currency']), required:(in_array('currency', $this->required) ? true : false), length:3, fieldname:'currency');
        }
        
        if(isset($fields['amount'])) {
            $data['amount'] = $this->validate_number($fields['amount'], required:(in_array('amount', $this->required) ? true : false), fieldname:'amount');
        }
        
        if(isset($fields['reg_date'])) {
            $data['reg_date'] = $this->validate_date($fields['reg_date'], false, 'reg_date');
        }
        
        if(isset($fields['expdate'])) {
            $data['expdate'] = $this->validate_date($fields['expdate'], required:(in_array('expdate', $this->required) ? true : false), fieldname:'expdate');
        }

        if(!implode($data)) $this->err = ['gen'=>'All these fields cannot be empty'];

        return [$data, $this->err];
    }
}