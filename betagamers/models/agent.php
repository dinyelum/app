<?php
class Agent {
    use Db, Validate;
    private static $table = 'agent';
    private $columns = ['id', 'name', 'email', 'phone', 'network', 'intl', 'country', 'countries', 'currency', 'level'];
    public $levels = ['agent', 'misc', 'thief'];

    public function validate(array $fields) {
        $data = [];
        if(isset($fields['name'])) {
            $data['name'] = $this->validate_name($fields['name']);
        }
        
        if(isset($fields['email'])) {
            $data['email'] = $this->validate_email($fields['email'], unique:false);
        }
        
        if(isset($fields['phone'])) {
            if(in_array('phone', $this->insertunique)) {
                // echo 'yes';
                $data['phone'] = $this->validate_unique_text('validate_phone', ['phone'=>$fields['phone'], 'intformat'=>false], 'phone');
            } else {
                $data['phone'] = $this->validate_phone($fields['phone'], true, false);
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
            if(isset($this->err['countries']) && count($countryarr)>1) $this->err['countries'] = $this->resp_invalid_selections('countries');
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