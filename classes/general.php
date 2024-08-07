<?php
class General {
    use Db, Validate;

    public function __call($function, array $arguments) {
        //get_by_, update_by_, get_all
        //$arguments: 0-table, 1-columns, 2-where, 3-additional
        //get_by_email_or_email_or_id('users', ['email', 'phone'], ['email'=>['a','b','c'], 'id'=>3]);
        // get_by_email_or_email_or_id('users', ['email', 'phone'], ['a','b','c', 3], '$additional');
        $actions = ['get', 'update'];
        $query_arr = explode('_', $function);
        if(is_array($query_arr) && count($query_arr) >= 3) {
            if(!in_array($query_arr[0], $actions)) {
                exit('Invalid action. Please contact Admin about this.');
            }

            $joiners = ['and', 'or', 'not'];
            $count = 0;

            foreach($query_arr as $ind=>$val) {
                if($ind < 2) {
                    $whquery = '';
                    continue;
                }
                if(in_array($val, $joiners)) {
                    $whquery .= $val;
                } else {
                    $whquery .= " $val=:$val$count ";
                    if(isset($arguments[2])) {
                        $validwh[$val] = $arguments[2][$count];
                        $wharr["$val$count"] = $arguments[2][$count];
                    } else {
                        $validwh[$count] = $val;
                    }
                    $count++;
                }
            }

            $tableclass = new $arguments[0];
            switch($query_arr[0]) {
                case 'update':
                    $action = 'update';
                    $cols = $tableclass->validate($arguments[1]);
                    $validcols = $cols[0];
                    // show($cols);
                break;
                case 'get':
                    $action = 'select';
                    if(isset($arguments[1])) {
                        if($arguments[1] == '*') {
                            $validcols = $arguments[1];
                        } else {
                            $cols = $tableclass->validate_columns($arguments[1]);
                            if($cols) {
                                $validcols = implode(', ', $cols);
                            }
                        }
                    } else {
                        $cols = $tableclass->validate_columns($validwh);
                        if($cols) {
                            $validcols = implode(', ', $cols);
                        }
                    }
                    break;
                default:
                    $validcols = $tableclass->validate_columns($arguments[1]);
            }
            if(isset($cols[1]) && is_array($cols[1]) && count($cols[1])) {
                return $cols;
            }
            // $validwh = $tableclass->validate($fields);
            // $validwh = $valid[0];

            if($this->err || $tableclass->err) {
                // show($tableclass->err);
                exit('An unknown error occurred.');
            }

            if($query_arr[1] == 'all') {
                // $data = $tableclass->$action($validcols)->all($arguments[3]);
                $data = $tableclass->$action($validcols)->all();
            } else {
                $data = $tableclass->validate($validwh);
                
                //$tableclass->validate($validwh);
                //show($data);
                // var_dump($wharr);
                
                if(!isset($data[1]) || !count($data[1])) {
                    $data = $tableclass->$action($validcols)->where("$whquery ".($arguments[3] ?? ''), $wharr);
                }
            }

            return $data ?? 'An error occurred. Pleae contact admin about this.';
        } else {
            exit('A poorly formed function has been encountered.');
        }
    }

    public function sendmail(array $receiver, array $message, array $sender) {
        require_once ROOT.'/app/mailer.php';
        //$receiver['email' and 'displayname'];
        //$sender['email', 'displayname', 'passwoord']
        $sender['displayname'] = $sender['displayname'] ?? SITENAME;
        return send_mail($sender, $receiver, $message);
    }

    public function create(array $fields, $table=null, $setsession=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $valid = $tableclass->validate($fields);
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            return $valid;
        }
        if($setsession) {
            $reg = $tableclass->insert($valid[0], $setsession);
            if(is_array($reg) && count($reg)) {
                foreach ($reg[0] as $key => $val) {
                    $_SESSION[$table][$key] = $val;
                }
                return true;
            }
        }
        return $tableclass->insert($valid[0]);
    }

    public function login(array $fields, $table=null, $setsession=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $valid = $tableclass->validate($fields);
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            $valid[1]['gen'] = $valid[1]['gen'] ?? $valid[1]['email'] ?? 'Invalid';
            return $valid;
        }
        if($setsession) {
            $reg = $tableclass->select($setsession)->where('email=:email and password=:password', $valid[0]);
            if(is_array($reg) && count($reg)) {
                foreach ($reg[0] as $key => $val) {
                    $_SESSION[$table][$key] = $val;
                }
                $_SESSION[$table]['logged_in'] = true;
                return true;
            } else {
                $valid[1] = ['gen'=>'Incorrect'];
                return $valid;
            }
        }
    }

    public function verification(array $fields, $table=null, $type) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $valid = $tableclass->validate($fields);
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            return $valid;
        }
        switch ($type) {
            case 'verification':
                $subject = 'Password Reset';
                $message = 
"
";
            break;
            case 'reset':
                $subject = 'Password Reset';
                $message = 
"
";
            break;
            default:
                # code...
                break;
        }
        $this->sendmail($valid[0]['email'], $subject, $message, 'services@tilaseats.com');
    }

    public function verifyhash(array $fields, $table=null, $type) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $valid = $tableclass->validate($fields);
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            return $valid;
        }
        $hash = sha1(mt_rand(0,1000));
        switch ($type) {
            case 'verification':
                return $this->update_by_email('user', ['hash'=>$hash], [$valid[0]['email']]);
            break;
            case 'reset':
                return $this->update_by_email_and_hash('user', ['hash'=>$hash, 'password'=>$fields['password']], [$valid[0]['email'], $valid[0]['hash']]);
            break;
            default:
                # code...
            break;
        }
    }

    public function custom_sql($query, $querytype) {
        return $this->custom_query($query, $querytype);
    }
}