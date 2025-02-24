<?php
class Users {
    use Db, Validate;
    private static $table = 'users';
    // public $required = [];
    // public $insertunique = [];
    public $strictmode = true;
    private $columns = ['id', 'fullname', 'email', 'phone', 'fullphone', 'active', 'regotpcount', 'country', 'language', 'password', 'hash', 'reg_date'];
    // public $submitmode;

    public function validate(array $fields) {
        $data = [];
        //$this->get_submitmode($fields['submit'] ?? '');
        // $this->insertunique = $fields['insertunique'] ?? $this->insertunique;
        // $this->required = $fields['required'] ?? $this->required;
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }

        if(isset($fields['fullname'])) {
            $data['fullname'] = $this->validate_name($fields['fullname'], required:(in_array('fullname', $this->required) ? true : false), fieldname:'fullname');
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
            if($this->insertunique==true) {
                $data['email'] = $this->validate_email($fields['email']);
            } else {
                $data['email'] = $this->validate_email($fields['email'], unique:false);
            }
        }
            */
        if(isset($fields['country'])) {
            $data['country'] = $this->validate_alpha_iso($fields['country']);
        }
        if(isset($fields['phone'])) {
            $data['phone'] = str_replace(' ', '', $fields['phone']);
            $data['phone'] = $this->validate_phone($data['phone'], intformat:false, required:(in_array('phone', $this->required) ? true : false));
            // if(!$this->err['phone']) {
            //     if(str_starts_with($data['phone'], '+')) {
            //         $data['phone'] = ltrim($data['phone'], '+');
            //     }
            //     $data['phone'] = str_replace(' ', '', $data['phone']);
            // }
        }
        if(isset($fields['fullphone'])) {
            if(in_array('fullphone', $this->insertunique)) {
                $data['fullphone'] = $this->validate_unique_text('validate_phone', ['phone'=>$fields['fullphone'], 'fieldname'=>'fullphone'], 'fullphone');
            } else {
                $data['fullphone'] = $this->validate_phone($fields['fullphone'], fieldname:'fullphone');
            }
        }
        if(isset($fields['active'])) {
            $data['active'] = $this->validate_toggle($fields['active'], fieldname:'active');
        }
        if(isset($fields['regotpcount'])) {
            $data['regotpcount'] = $this->validate_id($fields['regotpcount'], 'regotpcount');
        }
        if(isset($fields['language'])) {
            $data['language'] = $this->validate_alpha_iso($fields['language'], length:2, fieldname:'language');
        }
        if(isset($fields['password'])) {
            $data['password'] = $this->validate_password($fields['password'], 'sha1', 6);
        }
        
        if(isset($fields['hash'])) {
            $data['hash'] = $this->validate_alphanumeric($fields['hash'], fieldname:'hash');
            if(!$this->err) {
                if(
                    $this->submitmode=='reset' &&
                    isset($data['email']) && trim($data['email']) != ''
                    ) {
                    $resp = $this->exists(['email'=>$data['email'], 'hash'=>$data['hash']], 'and');
                    if($resp !== true) {
                        $this->err['hash'] = 'Incorrect details';
                    }
                }
            }
        }
        
        if(isset($fields['reg_date'])) {
            $data['reg_date'] = $this->validate_date($fields['reg_date'], false, 'reg_date');
        }

        if(!implode($data)) $this->err = ['gen'=>'All these fields cannot be empty'];
        
        return [$data, $this->err];
    }
}


/*
if(isset($fields['id'])) {
    if(is_array($fields['id'])) {
        foreach ($fields['id'] as $ind=>$val) {
            $data['id'][$ind] = $this->validate_id($fields['id']);
        }
    } else {
        $data['id'] = $this->validate_id($fields['id']);
    }
}
*/