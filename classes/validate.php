<?php
trait Validate {
    public $err;
    public $submitmode = 'notunique';
    public $fileformats = [
        'image'=>['jpg', 'jpeg', 'pdf', 'png', 'webp'],
        'audio'=>['mp3'],
        'video'=>['mp4'],
        'document'=>['doc', 'docx', 'pdf', 'rtf', 'txt', 'csv', 'xlsx'],
        'mixed'=>[],
    ];
    // public $exception_keys = ['submit', 'confirmpassword']; //unset unnecessary columns instead
    //[image, audio]
    public function mix_file_formats(array $formats) {
        $this->fileformats['mixed'] = [];
        foreach($formats as $val) {
            foreach($this->fileformats[$val] as $subval) {
                $this->fileformats['mixed'][] = $subval;
            }
        }
    }

    public function get_submitmode($value) {
        $createsynonyms = ['add', 'create', 'register', 'signup'];
        $loginsynonyms = ['login', 'signin'];
        if(in_array(strtolower($value), $createsynonyms)) {
            $this->submitmode = 'insertunique';
        } elseif($value=='update') {
            $this->submitmode = 'updateunique';
        } else {}
    }

    public function validate_id($id, $key='id', $required=true) {
        if($required===false && trim($id)=='') {
            return $id;
        }
        $checkint = filter_var($id, FILTER_VALIDATE_INT);
        if(!is_int($checkint)) {
            $this->err = [$key=>'Invalid '.$key];
            return $id;
        }
        return $id;
    }

    public function validate_name($name, $required=true, $fieldname='name') {
        $name = purify($name);
        if($required === true && $name == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $name;
        }
        if(!preg_match("/^\pL+(?>[-']?[\pL ])*$/ui", $name)) {
            $this->err[$fieldname] = "$fieldname contains invalid characters.";
            return $name;
        }
        return $name;
    }

    public function validate_itemname($name, $required=true, $fieldname='name') {
        $name = purify($name);
        if($required === true && $name == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $name;
        }
        if(!preg_match("/^[\pL\d]+(?>(['-]?[\pL\d])?( &)?( \()?[,.]? {0,1}[\pL\d)])*$/ui", $name)) {
            $this->err[$fieldname] = "$fieldname contains invalid characters.";
            return $name;
        }
        return $name;
    }

    public function validate_alphanumeric($text, $required=true, $fieldname='name', $unique=false) {
        $text = purify($text);
        if($required === true && $text == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $text;
        }
        if(!preg_match("/^[\pL\d]*$/ui", $text)) {
            $this->err[$fieldname] = "$fieldname contains invalid characters.";
            return $text;
        }
        if($unique == true) {
            $checkrec = $this->exists([$fieldname=>$text]);
            if($checkrec === true) {
                $this->err[$fieldname] = 'This order name already exists';
                return $text;
            }
        }
        return $text;
    }

    public function validate_text($text, $required=true, $fieldname='name', $min=0, $max=INF) {
        $puretext = purify($text);
        if($required === true && $text == '') {
            $this->err[$fieldname] = "This field cannot be empty";
            return $puretext;
        }

        if($required === false && $puretext == '') {
            return $puretext;
        }
        /*
        ^[\pL\d]+(?>['-.,&(]?[\pL\d.) ])*$
        ? 0-1
        () group, eg: ( &) matches exactly ' &'
        */
        if(!preg_match("/^[\pL\d]+(?>(['-]?[\pL\d])?( &)?( \()?[,.]? {0,1}[\pL\d.)])*$/ui", $text)) {
            $this->err[$fieldname] = "This field contains invalid characters.";
            return $puretext;
        }
        $textlen = $this->validate_length($text, $min, $max);
        if($textlen === false) {
            $this->err[$fieldname] = "$fieldname ".$this->err['length'];
            return $puretext;
        }
        return $puretext;
    }

    public function validate_unique_text($validatetype, $params, $fieldname, $id=null) {
        $value = call_user_func_array([$this, $validatetype], $params);
        if($value !== false) {
            $checkitem = $this->exists(!$id ? [$fieldname=>$value] : [$fieldname=>$value, 'id'=>$id], 'and not');
            if($checkitem === true) {
                $this->err[$fieldname] = "This $fieldname already exists";
            }
        }
        return $value;
    }

    public function validate_phone($phone, $required=true, $intformat=true, $fieldname='phone') {
        $phone = purify($phone);
        if($required === true && $phone == '') {
            $this->err[$fieldname] = 'Phone cannot be empty';
            return $phone;
        }
        $match = $intformat===true ? "/^\+[\d]*$/ui" : "/^[\d]*$/ui";
        if(!preg_match($match, $phone)) {
            $this->err[$fieldname] = 'Invalid phone number format';
            return $phone;
        }
        return $phone;
    }

