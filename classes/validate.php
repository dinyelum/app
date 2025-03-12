<?php
trait Validate {
    use Responses;
    public $err;
    public $submitmode = 'notunique';
    public $required = [];
    public $insertunique = [];
    ///public $insertunique = false; //insertunique=email=>unique email, insertunique=phone=>unique phone
    public $fileformats = [
        'image'=>['jpg', 'jpeg', 'pdf', 'png', 'webp'],
        'audio'=>['mp3'],
        'video'=>['mp4'],
        'document'=>['doc', 'docx', 'pdf', 'rtf', 'txt', 'csv', 'xlsx'],
        'html'=>['htm', 'html'],
        'compressed'=>['zip'],
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
            $this->err = [$key=>$this->resp_invalid($key)];
            return $id;
        }
        return $id;
    }

    public function validate_name($name, $required=true, $fieldname='name') {
        $name = purify($name);
        if($required === true && $name == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $name;
        }
        if($name) {
            if(!preg_match("/^\pL+(?>[-']?[\pL ])*$/ui", $name)) {
                $this->err[$fieldname] = $this->resp_invalid_name($fieldname);
                return $name;
            }
        }
        return $name;
    }

    public function validate_itemname($name, $required=true, $fieldname='name') {
        $name = purify($name);
        if($required === true && $name == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $name;
        }
        if(!preg_match("/^[\pL\d]+(?>(['-]?[\pL\d])?( &)?( \()?[,.]? {0,1}[\pL\d)])*$/ui", $name)) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $name;
        }
        return $name;
    }

    public function validate_alphanumeric($text, $required=true, $fieldname='name', $unique=false) {
        $text = purify($text);
        if($required === true && $text == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $text;
        }
        if(!preg_match("/^[\pL\d]*$/ui", $text)) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $text;
        }
        if($unique == true) {
            $checkrec = $this->exists([$fieldname=>$text]);
            if($checkrec === true) {
                $this->err[$fieldname] = $this->resp_already_exists($fieldname);
                return $text;
            }
        }
        return $text;
    }

    public function validate_text($text, $required=true, $fieldname='name', $min=0, $max=INF) {
        $puretext = purify($text);
        if($required === true && $puretext == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
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
        /*
        if(!preg_match("/^[\pL\d]+(?>(['-]?[\pL\d])?( &)?( \()?[,.:;]? {0,1}[\pL\d.)])*$/ui", $puretext)) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $puretext;
        }
        */
        $textlen = $this->validate_length($puretext, $min, $max);
        if($textlen === false) {
            $this->err[$fieldname] = $this->resp_invalid_length($fieldname);
            return $puretext;
        }
        // return format_word_htm($puretext);
        return $puretext;
    }

    public function validate_unique_text($validatetype, $params, $fieldname, $id=null) {
        // echo 'yes';
        $value = call_user_func_array([$this, $validatetype], $params);
        if($value !== false) {
            $checkitem = $this->exists(!$id ? [$fieldname=>$value] : [$fieldname=>$value, 'id'=>$id], 'and not');
            if($checkitem === true) {
                $this->err[$fieldname] = $this->resp_already_exists($fieldname);
            }
        }
        return $value;
    }

    public function validate_phone($phone, $required=true, $intformat=true, $fieldname='phone', $country=null) {
        $phone = purify($phone);
        if($required === true && $phone == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $phone;
        }
        if($required === false && $phone == '') {
            return $phone;
        }
        $match = $intformat===true ? "/^\+[\d]*$/ui" : "/^[\d]*$/ui";
        if(!preg_match($match, $phone)) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $phone;
        }
        if($intformat===true && $country) {
            if(!isset($_SESSION['phonewarning']) && ($_SERVER['HTTP_CF_IPCOUNTRY'] == $country)) {
    		    include_once '/home/betaahfg/public_html/folder/countrylist.php';
    		    if(array_key_exists($country, $country_list)) {
    		        $phone = str_starts_with($phone, '+') ? substr($phone, 1) : $phone;
    		        if(!str_starts_with($phone, $countrycode)) {
                        $this->err[$fieldname] = $this->resp_invalid_phone_instruction($fieldname);
                        /*
    		            $err['en']['phone'] = "Select your country's flag and type your phone number<br><br>";
    		            $err['fr']['phone'] = "Sélectionnez le drapeau de votre pays et saisissez votre numéro de téléphone<br><br>";
    		            $err['es']['phone'] = "Selecciona la bandera de tu país y escribe tu número de teléfono<br><br>";
    		            $err['pt']['phone'] = "Selecione a bandeira do seu país e digite seu número de telefone<br><br>";
    		            $err['de']['phone'] = "Wählen Sie die Flagge Ihres Landes aus und geben Sie Ihre Telefonnummer ein<br><br>";
                        */
    		            $_SESSION['phonewarning'] = true;
    		        }
    		    }
    		}
        }
        return $phone;
    }

    public function validate_file_old(array $file, array $blueprint, $required=false, $fieldname='file') {
        if($required === true && trim($file['name']) == '' && trim($file['type'])=='') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return;
        }
        //$blueprint[size, filetype, url];
        $filetype = $blueprint['filetype'];
        $fileext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if($file['size'] > $blueprint['size']) {
            $this->err[$fieldname] = $this->resp_invalid_size($filetype, ($blueprint['size']/1000000).'mb');
            return;
        }
        if(!in_array($fileext, $this->fileformats[$filetype]) && trim($file['name']) != '') {
            $this->err[$fieldname] = $this->resp_invalid_more_info($fieldname, $this->fileformats[$filetype]);
            return;
        }
        // if(implode($file['error'])) {}
        if(file_exists($blueprint['url'])) {
            $this->err[$fieldname] = $this->resp_already_exists($fieldname);
            return $file['name'];
        }
        $this->validate_filename($file['name'], $required, $fieldname);
        if(!isset($this->err[$fieldname])) {
            move_uploaded_file($file['tmp_name'], $blueprint['url']);
            return true;
        }
    }

    public function validate_file(array $file, array $blueprint, $required=false, $fieldname='file') {
        if($required === true && trim($file['name']) == '' && trim($file['type'])=='') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return;
        }
        $this->validate_filename($file['name'], $required, $fieldname);
        //$blueprint[size, filetype, url, overwrite];
        $filetype = $blueprint['filetype'];
        $fileext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if($file['size'] > $blueprint['size']) {
            $this->err[$fieldname] = $this->resp_invalid_size($filetype, ($blueprint['size']/1000000).'mb');
            return;
        }
        if(!in_array($fileext, $this->fileformats[$filetype]) && trim($file['name']) != '') {
            $this->err[$fieldname] = $this->resp_invalid_more_info($fieldname, $this->fileformats[$filetype]);
            return;
        }
        // if(implode($file['error'])) {}
        if(!isset($blueprint['overwrite']) || $blueprint['overwrite']==false) {
            if(file_exists($blueprint['url'])) {
                $this->err[$fieldname] = $this->resp_already_exists($fieldname);
                return $file['name'];
            }
        }
        if(!isset($this->err[$fieldname])) {
            move_uploaded_file($file['tmp_name'], $blueprint['url']);
            return true;
        }
    }

    public function validate_date($date, $required=true, $fieldname='date') {
        $date = purify($date);
        if(!$required && trim($date=='')) {
            return $date;
        }
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
    }

    public function validate_year_month($date, $required=true, $fieldname='date') {
        $date = purify($date);
        if(!$required && trim($date=='')) {
            return $date;
        }
        list($year, $month) = explode('-', $date);
        if(!is_numeric($year) || !in_array($month, range(1,12))) {
            $this->err[$fieldname] = 'Invalid Month Selection';
            return $date;
        }
        return $date;
    }

    public function validate_filename($filename, $required=true, $fieldname='filename') {
        $filename = purify($filename);
        if($required === true && $filename == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $filename;
        }
        if(preg_match("/^[\/:*\"<>|]+$/ui", $filename)) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $filename;
        }
        return $filename;
    }

    public function validate_toggle($value, $required=true, $fieldname='logic') {
        $value = purify($value);
        if($required === true && $value == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $value;
        }
        $toggle = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if($toggle === null) {
            $this->err[$fieldname] = $this->resp_invalid_polite($fieldname);
            return $value;
        }
        return $value;
    }

    public function validate_email($email, $required=true, $unique=true, $fieldname='email', $strict=true) {
        $email = purify($email);
        if($required === true && $email == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $email;
        }
        if($email) {
            $valid = $strict ? filter_var($email, FILTER_VALIDATE_EMAIL) : (preg_match('/\w+$/ui', $email) || filter_var($email, FILTER_VALIDATE_EMAIL));
            if(!$valid) {
                $this->err[$fieldname] = $this->resp_invalid($fieldname);
                return $email;
            }
            if($unique == true) {
                $checkemail = $this->exists([$fieldname=>$email]);
                if($checkemail === true) {
                    $this->err[$fieldname] = $this->resp_already_exists($fieldname);
                    return $email;
                }
            }
        }
        return $email;
    }

    public function validate_alpha_iso($value, $required=true, $length=2, $fieldname='iso') {
        if(!$required && trim($value=='')) {
            return $value;
        }
        if(!preg_match("/^[A-Z]{".preg_quote($length)."}$/",$value)) {
            $this->err[$fieldname] = $this->resp_invalid_selection($fieldname);
        }
        return $value;
    }

    public function validate_country($value, $required=true, $fieldname='country') {
        $value = purify($value);
        if($required === true && $value == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $value;
        }
        if($required === false && $value == '') {
            return $value;
        }
        include ROOT."/app/betagamers/incs/countrylist/".LANG.".php";
        $allcountries = array_combine(array_keys($country_list), array_column($country_list, 'name'));
        if(!in_array($value, $allcountries) && !array_key_exists($value, $allcountries)) {
            $this->err[$fieldname] = $this->resp_invalid_selection($fieldname);
            return $value;
        }
        return $value;
    }

    public function validate_bg_currencies($value, $required=true, $fieldname='currency') {
        $value = purify($value);
        if($required === true && $value == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $value;
        }
        if($required === false && $value == '') {
            return $value;
        }
        $allcurrencies = rate();
        if(!in_array(strtolower($value), $allcurrencies)) {
            $this->err[$fieldname] = $this->resp_invalid_selection($fieldname);
            return $value;
        }
        return $value;
    }

    public function validate_number($number, $required=true, $fieldname='number') {
        $number = purify($number);
        if($required === true && $number == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $number;
        }
        if($required === false && $number == '') {
            return $number;
        }

        if(!is_numeric($number)) {
            $this->err[$fieldname] = $this->resp_invalid($fieldname);
            return $number;
        }
        return $number;
    }

    public function validate_password($password, $enctype, $length, $required=true) {
        $fieldname = 'password';
        if($required === true && trim($password) == '') {
            $this->err['password'] = $this->resp_empty($fieldname);
            return $password;
        }
        $passwordlen = $this->validate_length($password, $length);
        if($passwordlen === false) {
            $this->err['password'] = $this->resp_invalid_length($fieldname);
            return $password;
        }
        return $enctype($password);
    }

    public function validate_length($data, $min=0, $max=INF) {
        if(!is_numeric($min) || !is_numeric($max)) {
            return false;
        }
        if(strlen($data) > $max) {
            $this->err['maxlength'] = $max;
            return false;
        }
        if(strlen($data) < $min) {
            $this->err['minlength'] = $min;
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
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $link;
        }

        if($required === false && trim($link) == '') {
            return $link;
        }

        if(filter_var($link, FILTER_VALIDATE_URL, $valtype)) {
            return $link;
        } else {
            $this->err[$fieldname] = $this->resp_invalid($fieldname);
        }
        return purify($link);
    }

    public function validate_columns(array $columns, $allowed_columnns=null, $table=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $tablecolumns = $allowed_columnns ?? $tableclass->fetchcolumns();
        if(!is_array($tablecolumns) || !count($tablecolumns)) {
            $this->err['gen'] = $this->resp_unexpected_err();
            return;
        }
        if(array_is_list($columns)) {
            foreach($columns as $val) {
                if(!in_array($val, $tablecolumns)) {
                    // echo $val;
                    $this->err['gen'] = $this->resp_unknown_err();
                    return false;
                }
            }
        } else {
            foreach($columns as $key=>$val) {
                if(!in_array($key, $tablecolumns) ) {
                    unset ($columns[$key]);
                    //echo "$key and $val";
                    //$this->err['gen'] = 'An unknown error occurred'; //to test errors, return columns to know which ones are good and the one that isn't
                    //return false;
                }
            }
            if(!count($columns)) {
                $this->err['gen'] = $this->resp_unknown_err();
                return false;
            }
        }
        return true;
    }

    public function validate_in_array($needle, array $source, $required=true, $fieldname='section') {
        //allow numeric keys or  not
        $needle = purify($needle);
        if($required === true && $needle == '') {
            $this->err[$fieldname] = $this->resp_empty($fieldname);
            return $needle;
        }
        if($required === false && $needle == '') {
            return $needle;
        }
        if(array_is_list($source)) {
            if(!in_array($needle, $source)) {
                $this->err[$fieldname] =  $this->resp_invalid_selection($fieldname);
                return $needle;
            }
        } else {
            if(!in_array($needle, $source) && !array_key_exists($needle, $source)) {
                $this->err[$fieldname] =  $this->resp_invalid_selection($fieldname);
                return $needle;
            }
        }
        return $needle;
    }

    public function exists(array $cols, $joiner='or', $table=null) {
        $table = $table ?? static::$table;
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