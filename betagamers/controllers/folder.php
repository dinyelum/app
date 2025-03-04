<?php
class Folder extends Controller {
    public $formfields;
    
    public function __construct($mode='') {
        $this->metabots = 'NOINDEX';
        if($mode != 'cron') {
            $this->adminlevel = check_admin();
            if($this->adminlevel=='writer' && basename(URI)=='adminfiles?action=update') {return true;}
            if($this->adminlevel!='admin') {
                exit('You do not have access to this page');
            }
        }
        //$this->set_form_selection();
        //$this->usersclass = new Users;
    }

    function index() {
        $this->check();
    }

    function sidelist() {
        include ROOT."/app/betagamers/incs/menuadmin.php";
        return $sidelist;
    }
    /*
    function users() {
        get
        $this->usersclass = new Users;
        check, $this->check
    }
        */

    private $sections = [
        'diamond'=>'Diamond Plan',
        'platinum'=>'Platinum Plan',
        'alpha'=>'Alpha Plan',
        'othersports'=>'Other Sports Plan',
        'vip_records'=>'All VIP Subscribers',
        'users'=>'General Clients',
    ];

    private $other_sections = [
        'agent'=>'Agents',
        'tipster'=>'Tipsters',
        'bookies'=>'Bookies'
    ];

    protected function set_plan_pricing($cur=null, $return='desc') {
        $arg = match($return) {
            'desc'=>['description'],
            'price'=>[DISCOUNT ? 'plaindiscount' : 'plainprice'],
            default=>[DISCOUNT ? 'plaindiscount' : 'plainprice', 'description']
        };
        return $plans = [
            'diamond'=>array_column(plan_pricing('diamond', $cur), ...$arg),
            'platinum'=>array_column(plan_pricing('platinum', $cur), ...$arg),
            'ultimate'=>array_column(plan_pricing('ultimate', $cur), ...$arg),
            'combo'=>array_column(plan_pricing('combo', $cur), ...$arg),
            'tennis'=>array_column(plan_pricing('tennis', $cur), ...$arg)
        ];
    }

    function check() {
        $this->page = $this->activepage = 'check';
        $data['page_title'] = $data['h1'] = 'Check User';
        $this->check_blueprint($data);
    }

    private function check_blueprint($data) {
        $this->style = "h2{color:green; text-align:center}";
        $data['sidelist'] = $this->sidelist();
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            extract($_POST);
            $this->sections = array_merge($this->sections, $this->other_sections);
            if(array_key_exists($section, $this->sections)) {
                $formdataplan = $section;
                $sectionclass = new $section;
                $sectionclass->strictmode = false;
                $formdata = $sectionclass->validate($_POST);
                if(!is_array($formdata[1]) || !implode($formdata[1])) {
                    $columns = match ($section) {
                        'users' => 'fullname as NAME, email as EMAIL, phone as PHONE, fullphone as FULLPHONE, country as COUNTRY, active as STATUS',
                        'agent' => "name as NAME, phone as PHONE, (if(LEFT(phone, 1)=0, concat(intl, substring(phone, 2, length(phone))), concat(intl, phone))) as `Intl Format`, NETWORK, CURRENCY, (replace(countries, ', ', '<br>'))as COUNTRIES",
                        'bookies'=>"bookie, description_en, description_fr, description_es, description_pt, description_de, reflink, promocode, dashboard as 'Affiliate Dashbord'",
                        default => 'fullName as NAME, email as EMAIL, phone as PHONE, currency as CURRENCY, amount as AMOUNT, DATE_FORMAT(reg_date, "%d/%m/%y") as REGDATE, DATE_FORMAT(expdate, "%d/%m/%y") as EXPDATE',
                    };
                    $wherearr = array_filter($formdata[0]);
                    $where = implode(' AND ', array_map(function($key, $val) {
                        return "$key LIKE CONCAT('%', :$key, '%')";
                    }, array_keys($wherearr), array_values($wherearr)));
                    
                    $clientdata = $sectionclass->select($columns)->where($where, $wherearr);
                    // show($clientdata);
                }
            } else {
                //echo 'Invalid Plan Selection';
                //var_dump($_POST['section']);
            }
        }

