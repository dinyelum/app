<?php
class User {
    use Db, Validate;
    private static $table = 'user';
    private $columns = ['id', 'firstname', 'lastname', 'email', 'phone', 'password', 'emailactive', 'phoneactive', 'hash'];

    public function validate(array $fields) {
        $data = [];
        $this->validate_columns($fields, $this->columns);
        if(isset($fields['id'])) {
            $data['id'] = $this->validate_id($fields['id']);
        }
        if(isset($fields['firstname'])) {
            $data['firstname'] = $this->validate_name($fields['firstname'], true, 'firstname');
        }
        if(isset($fields['lastname'])) {
            $data['lastname'] = $this->validate_name($fields['lastname'], true, 'lastname');
        }
        if(isset($fields['email'])) {
            if(isset($fields['submit']) && $fields['submit']=='Register') {
                $data['email'] = $this->validate_email($fields['email']);
            } else {
                $data['email'] = $this->validate_email($fields['email'], true, false);
            }
        }
        if(isset($fields['phone'])) {
            $data['phone'] = $this->validate_phone($fields['phone']);
        }
        if(isset($fields['password'])) {
            if(isset($fields['confirmpassword'])) {
                if($fields['password'] !== $fields['confirmpassword']) {
                    $this->err['confirmpassword'] = 'Passwords did not match';
                }
            }
            $data['password'] = $this->validate_password($fields['password'], 'sha1', 6);
        }
        if(isset($fields['emailactive'])) {
            $data['emailactive'] = $this->validate_toggle($fields['emailactive'], true, 'emailactive');
        }
        if(isset($fields['phoneactive'])) {
            $data['phoneactive'] = $this->validate_toggle($fields['phoneactive'], true, 'phoneactive');
        }
        if(isset($fields['hash'])) {
            $data['hash'] = $this->validate_alphanumeric($fields['hash'], true, 'hash');
            if(!$this->err) {
                if(
                    isset($fields['submit']) && $fields['submit']=='Reset' &&
                    isset($data['email']) && trim($data['email']) != ''
                    ) {
                    $resp = $this->exists(['email'=>$data['email'], 'hash'=>$data['hash']], 'and');
                    if($resp !== true) {
                        $this->err['hash'] = 'Incorrect details';
                    }
                }
            }
        }
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