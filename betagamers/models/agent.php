<?php
class Agent {
    use Db, Validate;
    private static $table = 'agent';
    private $columns = ['id', 'userid', 'name', 'email', 'phone', 'network', 'intl', 'country', 'countries', 'currency', 'level'];
    public $levels = ['agent', 'misc', 'thief'];

    public function validate(array $fields) {
        $data = [];
        if(isset($fields['userid'])) {
            $required = in_array('userid', $this->required);
            $data['userid'] = $this->validate_id($fields['userid'], 'userid', $required);
        }
        
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_name($fields['name']);
        }
        
        if(isset($fields['email'])) {
            $data['email'] = $this->validate_email($fields['email'], unique:false);
        }
        
        if(isset($fields['phone'])) {
            $required = in_array('phone', $this->required);
            if(in_array('phone', $this->insertunique)) {
                // echo 'yes';
                $data['phone'] = $this->validate_unique_text('validate_phone', ['phone'=>$fields['phone'], 'required'=>$required, 'intformat'=>false], 'phone');
            } else {
                $data['phone'] = $this->validate_phone($fields['phone'], $required);
            }
        }
        
        if(isset($fields['intl'])) {
            $data['intl'] = $this->validate_phone($fields['intl'], fieldname:'intl');
        }
        
        if(isset($fields['network'])) {
            $data['network'] = $this->validate_alphanumeric($fields['network'], false, fieldname:'network');
        }
        
        if(isset($fields['country'])) {
            $data['country'] = $this->validate_country($fields['country']);
        }
        
        if(isset($fields['countries'])) {
            $countryarr = explode(', ', $fields['countries']);
            foreach($countryarr as $val) {
                $countries[] = $this->validate_country($val, false, fieldname:'countries');
            }
            if(isset($this->err['countries']) && count($countryarr)) $this->err['countries'] = $this->resp_invalid_selections('countries');
            $data['countries'] = implode(', ', $countries);
        }

        if(isset($fields['currency'])) {
            $data['currency'] = $this->validate_bg_currencies($fields['currency'], true);
        }
        
        if(isset($fields['level'])) {
            if(!in_array($fields['level'], $this->levels)) {
                $this->err['level'] = 'Agent Level can only be '.implode(', ', $this->levels);
            }
            $data['level'] = purify($fields['level']);
        }
        
        return [$data, $this->err];
    }
}