        if($this->activepage=='check') {
            $formfields = [
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Full Name", 'name'=>"fullname", 'value'=>$formdata[0]['fullname'] ?? '', 'error'=>$formdata[1]['fullname'] ?? ''],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"E-mail", 'name'=>"email", 'value'=>$formdata[0]['email'] ?? '', 'error'=>$formdata[1]['email'] ?? ''],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone Number", 'name'=>"phone", 'value'=>$formdata[0]['phone'] ?? '', 'error'=>$formdata[1]['phone'] ?? ''],
                ['tag'=>'input', 'type'=>'date', 'name'=>"reg_date", 'value'=>$formdata[0]['reg_date'] ?? '', 'error'=>$formdata[1]['reg_date'] ?? ''],
                ['tag'=>'select', 'name'=>"section", 'options'=>['default_opt_'.($formdataplan ?? '')=>$this->sections[$formdataplan ?? 'def'] ?? null, ...$this->sections], 'error'=>$formdata[1]['plan'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>'']
            ];
        } elseif($this->activepage=='view_agent') {
            if(!isset($country_list)) include ROOT."/app/betagamers/incs/countrylist/".LANG.".php";
            $allcountries = array_combine(array_keys($country_list), array_column($country_list, 'name'));
            $formfields = [
                ['tag'=>'select', 'name'=>"countries", 'options'=>['default_opt_'.($formdata[0]['countries'] ?? '')=>$allcountries[$formdata[0]['countries'] ?? 'def'] ?? null, ...$allcountries], 'error'=>$formdata[1]['countries'] ?? ''],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Network", 'name'=>"network", 'value'=>$formdata[0]['network'] ?? '', 'error'=>$formdata[1]['network'] ?? ''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"section", 'value'=>'agent', 'error'=>''],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"level", 'value'=>'agent', 'error'=>''],
            ];
        } elseif($this->activepage=='view_bookie') {
            if(!isset($sectionclass)) {
                $sectionclass = new Bookies;
            }
            $allbookies = array_column($sectionclass->get_allbookies(), 'bookie');
            $formfields = [
                ['tag'=>'select', 'name'=>"bookie", 'options'=>['default_opt_'.($formdata[0]['bookie'] ?? '')=>$allbookies[$formdata[0]['bookie'] ?? 'def'] ?? null, ...array_combine($allbookies, $allbookies)], 'error'=>$formdata[1]['bookie'] ?? ''],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"section", 'value'=>'bookies', 'error'=>''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>'']
            ];
        } else {}

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        // show($output);exit;
        $data['btntxt'] = 'MENU';
        $data['formfields'] = isset($output) ? array_chunk($output, 3, true) : null;
        $data['formerrors'] = $errs ?? null;
        $data['formerrors']['gen'] = $formdata[1]['gen'] ?? '';
        $data['h2'] = isset($formdataplan) ? strtoupper($formdataplan) : '';
        $data['clientdata'] = $clientdata ?? null;
        $this->view("folder/check",$data);
    }

    function activate() {
        $this->page = $this->activepage = 'activate';
        $this->style = "h1{color:green; text-align:center}";
        $data['sidelist'] = $this->sidelist();
        $plans = $plans ?? $this->set_plan_pricing(strtolower($_POST['currency'] ?? null), 'both');
        // show(array_filter($plans, 'array_keys'));
        // show(array_walk($plans, 'array_keys'));
        // show($plans);
        foreach($plans as $key=>$val) {
            $formdataplans[$key] = array_keys($val);
            $pricearr[$key] = array_values($val);
        }
        // show($formdataplans);
        $dpurpose = [
            'canc_'=>'Cancelled',
            'pause_'=>'Pause Subscription',
            'rev_'=>'Reversal',
            'top_'=>'Top Up',
            'fake_'=>'Fake Transaction Proof'
        ];
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            $formdata = [];
            foreach($formdataplans as $key=>$val) {
                $validplan = in_array($_POST['plan'], $val);
                if($validplan) {
                    if(!in_array(strtolower($_POST['currency']), rate())) $cust_err['currency'] = 'Invalid Currency';
                    if($_POST['amount']!=$plans[$key][$_POST['plan']]) $cust_err['amount'] = 'Problem with amount';
                    $sectionclass = new $key;
                    $formdata = $sectionclass->validate($_POST);
                    //use diamond as class if all plans including tennis / othersports would have the same columns
                    $formdata[0]['plan'] = $_POST['plan'];
                    break;
                }
            }
            // show($cust_err);
            // var_dump($validplan);
            if($validplan===false) $cust_err['plan'] = 'Invalid plan';
            if(isset($_POST['mode']) && $_POST['mode']=='deactivate') {
                if(array_key_exists($_POST['purpose'], $dpurpose)) {
                    $formdatadpurpose = $purposekey = $_POST['purpose'];
                } else {
                    $cust_err['purpose'] = 'Selected reason is invalid';
                }
                /*$purposekey = array_search($_POST['purpose'], $dpurpose);
                if($purposekey===false) {
                    $cust_err['purpose'] = 'Selected reason is invalid';
                } else {
                    $formdatadpurpose = $dpurpose[$purposekey];
                }*/
            }
            
            if((!is_array($formdata[1]) || !implode($formdata[1])) && !isset($cust_err)) {
                $db_process = new Processor;
                if(isset($_POST['mode']) && $_POST['mode']=='deactivate') {
                    $update_db = $db_process->deactivate_sub('Manual', $formdata[0]['email'], $formdata[0]['currency'], $formdata[0]['amount'], $formdata[0]['plan'], $purposekey);
                    if($update_db===true) {
                        $success= "Deactivation of"." ".($formdata[0]['email'])."'s subscription ". "was succesful.<br><br>";
                    }
                } else {
                    $update_db = $db_process->process_payments('Manual', '', $formdata[0]['email'], '', $formdata[0]['currency'], $formdata[0]['amount'], $formdata[0]['plan'], '', '');
                    if($update_db===true) {
                        $success= "Activation of ".$formdata[0]['email']." was succesful. Amount: ".$formdata[0]['amount'].". Instruct user to click on VIP TIPS, click on MENU and select the plan he/she paid for.<br><br>";
                    }
                }
            }
        }

        // show($formdata[0]);exit;
        
        $formfields = [
            'radio'=>[
                'buttons'=>[
                    ['tag'=>'input', 'type'=>'radio', 'name'=>"mode", 'value'=>'activate', 'id'=>'activate', 'checked', 'label'=>'Activate Subscription'],
                    ['tag'=>'input', 'type'=>'radio', 'name'=>"mode", 'value'=>'deactivate', 'id'=>'deactivate', isset($_POST['mode']) && $_POST['mode']=='deactivate' ? 'checked' : '', 'label'=>'Deactivate Sub']
                ],
                'name'=>'mode',
                'error'=>$purposeErr ?? ''
            ],
            ['tag'=>'input', 'type'=>'email', 'placeholder'=>"E-mail", 'name'=>"email", 'value'=>$formdata[0]['email'] ?? '', 'error'=>$formdata[1]['email'] ?? '', 'required'],
            ['tag'=>'select', 'name'=>"currency", 'options'=>['default_opt_'.($formdata[0]['currency'] ?? '')=>$formdata[0]['currency'] ?? null, ...array_combine(rate(), array_map('strtoupper', rate()))], 'id'=>'currency', 'error'=>$cust_err['currency'] ?? $formdata[1]['currency'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Amount", 'class'=>'amount', 'name'=>"amt", 'value'=>$formdata[0]['amount'] ?? '', 'disabled', 'error'=>''],
            ['tag'=>'input', 'type'=>'hidden', 'class'=>'amount', 'name'=>"amount", 'value'=>$formdata[0]['amount'] ?? '', 'error'=>$cust_err['amount'] ?? $formdata[1]['amount'] ?? ''],
            ['tag'=>'select', 'name'=>"plan", 'options_single'=>['default_opt_'.($formdata[0]['plan'] ?? '')=>$formdata[0]['plan'] ?? null, ...$formdataplans], 'id'=>'plan', 'error'=>$cust_err['plans'] ?? $formdata[1]['plan'] ?? '', 'required'],
            ['tag'=>'select', 'name'=>"purpose", 'options'=>['default_opt_'.($formdatadpurpose ?? '')=>$dpurpose[$formdatadpurpose ?? 'def'] ?? null, ...$dpurpose], 'id'=>'purpose', 'class'=>'w3-hide', 'error'=>$cust_err['purpose'] ?? $formdata[1]['purpose'] ?? '', 'required', 'disabled'],
            ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
        ];

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        // show($output);

        //$data['currencies'] = rate();
        $data['page_title'] = $data['h1'] = 'Activate User';
        $data['btntxt'] = 'MENU';
        $data['formfields'] = $output;
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formerrors']['gen'] = $formdata[1]['gen'] ?? '';
        $data['formsuccess'] = $success ?? '';
        //$data['h2'] = isset($formdataplan) ? strtoupper($formdataplan) : '';
        //$data['clientdata'] = $clientdata ?? null;
        $this->view("folder/insert",$data);
    }

    function agents() {
        //change agent_0 in agent db to another thing entirely that doesnt contain 'agent'
        if($_GET['action']=='view') {
            $this->page = $this->activepage = 'view_agent';
            $data['page_title'] = $data['h1'] = 'View Agent';
            $this->check_blueprint($data);
        } elseif($_GET['action']=='add') {
            $this->page = $this->activepage = 'add_agent';
            $this->style = "h1{color:green; text-align:center}";
            $data['sidelist'] = $this->sidelist();

            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
                $agentclass = new Agent;
                $agentclass->insertunique = ['phone'];
                $formdata = $agentclass->validate($_POST);

                if(!$agentclass->err) {
                    if($agentclass->insert($formdata[0])===true) $success = 'Agent successfully added';
                }
            }

            if(!isset($country_list)) include ROOT."/app/betagamers/incs/countrylist/".LANG.".php";
            $allcountries = array_combine(array_keys($country_list), array_column($country_list, 'name'));

            $formfields = [
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Name", 'name'=>"name", 'value'=>$formdata[0]['name'] ?? '', 'error'=>$formdata[1]['name'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'email', 'placeholder'=>"E-mail", 'name'=>"email", 'value'=>$formdata[0]['email'] ?? '', 'error'=>$formdata[1]['email'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone(0706139)", 'name'=>"phone", 'value'=>$formdata[0]['phone'] ?? '', 'error'=>$formdata[1]['phone'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Country Dial Code(+234 or +2340)", 'name'=>"intl", 'value'=>$formdata[0]['intl'] ?? '', 'error'=>$formdata[1]['intl'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Network (Eg: Airtel Uganda, MTN Cameroon)", 'name'=>"network", 'value'=>$formdata[0]['network'] ?? '', 'error'=>$formdata[1]['network'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"country", 'options'=>['default_opt_'.($formdata[0]['country'] ?? '')=>$allcountries[$formdata[0]['country'] ?? 'def'] ?? null, ...$allcountries], 'error'=>$formdata[1]['country'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Countries(NG, GH, KE)", 'name'=>"countries", 'value'=>$formdata[0]['countries'] ?? '', 'error'=>$formdata[1]['countries'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"currency", 'options'=>['default_opt_'.($formdata[0]['currency'] ?? '')=>$formdata[0]['currency'] ?? null, ...array_combine(rate(), array_map('strtoupper', rate()))], 'id'=>'currency', 'error'=>$cust_err['currency'] ?? $formdata[1]['currency'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"level", 'options'=>['agent'=>'Agents'], 'id'=>'level', 'error'=>$formdata[1]['level'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
            ];
    
            $errs = array_column($formfields, 'error', 'name');
            $output = form_format($formfields);
            $data['page_title'] = $data['h1'] = 'Add Agent';
            $data['btntxt'] = 'MENU';
            $data['formfields'] = $output;
            $data['formerrors'] = $errs ?? $formdata[1] ?? null;
            $data['formerrors']['gen'] = $formdata[1]['gen'] ?? '';
            $data['formsuccess'] = $success ?? '';
            $this->view("folder/insert",$data);
        } elseif($_GET['action']=='update') {
            $this->page = $this->activepage = 'update_agent';
            $data['page_title'] = $data['h1'] = 'Update Agent';
            $this->update_blueprint($data);
        } else {}
    }

    function insertfetchamt() {
        if(isset($_GET['cur']) && strlen($_GET['cur'])===3 && isset($_GET['plan'])) {
            $planpricing = array_merge([], ...array_values($this->set_plan_pricing($_GET['cur'], 'both')));
            // show($planpricing);
            if(in_array($_GET['cur'], rate()) && array_key_exists($_GET['plan'], $planpricing)) {
                echo $planpricing[$_GET['plan']];
                return;
            }
        }
        exit('Something went wrong.');
    }

    function update() {
        $this->page = $this->activepage = 'update';
        $data['page_title'] = $data['h1'] = 'Update User';
        $this->update_blueprint($data);
    }

    private function update_blueprint($data) {
        $this->style = "h1{color:green; text-align:center}";
        $data['sidelist'] = $this->sidelist();
        $newval = $_POST['newvalue'] ?? '';
        $parameters = [
            'Name'=>['column'=>$this->activepage == 'update_agent'? 'name' : 'fullname', 'function'=>'validate_name', 'params'=>['name'=>$newval, 'required'=>true, 'fieldname'=>'name']],
            'Email'=>['column'=>'email', 'function'=>'validate_email', 'params'=>['email'=>$newval, 'fieldname'=>'email']],
            'Phone'=>['column'=>'phone', 'function'=>'validate_phone', 'params'=>['phone'=>$newval, 'intformat'=>false, 'fieldname'=>'phone']],
            'Fullphone'=>['column'=>'fullphone', 'function'=>'validate_phone', 'params'=>['phone'=>$newval, 'fieldname'=>'phone']],
            'Currency'=>['column'=>'currency', 'function'=>'validate_bg_currencies', 'params'=>['value'=>$newval, 'fieldname'=>'currency']],
            'Amount'=>['column'=>'amount', 'function'=>'validate_number', 'params'=>['number'=>$newval, 'fieldname'=>'number']],
            'Reg Date'=>['column'=>'reg_date', 'function'=>'validate_date', 'params'=>['date'=>$newval, 'fieldname'=>'date']],
            'Exp Date'=>['column'=>'expdate', 'function'=>'validate_date', 'params'=>['date'=>$newval, 'fieldname'=>'date']],
            'Country'=>['column'=>'country', 'function'=>'validate_country', 'params'=>['value'=>$newval, 'fieldname'=>'country']],
            'Active'=>['column'=>'active', 'function'=>'validate_toggle', 'params'=>['value'=>$newval, 'fieldname'=>'active']],
            'Password'=>['column'=>'password', 'function'=>'validate_password', 'params'=>['password'=>$newval, 'enctype'=>'sha1', 'length'=>6, 'fieldname'=>'password']],
        ];
        $generalparams = array_diff_key($parameters, ['Currency'=>'dropkey', 'Amount'=>'dropkey', 'Exp Date'=>'dropkey']);
        $vipparams = array_diff_key($parameters, ['Fullphone'=>'dropkey', 'Country'=>'dropkey', 'Active'=>'dropkey', 'Password'=>'dropkey']);
        //'id', 'name', 'email', 'phone', 'network', 'intl', 'country', 'countries', 'currency', 'level'
        $agentparams = array_merge($parameters, [
            'Countries'=>['column'=>'countries', 'function'=>'validate_itemname', 'params'=>['name'=>$newval, 'fieldname'=>'countries']],
            'Network'=>['column'=>'network', 'function'=>'validate_alphanumeric', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'network']],
            'Intl'=>['column'=>'intl', 'function'=>'validate_phone', 'params'=>['phone'=>$newval, 'fieldname'=>'country dial code']],
            'Level'=>['column'=>'level', 'function'=>'validate_alphanumeric', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'level']]
        ]);
        $agentparams = array_diff_key($agentparams, [
            ...array_fill_keys(['Fullphone', 'Amount', 'Reg Date', 'Exp Date', 'Active', 'Password'], 'dropkey')
        ]);
        $bookiesparams = [
            'Bookie'=>['column'=>'bookie', 'function'=>'validate_alphanumeric', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'bookie']], 
            'Description EN'=>['column'=>'description_en', 'function'=>'validate_text', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'description_en']], 
            'Description FR'=>['column'=>'description_fr', 'function'=>'validate_text', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'description_fr']], 
            'Description ES'=>['column'=>'description_es', 'function'=>'validate_text', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'description_es']], 
            'Description PT'=>['column'=>'description_pt', 'function'=>'validate_text', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'description_pt']], 
            'Description DE'=>['column'=>'description_de', 'function'=>'validate_text', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'description_de']], 
            'Reflink'=>['column'=>'reflink', 'function'=>'validate_link', 'params'=>['link'=>$newval, 'required'=>true, 'fieldname'=>'reflink']], 
            'Promocode'=>['column'=>'promocode', 'function'=>'validate_alphanumeric', 'params'=>['text'=>$newval, 'required'=>true, 'fieldname'=>'promocode']], 
            'Dashboard'=>['column'=>'dashboard', 'function'=>'validate_link', 'params'=>['link'=>$newval, 'required'=>true, 'fieldname'=>'dashboard']], 
            'Active'=>['column'=>'active', 'function'=>'validate_toggle', 'params'=>['value'=>$newval, 'fieldname'=>'active']], 
            'Homepage'=>['column'=>'homepage', 'function'=>'validate_toggle', 'params'=>['value'=>$newval, 'fieldname'=>'homepage']],
            'Countries'=>['column'=>'countries', 'function'=>'validate_itemname', 'params'=>['name'=>$newval, 'fieldname'=>'countries']]
        ];
        if($this->activepage == 'update_agent') $parameters = $agentparams;
        if($this->activepage == 'update_bookie') $parameters = $bookiesparams;
        
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            // show($_POST);
            extract($_POST);
            if(!array_key_exists($parameter, $parameters)) {
                $cust_err['parameter'] = 'Invalid Parameter';
            } else {
                $formdataparam = $parameter;
            }
            $this->sections = array_merge($this->sections, $this->other_sections);
            if(!array_key_exists($section, $this->sections)) {
                $cust_err['section'] = 'Invalid Selection';
            } else {
                $formdataplan = $section;
                $sectionclass = new $section;
                $formdata = $sectionclass->validate($_POST);
                $formdata[0] = array_filter($formdata[0]);

                $formdatanewval = call_user_func_array([$sectionclass, $parameters[$parameter]['function']], $parameters[$parameter]['params']);
                $newvalerr = $sectionclass->err[$parameters[$parameter]['params']['fieldname']] ?? null;
                
                if(!$sectionclass->err && !isset($cust_err)) {
                    // echo 'here';
                    foreach($formdata[0] as $key=>$val) {
                        $whqueryarr[] = "$key=:$key".'1';
                        $wherearr[":$key".'1'] = $val;
                    }
                    $whquery = implode(' and ', $whqueryarr);
                    $tabquery[$section] = [
                        'select'=>[
                            'columns'=>$this->activepage == 'update_bookie' ? 'bookie' : 'email, phone'
                        ],
                        'where'=>[
                            'whquery'=>$whquery,
                            'wharray'=>$wherearr
                        ],
                        'update'=>[
                            'columns'=>[$parameters[$parameter]['column']=>$formdatanewval],
                        ],
                        '2where'=>[
                            'whquery'=>$whquery,
                            'wharray'=>$wherearr
                        ]
                    ];
                    // show($tabquery);
                    $update_data = $sectionclass->transaction($tabquery, 'select');
                    // show($update_data);

                    if(count($update_data[$section]['where'])) {
                        if($update_data[$section]['2where']===true) $success = "Successfully Updated.<br><br>";
                    } else {
                        $generr = 'Record not found';
                    }
                }
            }
            $formdatanewval = $formdatanewval ?? purify($newvalue);
        }

        if($this->activepage=='update') {
            $formfields = [
                ['tag'=>'input', 'type'=>'email', 'placeholder'=>"E-mail", 'name'=>"email", 'value'=>$formdata[0]['email'] ?? '', 'error'=>$formdata[1]['email'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone Number", 'name'=>"fullphone", 'value'=>$formdata[0]['fullphone'] ?? $formdata[0]['phone'] ?? '', 'id'=>'fullphone', 'error'=>$formdata[1]['fullphone'] ?? $formdata[1]['phone'] ?? ''],
                ['tag'=>'select', 'name'=>"section", 'options'=>['default_opt_'.($formdataplan ?? '')=>$this->sections[$formdataplan ?? 'def'] ?? null, ...$this->sections], 'id'=>'section', 'error'=>$cust_err['section'] ?? $formdata[1]['section'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"parameter", 'options'=>['default'=>$formdataparam ?? null, ...array_keys($parameters)], 'id'=>'parameter', 'error'=>$cust_err['parameter'] ?? $formdata[1]['parameter'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"New Value", 'name'=>"newvalue", 'value'=>$formdatanewval ?? '', 'id'=>'newvalue', 'error'=>$newvalerr ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
            ];
        } elseif($this->activepage=='update_agent') {
            $formfields = [
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone Number", 'name'=>"fullphone", 'value'=>$formdata[0]['fullphone'] ?? $formdata[0]['phone'] ?? '', 'id'=>'fullphone', 'error'=>$formdata[1]['fullphone'] ?? $formdata[1]['phone'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"section", 'options'=>['agent'=>'Agents'], 'id'=>'section', 'error'=>$cust_err['section'] ?? $formdata[1]['section'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"parameter", 'options'=>['default'=>$formdataparam ?? null, ...array_keys($parameters)], 'id'=>'parameter', 'error'=>$cust_err['parameter'] ?? $formdata[1]['parameter'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"New Value", 'name'=>"newvalue", 'value'=>$formdatanewval ?? '', 'id'=>'newvalue', 'error'=>$newvalerr ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
            ];
        } elseif($this->activepage=='update_bookie') {
            if(!isset($sectionclass)) {
                $sectionclass = new Bookies;
            }
            $bookies = $sectionclass->get_allbookies();
            $allbookies = array_column($bookies, 'bookie');
            $bookiescountries = array_column($bookies, 'countries');
            $formfields = [
                ['tag'=>'select', 'name'=>"bookie", 'options_single'=>['default'=>$formdatabookies ?? null, ...$allbookies], 'id'=>'bookie', 'error'=>$cust_err['bookie'] ?? $formdata[1]['bookie'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"section", 'options'=>['bookies'=>'Bookies'], 'id'=>'section', 'error'=>$cust_err['bookies'] ?? $formdata[1]['bookies'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"parameter", 'options'=>['default'=>$formdataparam ?? null, ...array_keys($parameters)], 'id'=>'parameter', 'error'=>$cust_err['parameter'] ?? $formdata[1]['parameter'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"New Value", 'name'=>"newvalue", 'value'=>$formdatanewval ?? '', 'id'=>'newvalue', 'error'=>$newvalerr ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
            ];
        }

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        // show($output);

        $data['btntxt'] = 'MENU';
        $data['formfields'] = $output;
        $data['generalparams'] = array_keys($generalparams);
        $data['vipparams'] = array_keys($vipparams);
        $data['agentparams'] = array_keys($agentparams);
        $data['bookiesparams'] = array_keys($bookiesparams);
        $data['bookiescountries'] = $bookiescountries ?? [];
        $data['defaultparam'] = $formdataparam ?? '';
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formerrors']['gen'] = $formdata[1]['gen'] ?? $generr ?? '';
        $data['formsuccess'] = $success ?? '';
        $this->view("folder/update",$data);
    }

    function confirmreg() {
        $this->page = $this->activepage = 'confirmreg';
        $this->style = "h1{color:green; text-align:center}";
        $data['sidelist'] = $this->sidelist();

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            unset($_POST['submit']);
            $phones = array_unique(array_filter($_POST));
            $usersclass = new Users;
            foreach ($phones as $key => $val) {
                $formdata[0][$key] = $usersclass->validate_phone($val, intformat:false, fieldname:$key);
                if(isset($usersclass->err[$key])) {
                    $formdata[1][$key] = $usersclass->err[$key] ?? '';
                } else {
                    $whqueryarr[] = "phone = :$key";
                    $whholdersarr[] = '?';
                    $wherearr[":$key"] = $val;
                }
            }
        }

        if(!isset($usersclass->err)) {
            $whquery = implode(' or ', $whqueryarr);
            $whholders = implode(', ', $whholdersarr);
            $tabquery['users'] = [
                'select'=>[
                    'columns'=>'phone'
                ],
                'where'=>[
                    'whquery'=>"($whquery) and active=0",
                    'wharray'=>$wherearr
                ],
                'custom_query'=>[
                    'query'=>"UPDATE users SET email = LOWER(CONCAT(country, phone, '@betagamers.net')), active = 1 WHERE phone in ($whholders)",
                    'querytype'=>'select',
                    'queryvalues'=>array_values($wherearr)
                ]
            ];
            $sectionclass = new Users;
            $update_data = $sectionclass->transaction($tabquery, 'select');
            // show($update_data);
            $responses = array_map(fn($val)=>in_array($val, array_column($update_data['users']['where'], 'phone')) ? 'Updated Successfully': 'This phone number does not exist OR is already active', $phones);
        }

        $formfields = [
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone 1 | 07000", 'name'=>"phone1", 'value'=>$formdata[0]['phone1'] ?? '', 'error'=>$formdata[1]['phone1'] ?? ''],
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone 2", 'name'=>"phone2", 'value'=>$formdata[0]['phone2'] ?? '', 'error'=>$formdata[1]['phone2'] ?? ''],
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone 3", 'name'=>"phone3", 'value'=>$formdata[0]['phone3'] ?? '', 'error'=>$formdata[1]['phone3'] ?? ''],
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Phone 4", 'name'=>"phone4", 'value'=>$formdata[0]['phone4'] ?? '', 'error'=>$formdata[1]['phone4'] ?? ''],
            ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
        ];

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        // show($output);

        $data['page_title'] = $data['h1'] = 'Confirm Reg';
        $data['btntxt'] = 'MENU';
        $data['formfields'] = $output;
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formerrors']['gen'] = $formdata[1]['gen'] ?? $generr ?? '';
        $data['formsuccess'] = $success ?? '';
        $data['responses'] = $responses ?? [];
        $this->view("folder/confirmreg",$data);
    }

    private function upload_games($data) {
        $this->style = "h1{color:green; text-align:center}";
        $data['sidelist'] = $this->sidelist();
        $this->view("folder/games",$data);
    }

    function vipgames() {
        $this->page = $this->activepage = 'vipgames';
        $data['h1'] = 'Upload Games';
        $data['page_title'] = 'Upload VIP Games';
        $data['btntxt'] = 'MENU';
        $gamesclass = new Games;
        $data['games'] = $gamesclass->games;
        $data['inputheader'] = [
            'COUNTRY'=>'m4',
            'FIXTURE'=>'m5',
            'TIP'=>'m3'
        ];
        $data['updateheader'] = [
            'DATE'=>'m2',
            'COUNTRY'=>'m2',
            'FIXTURE'=>'m2',
            'TIP'=>'m2',
            'GAMES'=>'m1',
            'FREE'=>'m1',
            'WINS'=>'m1',
            'RES'=>'m1'
        ];
        $this->upload_games($data);
    }

    function freegames() {
        $this->page = $this->activepage = 'freegames';
        $data['h1'] = 'Upload Free Games';
        $data['page_title'] = 'Upload Free Games';
        $data['btntxt'] = 'MENU';
        $freegamesclass = new Freegames;
        $data['games'] = $freegamesclass->leagues;
        $data['inputheader'] = [
            'FIXTURE'=>'m7',
            'TIP'=>'m5',
        ];
        $data['updateheader'] = [
            'DATE'=>'m2',
            'LEAGUE'=>'m2',
            'FIXTURE'=>'m3',
            'TIP'=>'m2',
            'STATUS'=>'m1',
            'RES'=>'m2',
        ];
        $this->upload_games($data);
    }

    function viprecords() {
        date_default_timezone_set('Africa/Lagos');
        $this->style = "h1,h2{color:green; text-align:center}";
        $marksclass = new Marks;
        if($_GET['action']==='update') {
            $percents = $marksclass->select('games, percent')->where('date=(select max(date) from marks)');
            $this->page = $this->activepage = 'update_viprecords';
            if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                if(isset($_POST['submit']) && $_POST['submit']=='Submit') {
                    $validdate = $marksclass->validate_date($_POST['date']);
                    $genErr = $marksclass->err['date'] ?? null;
                    if(!$marksclass->err) {
                        $datedata = $marksclass->exists(['date'=>$validdate]);
                        if($datedata===true) {
                            $genErr = "This Date already exists. Do you want to overwrite? 
                            <input type=submit name=update value='Overwrite' class=w3-padding>";
                        }
                    }
                    foreach($_POST['row'] as $ind=>$val) {
                        $validate = $marksclass->validate($val);
                        $gamedata[$ind] = $validate[0];
                        $gamedata[$ind]['date'] = $validdate;
                        $errdata[$ind] = $validate[1];
                        $marksclass->err = null;
                    }
                    if(!count(array_filter($errdata, 'is_array')) && !isset($genErr)) {
                        $db = $marksclass->transaction(
                            [
                                'marks'=>[
                                    'insert_multi'=>[$gamedata],
                                    ...$marksclass->update_percent(),
                                    'select'=>['games, percent'],
                                    'where'=>['date=(select max(date) from marks)']
                                ]
                            ]
                        );
                        if($db['marks']['insert_multi']===true) {
                            $success = 'Updated Successfully';
                            $percents = $db['marks']['where'];
                        }
                    }

                } elseif(isset($_POST['update']) && $_POST['update']=='Overwrite') {
                    $validdate = $marksclass->validate_date($_POST['date']);
                    $genErr = $marksclass->err['date'] ?? null;
                    foreach($_POST['row'] as $ind=>$val) {
                        $validate = $marksclass->validate($val);
                        $gamedata[$ind] = $validate[0];
                        // $gamedata[$ind]['date'] = $validdate;
                        $errdata[$ind] = $validate[1];
                        $marksclass->err = null;
                        $uparr[$ind.'update'] = [['mark'=>$val['mark']], true];
                        $uparr[$ind.'where'] = ["date = ? and games=?", [$validdate, $val['games']]];

                    }
                    if(!count(array_filter($errdata, 'is_array')) && !isset($genErr)) {
                        // $db = $marksclass->update($gamedata)->where('', ['date'=>$validdate]);
                        // show($uparr);exit;
                        $tabquery = [
                            'marks'=>[
                                ...$uparr,
                                ...$marksclass->update_percent(),
                                'select'=>['games, percent'],
                                'where'=>['date=(select max(date) from marks)']
                            ]
                        ];
                        $db = $marksclass->transaction($tabquery);
                        // show($db);
                        $maxind = count($_POST['row'])-1;
                        if($db['marks'][$maxind.'where']===true) {
                            $success = 'Updated Successfully';
                            $percents = $db['marks']['where'];
                        }
                    }
                } elseif(isset($_POST['bestvip']) && $_POST['bestvip']=='Update') {
                    $formdata = $marksclass->validate($_POST);
                    if(!$marksclass->err) {
                        $db = $marksclass->update(['best'=>$formdata[0]['best']])->where("games=:games and date like concat('%', :best, '%') order by date desc limit 1", [':games'=>$formdata[0]['games']]);
                        if($db===true) {
                            $vipsuccess = 'Updated Successfully';
                        }
                    }
                }
            }
            $formfields = [
                ['tag'=>'select', 'name'=>"games", 'options'=>['default_opt_'.($formdata[0]['games'] ?? '')=>$formdata[0]['games'] ?? null, ...$marksclass->games], 'error'=>$formdata[1]['games'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"best", 'options'=>['default_opt_'.($formdata[0]['best'] ?? '')=>isset($formdata[0]['best']) ? 'Yes' : null, 1=>'Yes', 0=>'No'], 'error'=>$formdata[1]['best'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'month', 'name'=>"month", 'value'=>$formdata[0]['best'] ?? '', 'error'=>$formdata[1]['best'] ?? '', 'class'=>'w3-padding', 'style'=>'margin-top:4%'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"bestvip", 'value'=>'Update', 'error'=>''],
            ];
    
            $viperrors = array_column($formfields, 'error', 'name');
            $vipformfields = form_format($formfields);
            
            
            $data['h1'] = $data['page_title'] = 'Update VIP Records';
            $data['btntxt'] = 'MENU';
            $data['sidelist'] = $this->sidelist();
            $data['games'] = $marksclass->games;
            $data['percent'] = array_column($percents, 'percent', 'games');
            $data['formerrors'] = $errdata ?? null;
            $data['formerrors']['gen'] = $genErr ?? '';
            $data['formdata'] = $gamedata ?? null;
            $data['formdate'] = $validdate ?? '';
            $data['formsuccess'] = $success ?? '';
            $data['showvipform'] = in_array(date('d', strtotime('today')), [27, 28, 29, 30, 31, 1, 2, 3]);
            $data['vipformfields'] = $vipformfields ?? null;
            $data['viperrors'] = $viperrors ?? null;
            $data['vipsuccess'] = $vipsuccess ?? null;
            $this->view("folder/marks",$data);
        } elseif($_GET['action']==='view') {
            $this->page = $this->activepage = 'view_viprecords';
            
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
                $validfrom = $marksclass->validate_date($_POST['from'], fieldname:'from');
                $validto = $marksclass->validate_date($_POST['to'], fieldname:'to');
                if(!$marksclass->err) {
                    $allmarks = $marksclass->get_records($validfrom, $validto, array_keys($marksclass->games));
                    // show($allmarks);
                    if(count($allmarks)) {
                        foreach($allmarks as $ind=>$val) {
                            list($mark, $size, $color) = explode(',', $val['mark']);
                            $date = date('d', strtotime($val['date']));
                            $secmarks[$val['games']][$val['date']] = "<div class='w3-col s2 w3-padding-top'><br>".$marksclass->fa_fa_mark($mark, '30px', $color, $date)."</div>";
                        }
                        // foreach($marksclass->games as $key=>$val) {
                        //     $rearranged_marks[$key] = $secmarks[$key];
                        // }
                        // show($rearranged_marks);
                    }
                }
            }
            $formfields = [
                ['tag'=>'input', 'type'=>'date', 'name'=>"from", 'value'=>$validfrom ?? '', 'error'=>$marksclass->err['from'] ?? ''],
                ['tag'=>'input', 'type'=>'date', 'name'=>"to", 'value'=>$validto ?? '', 'error'=>$marksclass->err['to'] ?? ''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Show', 'error'=>''],
            ];
            $errs = array_column($formfields, 'error', 'name');
            $output = form_format($formfields);
            // show($rearranged_marks);
            $data['h1'] = $data['page_title'] = 'View VIP Records';
            $data['btntxt'] = 'MENU';
            $data['sidelist'] = $this->sidelist();
            $data['formfields'] = $output;
            $data['games'] = $marksclass->games;
            $data['marks'] = isset($secmarks) ? array_chunk($secmarks, 2, true) : [];
            $this->view("folder/marks",$data);
        }
    }

    function adminfiles() {
        $adminfilesclass = new Adminfiles;
        if($_GET['action']==='update') {
            $this->page = $this->activepage = 'update_adminfiles';
            $data['h1'] = $data['page_title'] = 'Update Admin Files';
            if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
                $formdata = $adminfilesclass->validate(array_merge($_POST, $_FILES));
                if(isset($formdata[0]['fileToUpload']) && is_array($formdata[0]['fileToUpload'])) {
                    if($formdata[0]['filegroup']=='screenshots') {
                        if(isset($formdata[1]['fileToUpload']) && is_array($formdata[1]['fileToUpload'])) {
                            foreach($formdata[1]['fileToUpload'] as $key=>$val) {
                                if(str_contains($val, 'already exists')) {
                                    $imgsrcs[] = $key;
                                    unset($formdata[1]['fileToUpload'][$key]);
                                }
                            }
                            if(!count(array_filter($formdata[1], fn($val)=>is_array($val) ? implode($val) : $val))) {
                                $adminfilesclass::$table = 'screenshots';
                                $dbcheck = $adminfilesclass->select('distinct img_src')->where('img_src in ('.implode(',', array_fill(0, count($imgsrcs), '?')).') and date=? and lang=?', [...$imgsrcs, $formdata[0]['date'], $formdata[0]['lang']]);
                                if(is_array($dbcheck) && count($dbcheck)) {
                                    foreach($dbcheck as $ind=>$val) {
                                        $err[] = $val['img_src'].' already exists.';
                                        $alreadyexists[] = $val['img_src'];
                                    }
                                    $formdata[0]['fileToUpload'] = array_values(array_diff($formdata[0]['fileToUpload'], $alreadyexists));
                                    var_dump($formdata[0]['fileToUpload']);
                                }
                            }
                        }
                        // show($adminfilesclass->err);
                        // show($formdata[1]);
                        if(!count(array_filter($formdata[1], fn($val)=>is_array($val) ? implode($val) : $val)) && $formdata[0]['fileToUpload']) {
                            $adminfilesclass::$table = 'screenshots';
                            foreach($formdata[0]['fileToUpload'] as $ind=>$val) {
                                $dbdata[$ind]['img_src'] = $val;
                                $dbdata[$ind]['date'] = $formdata[0]['date'];
                                $dbdata[$ind]['lang'] = $formdata[0]['lang'];
                            }
                            // show($dbdata);
                            $db = $adminfilesclass->insert_multi($dbdata);
                            if($db===true) {
                                $success = implode('<br>', array_column($dbdata, 'img_src')).'<br>Uploaded successfully';
                            } else {
                                $genErr = 'Somethhing went wrong';
                            }
                        }
                        $formdata[1]['fileToUpload'] = isset($formdata[1]['fileToUpload']) && count($formdata[1]['fileToUpload']) ? $formdata[1]['fileToUpload'] : ($err ?? null);
                        if(!isset($formdata[1]['fileToUpload']) || !count(array_filter($formdata[1]['fileToUpload']))) $formdata[1]['fileToUpload'] = $this->err['imgerr'] ?? null;
                    } elseif($formdata[0]['filegroup']=='topteams') {
                        $details = pathinfo($formdata[0]['fileToUpload'][0]);
                        // show($details);
                        if($details['extension']=='zip') {
                            $zippedfile = [
                                'ziplocation'=>ROOT.'/app/betagamers/incs/free_predicts_writeups/en/teams/'.$details['basename'], 
                                'archivepathtofile'=>'teams', 
                                'filename'=>'teams', 
                                'savepath'=>ROOT.'/app/betagamers/incs/free_predicts_writeups/en/teams/',
                            ];
                            $extract = unzip($zippedfile, ['html', 'htm']);
                            if($extract) {
                                $formdata[0]['fileToUpload'][0] = $extract;
                            } else {
                                $genErr = 'Error with unzipping file';
                                error_log('An file unzipping error has occured on the upload teams section (/app/betagamers/incs/free_predicts/en/teams/)', 0);
                            }
                        }

                        if(!file_exists($file=ROOT.'/app/betagamers/incs/free_predicts/en/teams/'.$formdata[0]['fileToUpload'][0]) || (date('Y-m-d', filemtime($file))!=date('Y-m-d', strtotime('today')))) {
                            $genErr = 'A very interesting error. Please Contact admin immediately';
                        }

                        if(substr($file, -3, 3)!='zip') $filecontent = file_get_contents($file);

                        if(isset($filecontent) && file_put_contents($file, format_word_htm($filecontent))) $success = 'Uploaded successfully';
                        if(isset($zippedfile['ziplocation']) && file_exists($zippedfile['ziplocation'])) unlink($zippedfile['ziplocation']);
                        if($formdata[0]['fileToUpload'][0] != 'teams') error_log('An unknown file was uploaded as teams', 0);
                    } elseif($formdata[0]['filegroup']=='adminfiles') {
                        if(!count(array_filter($formdata[1], fn($val)=>is_array($val) ? implode($val) : $val)) && $formdata[0]['fileToUpload']) {
                            foreach($formdata[0]['fileToUpload'] as $ind=>$val) {
                                $dbdata[$ind]['filename'] = $val;
                                $dbdata[$ind]['folder'] = $formdata[0]['folder'];
                            }

                            $tabquery = [
                                'adminfiles'=>[
                                    'insert_multi'=>[$dbdata, true],
                                    'on_duplicate_key'=>['UPDATE folder = VALUES(folder), modified = current_timestamp'],
                                    'go'=>[]
                                ],
                                'downloads'=>[
                                    'delete'=>[],
                                    'where'=>["adminfilesid in (select id from adminfiles where filename in (".implode(',', array_fill(0, count($formdata[0]['fileToUpload']), '?'))."))", $formdata[0]['fileToUpload']]
                                ]
                            ];
                            $db = $adminfilesclass->transaction($tabquery);
                            if($db['adminfiles']['go']===true) {
                                $success = implode('<br>', array_column($dbdata, 'filename')).'<br>Uploaded successfully';
                            } else {
                                $genErr = 'Somethhing went wrong';
                            }
                        }
                    }
                }
            }
            if($this->adminlevel=='writer') {
                $adminfilesclass->filegroup = [
                    'topteams'=>'Top Teams'
                ];
            }
            $formfields = [
                ['tag'=>'select', 'name'=>"filegroup", 'id'=>"filegroup", 'options'=>['default_opt_'.($formdata[0]['filegroup'] ?? '')=>$formdata[0]['filegroup'] ?? null, ...$adminfilesclass->filegroup], 'error'=>$formdata[1]['filegroup'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'file', 'name'=>"fileToUpload[]", 'id'=>"fileToUpload", 'error'=>isset($formdata[1]['fileToUpload']) ? implode('<br><br>',$formdata[1]['fileToUpload']) : '', 'multiple required', 'class'=>'w3-padding-16', 'style'=>'margin:auto; width: 90%'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"upload", 'value'=>'Upload', 'id'=>"submit", 'error'=>''],
            ];
            $errors = array_column($formfields, 'error', 'id');
            // show($errors);
            $formfields = form_format($formfields);
            
        } elseif($_GET['action']==='view') {
            $this->page = $this->activepage = 'view_adminfiles';
            $data['h1'] = $data['page_title'] = 'View Admin Files';
            // select a.filename, a.folder, if(d.agentid=1, 1, 0) as downloaded from adminfiles as a left join downloads as d on a.id=d.adminfilesid and d.agentid=1;
            $dbdata = $adminfilesclass->select("distinct a.id, a.filename, a.folder, 
            CASE 
            WHEN DATEDIFF(NOW(),a.modified) > 1 THEN concat(DATEDIFF(NOW(),a.modified), ' days ago')
            WHEN DATEDIFF(NOW(),a.modified) = 1 THEN '1 day ago'
            ELSE CASE
                WHEN TIMESTAMPDIFF(HOUR, a.modified, NOW()) > 1 THEN concat(TIMESTAMPDIFF(HOUR, a.modified, NOW()), ' hours ago')
                ELSE concat(TIMESTAMPDIFF(HOUR, a.modified, NOW()), ' hour ago')
                END
            END as 'Last Modified',if(d.agentid=:agentid, 1, 0) as downloaded", 'a')->
            join('left join', 'downloads', 'a.id=d.adminfilesid and d.agentid=:agentid', 'd')->
            where("folder != 'root' order by folder, downloaded", ['agentid'=>$_SESSION['users']['id']]);
            foreach($dbdata as $ind=>$val) {
                $adminfiles[$val['folder']][] = $val;
                $adminfileids[] = $val['id'];
            }
            // show($adminfiles);
        }
        
        $data['btntxt'] = 'MENU';
        $data['sidelist'] = $this->sidelist();
        $data['formfields'] = $formfields ?? null;
        $data['formdata'] = $formdata ?? null;
        $data['formerrors'] = $errors ?? null;
        $data['formerrors']['gen'] = $genErr ?? $formdata[1]['genErr'] ?? '';
        $data['formsuccess'] = $success ?? '';
        $data['workfilefolders'] = $adminfilesclass->workfilefolders ?? [];
        $data['adminfiles'] = $adminfiles ?? [];
        $data['adminfileids'] = $adminfileids ?? [];
        $data['modalmessage'] = '<pre>'.file_get_contents(ROOT.'/files/betagamers/work/notes.txt').'</pre>';
        $this->view("folder/adminfiles",$data);
    }

    function copy() {
        date_default_timezone_set('Africa/Lagos');
        $datetod = date('Y-m-d', strtotime('today'));
        $dateyes = date('Y-m-d', strtotime('yesterday'));
        include ROOT."/app/betagamers/incs/glossary.php";

        if(isset($_GET['type']) && $_GET['type']=='free') {
            $table = 'freegames';
            $dir = 'free_predicts';
            $gamesclass = new Freegames;
            $blueprint = $gamesclass->leagues;
        } else {
            $table = 'games';
            $dir = 'table';
            $gamesclass = new Games;
            $blueprint = $gamesclass->gamesmain;
        }

        $tabquery[strtolower($table)] = [
            'select'=>["*, DATE_FORMAT(date, '%d/%m') as date, date as dbdate"],
            'where'=>["date >= DATE_SUB(curdate(), INTERVAL 1 DAY) || recent in ('prev', 'cur') order by date"],
            '1select'=>["*, DATE_FORMAT(date, '%d/%m') as date, date as dbdate"],
            '1where'=>["date <= curdate() AND recent = 1 order by id desc limit 16"]
        ];

        $getgames = $gamesclass->transaction($tabquery);
        foreach($getgames[$table]['where'] as $ind=>$val) {
            if(isset($_GET['type']) && $_GET['type']=='free') {
                $games[$val['league']][$val['recent']=='prev' ? 'yes' : ($val['recent']=='cur' ? 'tod' : 'tom')][$val['dbdate']][] = $val;
            } else {
                $games[$val['games']][$val['recent']=='prev' || ($val['dbdate']<$datetod && $val['recent']!='cur') ? 'yes' : ($val['recent']=='cur' || $val['dbdate']==$datetod ? 'tod' : 'tom')][] = $val;
                if($val['free']==1) {
                    $games['free'][$val['recent']=='prev' || ($val['dbdate']<$datetod && $val['recent']!='cur') ? 'yes' : ($val['recent']=='cur' || $val['dbdate']==$datetod ? 'tod' : 'tom')][] = $val;
                }
                $games['recent']['tod'] = $getgames['games']['1where'];
            }
        }
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ROOT."/app/betagamers/incs/$dir"),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach($files as $file) {
            if($file->getExtension() == 'php') {
                $filename = $file->getBasename('.php');
                $fullfilename = $file->getFilename();
                $fields = match($filename) {
                    'free'=>['league', 'fixture', 'tip', 'result'],
                    'popular'=>['league', 'fixture', 'tip'],
                    default=>['date', 'league', 'fixture', 'tip', 'result']
                };
                if(array_key_exists($filename, $blueprint)) {
                    foreach(['yes', 'tod', 'tom'] as $day) {
                        // if($day=='tom' && $filename=='recent') echo 'yea yea';
                        if($day=='tom' && $filename=='popular') $fields=['date', 'league', 'fixture', 'tip'];
                        if(!isset($games[$filename][$day])) {
                            if(isset($games[''][$day]) && 
                            count(array_filter($games[''][$day], fn($arrval)=>in_array('nogames', $arrval))) &&
                            in_array($filename, $gamesclass->gamesfocus)) {
                                $output = [];
                            } else {
                                $output = ["<!--<tr><td></td><td></td><td></td><td></td><td></td></tr>-->"];
                            }
                        } else {
                            $output = [];
                            foreach($games[$filename][$day] as $subind=>$subval) {
                                if(isset($_GET['type']) && $_GET['type']=='free') {
                                    $output[] = "\n<h3>For ".date('l, jS F, Y', strtotime($subind))."</h3>\n";
                                    foreach($subval as $subgames) {
                                        $display = array_intersect_key($subgames, array_fill_keys($fields, 'keep'));
                                        $output[] = "
                                        <p class='w3-large'>".$display['fixture'].'</p>
                                        <p>Tip: '.$display['tip'].'</p>
                                        <p>Result: '.$display['result']."</p>\n";
                                    }
                                } else {
                                    $display = array_intersect_key($subval, array_fill_keys($fields, 'keep'));
                                    $output[] = '<tr><td>'.implode('</td><td>', $display).'</td></tr>';
                                }
                            }
                            if(array_key_exists($filename.'2', $games) || array_key_exists($filename.'3', $games)) {
                                foreach(['2', '3'] as $suffix) {
                                    if(!isset($games[$filename.$suffix][$day])) continue;
                                    $output[] = '<?=$set'.$suffix.' ?>';
                                    foreach($games[$filename.$suffix][$day] as $subind=>$subval) {
                                        $display = array_intersect_key($subval, array_fill_keys($fields, 'keep'));
                                        $output[] = '<tr><td>'.implode('</td><td>', $display).'</td></tr>';
                                    }
                                }
                            }
                        }
                        // if($day=='tom' && $filename=='recent') echo 'yea yea';
                        if(($day=='yes' && $filename=='popular') || in_array($day, ['yes', 'tom']) && $filename=='recent') {$output = []; continue;}
                        // echo $filename.$day.'<br>';
                        $day = $day=='tod' ? '' : $day;
                        $link = $file->getPath()."/$day$fullfilename";
                        // show($output);
                        $output_en = iconv("CP1257","UTF-8", implode($output));
                        file_put_contents($link, $output_en);
                        //if tom, popular rename to upcoming
                        //convert
                        //, 'es'=>$es, 'pt'=>$pt, 'de'=>$de
                        foreach(['fr'=>$fr] as $pref=>$lang) {
                            $str = iconv("CP1257","UTF-8", implode(str_ireplace($en, $lang, $output)));
                            file_put_contents(str_replace('/en/', "/$pref/", $link), $str);
                        }
                        // copy($link, ROOT."/fr.betagamers.net/$dir/$fullfilename");
                        // copy($link, ROOT."/es.betagamers.net/$dir/$fullfilename");
                        // copy($link, ROOT."/pt.betagamers.net/$dir/$fullfilename");
                        // copy($link, ROOT."/de.betagamers.net/$dir/$fullfilename");
                    }
                }
            }
        }
        echo 'copied successfully'; //doesn't exactly mean all files were copied to. Uncomment echo $filename.$day.'<br>'; to tell which files were copied and which ones weren't.
         //$this->convert;
        // show($games);
        // show($files);
    }

    function nogames() {
        date_default_timezone_set('Africa/Lagos');
        $this->page = $this->activepage = 'nogames';
        $data['page_title'] = $data['h1'] = 'No Games';
        $data['btntxt'] = 'MENU';
        $data['sidelist'] = $this->sidelist();
        $gamesclass = new Games;

        if(isset($_GET['sports']) && isset($_GET['showmessage'])) {
            $formdata = [
                ['sports'=>$gamesclass->validate_in_array($_GET['sports'], ALLSPORTS, fieldname:'sports'), 'showmessage'=>$gamesclass->validate_toggle($_GET['showmessage'], fieldname:'showmessage')],
                $gamesclass->err
            ];
            if(!isset($gamesclass->err)) {
                $datetod = date('Y-m-d', strtotime('today'));
                if($_GET['sports']=='football') {
                    $dir = 'table';
                    $tables = ['diamond', 'platinum', 'alpha'];
                }
                $sql = vsprintf(str_repeat("UPDATE %s SET expdate = expdate + interval 1 day;", count($tables)), $tables)."Insert into games (date, league) values ('$datetod', 'nogames')";
                $db = $gamesclass->custom_query($sql, 'update');
                if($db===true) {
                    $success = 'Updated Successfully';
                }
                if($_GET['showmessage']==1) {
                    array_push($gamesclass->gamesfocus, 'free.php');
                    foreach($gamesclass->gamesfocus as $filename) {
                        foreach(['public_html', 'fr.', 'es.', 'pt.', 'de.'] as $prefix) {
                            $domain = $prefix=='public_html' ? $prefix : $prefix.'betagamers.net';
                            file_put_contents(ROOT."/$domain/$dir/$filename.php", "");
                        }
                    }
                }
            }
        }
        
        $formfields = [
            ['tag'=>'select', 'name'=>"sports", 'options'=>['default_opt_'.($formdata[0]['sports'] ?? '')=>$formdata[0]['sports'] ?? null, ...array_combine(ALLSPORTS, ALLSPORTS)], 'error'=>$formdata[1]['sports'] ?? '', 'required'],
            ['tag'=>'select', 'name'=>"showmessage", 'options'=>['default_opt_'.($formdata[0]['showmessage'] ?? '')=>isset($formdata[0]['showmessage']) ? 'Yes' : null, 1=>'Yes', 0=>'No'], 'error'=>$formdata[1]['showmessage'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Update', 'error'=>''],
        ];

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        
        $data['formfields'] = $output;
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formerrors']['gen'] = $formdata[1]['gen'] ?? $generr ?? '';
        $data['formsuccess'] = $success ?? '';
        $this->view("folder/nogames",$data);
    }
    
    function dbclean() {
        $viptables = ['diamond', 'platinum', 'alpha', 'othersports'];
        foreach($viptables as $ind=>$val) {
            $recstable = DB_RECS_NAME.".$val".'rec';
            $tabquery[$recstable] = [
                $ind.'custom_query'=>["INSERT INTO $recstable (planid, fullName, email, phone, currency, amount, reg_date, expdate) SELECT id, fullName, email, phone, currency, amount, reg_date, expdate FROM $val  WHERE expdate <= NOW()"],
                $ind.'delete'=>[],
                $ind.'where'=>["expdate <= NOW()"],
            ];
        }
        $tabquery['users'] = [
            'delete'=>[],
            'where'=>["active=0 AND reg_date <= NOW() - INTERVAL 3 MONTH"],
        ];
        foreach(['games', 'freegames', 'odds'] as $ind=>$val) {
            $tabquery[$val] = [
                $ind.'delete'=>[],
                $ind.'where'=>["date <= NOW() - INTERVAL 3 MONTH"],
            ];
        }
        $gamesclass = new Games;
        $dbclean = $gamesclass->transaction($tabquery);
        // show($dbclean);
        echo 'dbclean finished';
    }

    function bookies() {
        if($_GET['action']=='view') {
            $this->page = $this->activepage = 'view_bookie';
            $data['page_title'] = $data['h1'] = 'View Bookie';
            $this->check_blueprint($data);
        } elseif($_GET['action']=='add') {
            $this->page = $this->activepage = 'add_bookie';
            $this->style = "h1{color:green; text-align:center}";
            $data['sidelist'] = $this->sidelist();

            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
                $bookiesclass = new Bookies;
                $bookiesclass->insertunique = ['bookie'];
                $formdata = $bookiesclass->validate($_POST);

                if(!$bookiesclass->err) {
                    if($bookiesclass->insert($formdata[0])===true) $success = 'Bookie successfully added';
                }
            }

            $formfields = [
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Bookie", 'name'=>"bookie", 'value'=>$formdata[0]['bookie'] ?? '', 'error'=>$formdata[1]['bookie'] ?? '', 'required'],
                ['tag'=>'textarea', 'style'=>'width: 100%', 'rows'=>'3', 'placeholder'=>"Description EN", 'name'=>"description_en", 'value'=>$formdata[0]['description_en'] ?? '', 'error'=>$formdata[1]['description_en'] ?? '', 'required'],
                ['tag'=>'textarea', 'style'=>'width: 100%', 'rows'=>'3', 'placeholder'=>"Description FR", 'name'=>"description_fr", 'value'=>$formdata[0]['description_fr'] ?? '', 'error'=>$formdata[1]['description_fr'] ?? '', 'required'],
                ['tag'=>'textarea', 'style'=>'width: 100%', 'rows'=>'3', 'placeholder'=>"Description ES", 'name'=>"description_es", 'value'=>$formdata[0]['description_es'] ?? '', 'error'=>$formdata[1]['description_es'] ?? '', 'required'],
                ['tag'=>'textarea', 'style'=>'width: 100%', 'rows'=>'3', 'placeholder'=>"Description PT", 'name'=>"description_pt", 'value'=>$formdata[0]['description_pt'] ?? '', 'error'=>$formdata[1]['description_pt'] ?? '', 'required'],
                ['tag'=>'textarea', 'style'=>'width: 100%', 'rows'=>'3', 'placeholder'=>"Description DE", 'name'=>"description_de", 'value'=>$formdata[0]['description_de'] ?? '', 'error'=>$formdata[1]['description_de'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Referral Link", 'name'=>"reflink", 'value'=>$formdata[0]['reflink'] ?? '', 'error'=>$formdata[1]['reflink'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Promo Code", 'name'=>"promocode", 'value'=>$formdata[0]['promocode'] ?? '', 'error'=>$formdata[1]['promocode'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Dashboard Link", 'name'=>"dashboard", 'value'=>$formdata[0]['dashboard'] ?? '', 'error'=>$formdata[1]['dashboard'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'text', 'placeholder'=>"Countries(NG, GH, KE)", 'name'=>"countries", 'value'=>$formdata[0]['countries'] ?? '', 'error'=>$formdata[1]['countries'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"active", 'options'=>['default_opt_'.($formdata[0]['active'] ?? '')=>$formdata[0]['active'] ?? null, 1=>'Yes', 0=>'No'], 'id'=>'active', 'error'=>$formdata[1]['active'] ?? '', 'required'],
                ['tag'=>'select', 'name'=>"homepage", 'options'=>['default_opt_'.($formdata[0]['homepage'] ?? '')=>$formdata[0]['homepage'] ?? null, 1=>'Yes', 0=>'No'], 'id'=>'homepage', 'error'=>$formdata[1]['homepage'] ?? '', 'required'],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>'Submit', 'error'=>''],
            ];
    
            $errs = array_column($formfields, 'error', 'name');
            $output = form_format($formfields);
            $data['page_title'] = $data['h1'] = 'Add Bookie';
            $data['btntxt'] = 'MENU';
            $data['formfields'] = $output;
            $data['formerrors'] = $errs ?? $formdata[1] ?? null;
            $data['formerrors']['gen'] = $formdata[1]['gen'] ?? '';
            $data['formsuccess'] = $success ?? '';
            $this->view("folder/insert",$data);
        } elseif($_GET['action']=='update') {
            $this->page = $this->activepage = 'update_bookie';
            $data['page_title'] = $data['h1'] = 'Update Bookie';
            $this->update_blueprint($data);
        } else {}

        $data['btntxt'] = 'MENU';
        $data['sidelist'] = $this->sidelist();
    }

    function download() {
        // show($_GET['fileid']);
        if(!isset($_GET['fileid'])) exit("Download couldn't start");
        $filters = [
            'fileid'=>['filter'=>FILTER_VALIDATE_INT, 'flags'=>FILTER_FORCE_ARRAY]
        ];
        $validids = array_filter(filter_input_array(INPUT_GET, $filters));
        $ids = array_values($validids['fileid']);
        if(!count($ids)) exit('Action could not be completed');
        $adminfilesclass = new Adminfiles;
        $tabquery['adminfiles'] = [
            'select'=>[
                'columns'=>'filename, folder'
            ],
            'where'=>[
                'whquery'=>'id in ('.implode(',', array_fill(0, count($ids), '?')).')',
                'wharray'=>$ids
            ],
            'custom_query'=>[
                'query'=>"INSERT INTO downloads (agentid, adminfilesid) SELECT ? as agentid, id as adminfilesid FROM adminfiles WHERE id in (".implode(',', array_fill(0, count($ids), '?')).')', 
                'querytype'=>'insert', 
                'queryvalues'=>[$_SESSION['users']['id'], ...$ids],
            ]
        ];
        $getfile = $adminfilesclass->transaction($tabquery);
        // var_dump($getfile);
        if(!$count = count($getfile['adminfiles']['where'])) exit('This file no longer exists or has been moved.');

        if($count>1) {
            $zipfile = zip(ROOT."/files/betagamers/work", ROOT."/files/betagamers/work.zip");
            if($zipfile!==true) {
                exit("Failed to prepare file for download");
            }
            $filelocation = ROOT."/files/betagamers/work.zip";
            download($filelocation, true);
        } else {
            extract($getfile['adminfiles']['where'][0]);
            $filelocation = ROOT."/files/betagamers/work/$folder/$filename";
            download($filelocation);
        }
    }
}