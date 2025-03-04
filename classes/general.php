<?php
class General {
    use Db, Validate;

    public function __call($function, array $params) {
        // get_by_email_or_email_or_id('users', ['email', 'phone'], ['a','b','c', 3], '$additional');
        // update_by_email_or_email_or_id('users', ['email'=>'abcd', 'phone'=>'abcd'], ['a','b','c', 3], '$additional');
        if(str_starts_with($function, 'get_') || str_starts_with($function, 'update_')) {
            $tableclass = new $params[0];
            $keystr = trim(str_replace(['get_by_', 'get_all', 'update_by_', 'update_all', '_or_', '_and_not_', '_and_'], ' ', $function));
            $keyarr = explode(' ', $keystr);
            $input = array_combine($keyarr, $params[2]);
            $validate = $tableclass->validate($input);
            if(isset($validate[1]) && count($validate[1])) {
                return $validate;
            }
            $validvalues = array_values($validate[0]);
            // show($validvalues);
            // foreach($keyarr as $ind=>$val) {
            //     //$validate = $tableclass->validate([$val=>$params[2][$ind]]);
            //     $validate = $tableclass->validate([$val=>$params[2][$ind] ?? $params[2][$val]]);
            //     show($validate);
            //     if(isset($validate[1]) && count($validate[1])) {
            //         return $validate;
            //     }
            //     $validvalues[] = $validate[0][$val];
            // }
            if(str_starts_with($function, 'get')) {
                $action = 'select';
                $columns = $this->validate_columns($params[1], table:$params[0]);
                //var_dump($columns);
                //test if the err set via validate page shows here
                if($columns !== true) {
                    return ['', $this->err];
                }
                $columns = implode(',', $params[1]);
                $args = [$columns ?? $params[1]];
            } else {
                $action = 'update';
                $validate = $tableclass->validate($params[1]);
                if(isset($validate[1]) && count($validate[1])) {
                    return $validate;
                }
                $args = [$validate[0] ?? $params[1], true];
            }
            $whereclause = str_replace(['get_by_', 'update_by_'], '', $function);
            $whereclause = str_replace(['_or_', '_and_not_', '_and_'], ['=? or ', '=? and not ', '=? and '], $whereclause).'=?';
            if(str_starts_with($function, 'get_by_') || str_starts_with($function, 'update_by_')) {
                $data = $tableclass->$action(...$args)->where($whereclause, $validvalues);
            } else {
                $data = $tableclass->$action(...$args)->all();
            }
            $this->inputs = $validate[0]; //outputs original input details to display on form incase $data is empty.
            return [$data, false];
        } else {
            exit(error_log("Unable to handle strange function $function", 0));
        }
    }

    public function __old_call($function, array $arguments) {
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
                $this->err = true;
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
                // show($data);
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
        //$sender['email', 'displayname', 'password']
        $sender['displayname'] = $sender['displayname'] ?? SITENAME;
        return send_mail($sender, $receiver, $message);
    }

    public function verify_otp($function, array $parameters) {
        require_once ROOT.'/app/twilio.php';
        $twilioclass = new Twilio;
        return(call_user_func_array([$twilioclass, $function], $parameters));
    }

    public function create(array $fields, $table=null, string|null $setsession=null) {
        $table = $table ?? self::$table;
        $tableclass = new $table;
        $tableclass->insertunique = $this->insertunique;
        $tableclass->required = $this->required;
        $valid = $tableclass->validate($fields);
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            // echo 'yes';
            // show($valid);
            return $valid;
        }
        if($setsession) {
            // show($valid[0]);
            $reg = $tableclass->insert($valid[0], true)->returnrow($setsession);
            if(is_array($reg) && count($reg)) {
                foreach ($reg[0] as $key => $val) {
                    $_SESSION[$table][$key] = $val;
                }
                return true;
            }
        }
        return $tableclass->insert($valid[0]);
    }

    public function login(array $fields, $table=null, array|null $setsession=null) {
        unset($fields['signature']);
        unset($fields['submit']);
        $logindetails = implode('_and_', array_keys($fields));
        $columnstofetch = $setsession ?? '*';
        $getby = "get_by_$logindetails";
        $valid = $this->$getby($table, $columnstofetch, array_values($fields));
        // show($valid);//exit;
        if(isset($valid[1]) && is_array($valid[1]) && count($valid[1])) {
            //$valid[1]['gen'] = $valid[1]['gen'] ?? $valid[1]['email'] ?? $valid[1]['fullphone'] ?? $valid[1]['phone'] ?? $valid[1]['password'] ?? 'Invalid';
            $valid[1]['gen'] = $this->resp_incorrect_login();
            return $valid;
        }
        $valid = $valid[0];
        if($setsession) {
            if(is_array($valid) && count($valid)) {
                if(count($valid) > 1) { //for some reason, the user details appeared more than once in the db
                    echo 'yes';
                    $max = count($valid) - 1;
                    foreach($valid as $ind=>$val) {
                        if($val['active'] == 1 || $ind == $max) {
                            $valid = $val;
                            break;
                        }
                    }
                    $_SESSION[$table] = $valid;
                } else {
                    $_SESSION[$table] = array_merge([], ...$valid);
                }
                // show($valid);
                // foreach ($valid as $key => $val) {
                //     $_SESSION[$table][$key] = $val;
                // }
                $_SESSION[$table]["phoneauthsend"] = 0;
                $_SESSION[$table]['logged_in'] = true;
                return true;
            } else {
                $valid[1] = ['gen'=>$this->resp_incorrect_login()];
                $valid[0] = $this->inputs ?? $valid[0];
                return $valid;
            }
            
        }
    }

    public function old_login(array $fields, $table=null, $setsession=null) {
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