<?php
class Processor {
    private function set_table($plan) {
        return match($plan) {
            'Platinum'=>['platinum','diamond'],
            'Combo'=>['alpha','platinum','diamond'],
            default=>[$plan],
        };
    }

    public function process_payments($platform, $fullName, $email, $phone, $currency, $amount, $metaplan, $txn_id, $txn_ref) {
        $vipclass = new Vip_records;
        if($txn_ref != '') {
            $check_ref = $vipclass->select('txn_ref')->where('txn_ref = :txn_ref', ['txn_ref'=>$txn_ref]);
            
            if(is_array($check_ref) && count($check_ref) > 0) {
                error_log("$platform page error: Transaction with $txn_ref already exists.", 0);
                return false;
            }
        }
        
        $gamesclass = new Games;
        $today = date('Y-m-d');
        $nogames = $gamesclass->select('league')->where('date = :date AND league = :league', ['date'=>$today, 'league'=>'nogames']);
        
        $extraday = '0 day';
        if(is_array($nogames) && count($nogames)) {
            $extraday = '1 day';
            //$expdate2 = date('Y-m-d H:i:s', strtotime($expdate2.'+1 day'));
        }

        //$days = $days1 = $days2 = $expdate = $expdate1 = $expdate2 = $insert_user = $update_user = '';
        
        list($plan, $duration) = explode(' ', $metaplan, 2);
        
        $tables = $this->set_table($plan);
        
        if(strtotime($duration)) {
            $expdate = date('Y-m-d H:i:s', strtotime("+$duration+$extraday"));
            $sqlduration = str_ends_with($duration, 's') ? substr($duration, 0, -1) : $duration;
        } else {
            if($metaplan == 'Combo Silver') {
                $days = ['3 day', '7 day'];
            } elseif($metaplan == 'Combo Gold') {
                $days = ['7 day', '30 day'];
            } elseif($metaplan == 'Combo Pro') {
                $days = ['30 day', '30 day'];
            } else {
                error_log("$platform page Error: Error with duration. Metaplan is $metaplan", 0);
            }
            if($metaplan == 'Combo Silver' || $metaplan == 'Combo Gold' || $metaplan == 'Combo Pro') {
                $comboexpdate = array_map(fn($val)=>date('Y-m-d H:i:s', strtotime("+$val+$extraday")), $days);
            }
        }

        $insertdata = [
            'fullName'=>$fullName,
            'email'=>$email,
            'phone'=>$phone,
            'currency'=>$currency,
            'amount'=>$amount,
            'plan'=>$metaplan,
            'txn_id'=>$txn_id,
            'txn_ref'=>$txn_ref,
            'expdate'=>$comboexpdate[1] ?? $expdate
        ];
        // show($insertdata);
        
        $insert_user = $vipclass->insert($insertdata);

        $diamondclass = new Diamond;
        $insertdata = array_diff_key($insertdata, ['plan'=>'dropkey', 'txn_id'=>'dropkey', 'txn_ref'=>'dropkey']);

        foreach($tables as $ind=>$val) {
            $insertdata['expdate'] = $comboexpdate[$ind] ?? $comboexpdate[1] ?? $expdate;
            $sqlduration = $days[$ind] ?? $days[1] ?? $sqlduration;
            $tabquery[$val] = [
                'insert'=>[
                    'colsandvals'=>$insertdata,
                    'self'=>true
                ],
                'on_duplicate_key'=>[
                    'query'=>" update amount=(amount + :amount), expdate=(expdate + INTERVAL $sqlduration + INTERVAL $extraday) ",
                    'params'=>[':amount'=>$amount]
                ],
                'go'=>[]
            ];
        }
        // show($tabquery);
        $insert_user = $diamondclass->transaction($tabquery, 'insert');
        if(is_array($insert_user) && !count($insert_user)) {
            return true;
        } else {
            error_log("$platform page Error: Error with db operations. Metaplan is $metaplan", 0);
            return false;
        }
    }
    
    public function deactivate_sub($platform, $email, $currency, $amount, $metaplan, $purpose) {
        list($plan, $duration) = explode(' ', $metaplan, 2);
        $tables = ($this->set_table($plan));
        array_push($tables, 'vip_records');
        if(strtotime($duration)) {
            $sqlduration = str_ends_with($duration, 's') ? substr($duration, 0, -1) : $duration;
        } else {
            if($metaplan == 'Combo Silver') {
                $days = ['3 day', '7 day'];
            } elseif($metaplan == 'Combo Gold') {
                $days = ['7 day', '30 day'];
            } elseif($metaplan == 'Combo Pro') {
                $days = ['30 day', '30 day'];
            } else {
                error_log("$platform page Error: Error with duration. Metaplan is $metaplan", 0);
            }
            if($metaplan == 'Combo Silver' || $metaplan == 'Combo Gold' || $metaplan == 'Combo Pro') {
                $comboexpdate = array_map(fn($val)=>date('Y-m-d H:i:s', strtotime("-$val")), $days);
            }
        }
        $updatedata = [
            'email'=>$email,
            'amount'=>$amount,
            'expdate'=>$comboexpdate[1] ?? $sqlduration
        ];

        $diamondclass = new Diamond;
        foreach($tables as $ind=>$val) {
            if($purpose=='pause_') {
                $newemailsql = "CONCAT_WS('_', 'pause', TIMESTAMPDIFF(SECOND, NOW(), (SELECT expdate from $val where email=:email ORDER BY id desc limit 1)), :email)";
                $newexpdatesql = "DATE_ADD(expdate, INTERVAL 1 YEAR)";
            } else {
                $newemail = "$purpose$email";
                $newemailsql = ':email';
                $newexpdatesql = "DATE_SUB(expdate, INTERVAL ".($days[$ind] ?? $days[1] ?? $sqlduration).")";
            }
            if($val=='vip_records') {
                $newemail = $purpose=='pause_' ? "$email" : "$purpose$email";
                $newexpdatesql = "@regdate";
            }    
            $tabquery[$val] = [
                'setvariable'=>[
                    'sqlvariables'=>['regdate'=>"(select max(reg_date) from $val where email = :email)"],
                    'params'=>[':email'=>$email]
                ],
                'custom_query'=>[
                    'query'=>"update $val set email=$newemailsql, amount=amount-:amount, expdate=$newexpdatesql where email = :email1 and reg_date=@regdate",
                    'querytype'=>'update',
                    'queryvalues'=>[':email'=>$newemail ?? $email, ':amount'=>$amount, ':email1'=>$email]
                ]
            ];
        }
        $update_user = $diamondclass->transaction($tabquery, 'update');
        if(is_array($update_user) && !count($update_user)) {
            return true;
        } else {
            error_log("$platform page Error: Error with db operations. Metaplan is $metaplan", 0);
            return false;
        }
    }
}