    public function validate_file(array $file, array $blueprint, $required=false, $fieldname='file') {
        if($required === true && trim($file['name']) == '' && trim($file['type'])=='') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return;
        }
        //$blueprint[size, filetype, url];
        $filetype = $blueprint['filetype'];
        $fileext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if($file['size'] > $blueprint['size']) {
            $this->err[$fieldname] = "$filetype size must not be more than ".($blueprint['size']/1000000).'mb';
            return;
        }
        if(!in_array($fileext, $this->fileformats[$filetype]) && trim($file['name']) != '') {
            $this->err[$fieldname] = 'Only '.implode(', ', $this->fileformats[$filetype]).' are allowed';
            return;
        }
        if(file_exists($blueprint['url'])) {
            $this->err[$fieldname] = 'File already exists';
        }
        $this->validate_filename($file['name'], $required, $fieldname);
        if(!isset($this->err[$fieldname])) {
            move_uploaded_file($file['tmp_name'], $blueprint['url']);
            return true;
        }
    }

    public function validate_date($date, $required=true, $fieldname='date') {
        $date = purify($date);
        if($required === true) {
            if(false === strtotime($date)) {
                $this->err[$fieldname] = 'Invalid Date Format';
                return $date;
            }
            list($year, $month, $day) = explode('-', $date);
            if(checkdate($month, $day, $year) === true) {
                return $date;
            } else {
                $this->err[$fieldname] = 'Invalid Date Format';
                return $date;
            }
        } else {
            if($date == '') {
                return $date;
            } else {
                $this->err[$fieldname] = 'Invalid Date Format';
                return $date;
            }
        }
    }

    public function validate_filename($filename, $required=true, $fieldname='filename') {
        $filename = purify($filename);
        if($required === true && $filename == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $filename;
        }
        if(preg_match("/^[\/:*\"<>|]+$/ui", $filename)) {
            $this->err[$fieldname] = "$fieldname contains invalid characters.";
            return $filename;
        }
        return $filename;
    }

    public function validate_toggle($value, $required=true, $fieldname='logic') {
        $value = purify($value);
        if($required === true && $value == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $value;
        }
        $toggle = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if($toggle === null) {
            $this->err[$fieldname] = "$fieldname contains invalid characters.";
            return $value;
        }
        return $value;
    }

    public function validate_email($email, $required=true, $unique=true, $fieldname='email') {
        $email = purify($email);
        if($required === true && $email == '') {
            $this->err[$fieldname] = 'Email cannot be empty';
            return $email;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->err[$fieldname] = 'Invalid Email';
            return $email;
        }
        if($unique == true) {
            $checkemail = $this->exists([$fieldname=>$email]);
            if($checkemail === true) {
                $this->err[$fieldname] = 'This email already exists';
                return $email;
            }
        }
        return $email;
    }

    public function validate_currency(){}

    public function validate_number($number, $required=true, $fieldname='number') {
        $number = purify($number);
        if($required === true && $number == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $number;
        }
        if(!is_numeric($number)) {
            $this->err[$fieldname] = "Invalid $fieldname";
            return $number;
        }
        return $number;
    }

    public function validate_password($password, $enctype, $length, $required=true) {
        if($required === true && trim($password) == '') {
            $this->err['password'] = "Password cannot be empty";
            return $password;
        }
        $passwordlen = $this->validate_length($password, $length);
        if($passwordlen === false) {
            $this->err['password'] = 'Password '.$this->err['length'];
            return $password;
        }
        return $enctype($password);
    }

    public function validate_length($data, $min=0, $max=INF) {
        if(!is_numeric($min) || !is_numeric($max)) {
            $this->err['length'] = "length could not be verified. Please contact admin about this.";
            return false;
        }
        if(strlen($data) > $max) {
            $this->err['length'] = "cannot be more than $max";
            return false;
        }
        if(strlen($data) < $min) {
            $this->err['length'] = "cannot be less than $min";
            return false;
        }
        return $data;
    }

    public function validate_link($link, $required=false, $fieldname='link', $valtype=null) {
        // $link = purify($link);
        // FILTER_FLAG_SCHEME_REQUIRED
        // FILTER_FLAG_HOST_REQUIRED
        // FILTER_FLAG_PATH_REQUIRED
        // FILTER_FLAG_QUERY_REQUIRED

        if($required === true && trim($link) == '') {
            $this->err[$fieldname] = "$fieldname cannot be empty";
            return $link;
        }

        if($required === false && trim($link) == '') {
            return $link;
        }

        if(filter_var($link, FILTER_VALIDATE_URL, $valtype)) {
            return $link;
        } else {
            $this->err[$fieldname] = "Invalid $fieldname";
        }
        return purify($link);
    }

    public function validate_columns(array $columns, $allowed_columnns=null, $table=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $tablecolumns = $allowed_columnns ?? $tableclass->fetchcolumns();
        if(!is_array($tablecolumns) || !count($tablecolumns)) {
            $this->err['gen'] = 'An unexpected error occurred';
            return $columns;
        }
        if(array_is_list($columns)) {
            foreach($columns as $val) {
                if(!in_array($val, $tablecolumns)) {
                    echo $val;
                    $this->err['gen'] = 'An unknown error occurred';
                    return false;
                }
            }
        } else {
            foreach($columns as $key=>$val) {
                if(!in_array($key, $tablecolumns) ) {
                    unset ($columns[$key]);
                    // echo $val;
                    //$this->err['gen'] = 'An unknown error occurred'; //to test errors, return columns to know which ones are good and the one that isn't
                    //return false;
                }
            }
        }
        return $columns;
    }

    public function exists(array $cols, $joiner='or', $table=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $whquery = '';
        foreach($cols as $key=>$val) {
            $whquery .= "$key = :$key $joiner ";
        }
        $whquery = trimwords($whquery, $joiner, 'last');
        $data = $tableclass->select()->where($whquery, $cols);
        if(is_array($data) && count($data)) {
            return true;
        }
        return false;
    }
}