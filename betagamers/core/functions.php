<?php 
//app specific functions i.e functions for particular project different from general functions
function check_logged_in() {
    if(isset($_SESSION['users']['logged_in']) && $_SESSION['users']['logged_in'] === true){
        return true;
    } else {
        $_SESSION['redirectURL'] = htmlspecialchars($_SERVER['REQUEST_URI']);
        header("location: ".account_links('login'));
        exit;
    }
}

function check_subscriber($table) {
    check_logged_in();
    $agentclass = new Agent;
    $tableclass = new $table;
    $agent = $agentclass->select('email')->where("email = :email and (level='admin' OR level='agent')", ['email'=>$_SESSION['users']['email']]);

    $client = $tableclass->select('email')->where('email = :email', ['email'=>$_SESSION['users']['email']]);
    
    if((is_array($agent) && count($agent) > 0) || (is_array($client) && count($client) > 0)) {
        return true;
    }
}

function check_admin() {
    check_logged_in();
    $adminlevels = ['admin', 'agent', 'writer'];
    $adminclass = new Admin;
    $admindata = $adminclass->select('name, level')->where('email = :email', [':email'=>$_SESSION['users']['email']]);
    //show($admindata);exit;
    if(is_array($admindata) && count($admindata) && in_array($admindata[0]['level'], $adminlevels)) {
        return $admindata[0]['level'];
    }
    header("location: ".account_links('profile'));
    exit;
}

function btntext() {
    return match(LANG) {
        'fr'=>'MENU',
        default=>'MENU'
    };
}

function side_list_top() {
    switch (LANG) {
        case 'fr':
            $list = ['DÉCONNEXION', 'MON PROFIL | PAIEMENTS', 'S\'INSCRIRE', 'SE CONNECTER'];
            break;
        default:
            $list = ['LOGOUT', 'MY PROFILE / PAYMENTS', 'REGISTER', 'LOGIN'];
        break;
    }
    return array_combine(
        $list, [
            ['link'=>account_links('logout'), 'id'=>'on', 'country'=>null],
            ['link'=>account_links('profile'), 'id'=>'on', 'country'=>'profile'],
            ['link'=>account_links('register'), 'id'=>'off', 'country'=>null],
            ['link'=>account_links('login'), 'id'=>'off', 'country'=>null]
        ]
    );
}

function old_side_list_top() {
    switch (LANG) {
        case 'fr':
            $list = [
                'DÉCONNEXION'=>['link'=>'/compte/deconnecter', 'id'=>'on', 'country'=>null],
                'MON PROFIL | PAIEMENTS'=>['link'=>'/prono/profil', 'id'=>'on', 'country'=>'profile'],
                'S\'INSCRIRE'=>['link'=>'/compte/inscrire', 'id'=>'off', 'country'=>null],
                'SE CONNECTER'=>['link'=>'/compte/connecter', 'id'=>'off', 'country'=>null],
            ];
            break;
        
        default:
            $list = [
                'LOGOUT'=>['link'=>HOME.'/account/logout', 'id'=>'on', 'country'=>null],
                'MY PROFILE / PAYMENTS'=>['link'=>HOME.'/account/profile', 'id'=>'on', 'country'=>'profile'],
                'REGISTER'=>['link'=>HOME.'/account/register', 'id'=>'off', 'country'=>null],
                'LOGIN'=>['link'=>HOME.'/account/login', 'id'=>'off', 'country'=>null],
            ];
        break;
    }
    return $list;
}

function tips_sections() {
    $tipslist = tips_list('en');
    foreach($tipslist as $key=>$val) {
        if($key=='OVERVIEW' || $key=='FREE TIPS') {
            continue;
        }
        foreach($val as $subval) {
            $sections[strtolower($key)][] = $subval['id'];
        }
    }
    return $sections;
}

function get_odds_details($id) {
    $plans = plans();
    $tipslist = tips_list();
    // show($tipslist);
    foreach($tipslist as $key=>$val) {
        foreach($val as $subkey=>$subval) {
            if(isset($subval['id']) && $id==$subval['id']) {
            return ['header'=>$subkey, 'plan'=>$key, /*'planlang'=>LANG=='en' ? strtolower($key) : array_search(strtolower($key), $plans)*/];
            }
        }
    }
}

function category_numbers($game, $day='today') {
    $gamesclass = new Games;
    if($day == 'cur' || $day == 'prev') {
        $getdate = $gamesclass->select('date')->where("recent = '$day' limit 1");
        if(is_array($getdate) && count($getdate)) {
            $oftdate = $getdate[0]['date'];
        }
    }
    $oddsclass = new Odds;
    $oddscolumns = $oddsclass->showcolumns();
    if(in_array($game, $oddscolumns)) {
        $date = $oftdate ?? date('Y-m-d', strtotime($day));
        $getodds = $oddsclass->select($game)->where("date = '$date'");
        if(is_array($getodds) && count($getodds)) {
            $odds = (LANG == 'en') ? $getodds[0][$game] : str_replace('.', ',', $getodds[0][$game]);
            if($odds != 0) {
                return $odds;
            } else {
                return '...';
            }
        } else {
            return '...';
        }
    } else {
        return '...';
    }
}

function os_tips_list($sports='tennis') {}

function tips_list($lang=null) {
    $lang = $lang ?? LANG;
    $tips_list = [
        //'LOGOUT'=>['link'=>'/loginsystem/logout.php', 'id'=>'on_logout'],
        //'MY PROFILE | PAYMENTS'=>['link'=>'/tips/profile.php', 'id'=>'on_profile'],
        //'REGISTER'=>['link'=>'/loginsystem/mainregform.php', 'id'=>'off_register'],
        //'LOGIN'=>['link'=>'/loginsystem/mainlogin.php', 'id'=>'off_login'],
        'OVERVIEW'=>['link'=>tips_links(), 'id'=>'overview'],
        'FREE TIPS'=>['link'=>HOME, 'id'=>'free'],
        'ULTIMATE'=>
        [
            'ALPHA PICKS'=>['link'=>tips_links('ap'), 'id'=>'ap']
            ],
        'DIAMOND'=>
        [
            '5 ODDS'=>['link'=>tips_links('5odds'), 'id'=>'5odds'],
            '10 ODDS'=>['link'=>tips_links('10odds'), 'id'=>'10odds'],
            'DOUBLE CHANCE'=>['link'=>tips_links('dblchance'), 'id'=>'dblchance'],
            'OVER/UNDER'=>['link'=>tips_links('ovun'), 'id'=>'ovun'],
            'BTS'=>['link'=>tips_links('bts'), 'id'=>'bts'],
            'STRAIGHT WIN'=>['link'=>tips_links('straight'), 'id'=>'straight']
            ],
        'PLATINUM'=>
        [
            'SUPER SINGLE'=>['link'=>tips_links('single'), 'id'=>'single'],
            'SURE 2 ODDS'=>['link'=>tips_links('2odds'), 'id'=>'2odds'],
            '3 ODDS BANKER'=>['link'=>tips_links('3odds'), 'id'=>'3odds'],
            'DRAWS'=>['link'=>tips_links('draw'), 'id'=>'draw'],
            'CORRECT SCORES'=>['link'=>tips_links('cscore'), 'id'=>'cscore'],
            'PLAYERS TO SCORE'=>['link'=>tips_links('p2s'), 'id'=>'p2s'],
            'BIG ODDS'=>['link'=>tips_links('bigodds'), 'id'=>'bigodds'],
            'MEGA WEEKEND'=>['link'=>tips_links('weekend'), 'id'=>'weekend']
            ]
        ];
    
    if($lang != 'en') {
        $diamondsec = [
            ['en'=>'5 ODDS', 'fr'=>'5 COTES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'10 ODDS', 'fr'=>'10 COTES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'DOUBLE CHANCE', 'fr'=>'CHANCE DOUBLE', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'OVER/UNDER', 'fr'=>'PLUS / MOINS', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'BTS', 'fr'=>'BUT POUR LES 2 ÉQUIPES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'STRAIGHT WIN', 'fr'=>'VICTOIRE DIRECTE', 'es'=>'', 'pt'=>'', 'de'=>'']
        ];
        $platinumsec = [
            ['en'=>'SUPER SINGLE', 'fr'=>'SUPER SIMPLE', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'SURE 2 ODDS', 'fr'=>'SURE 2 COTES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'3 ODDS BANKER', 'fr'=>'3 COTES SÛRES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'DRAWS', 'fr'=>'MATCH NUL', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'CORRECT SCORES', 'fr'=>'SCORES EXACTS', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'PLAYERS TO SCORE', 'fr'=>'BUTEURS', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'BIG ODDS', 'fr'=>'COTES GRANDES', 'es'=>'', 'pt'=>'', 'de'=>''],
            ['en'=>'MEGA WEEKEND', 'fr'=>'PRÉVISION DE WEEK-END', 'es'=>'', 'pt'=>'', 'de'=>'']
        ];
        $ultimatesec = [
            ['en'=>'ALPHA PICKS', 'fr'=>'CHOIX ALPHA', 'es'=>'', 'pt'=>'', 'de'=>'']
        ];
    
        $ultimate = array_combine(array_column($ultimatesec, $lang), array_values($tips_list['ULTIMATE']));
        $diamond = array_combine(array_column($diamondsec, $lang), array_values($tips_list['DIAMOND']));
        $platinum = array_combine(array_column($platinumsec, $lang), array_values($tips_list['PLATINUM']));
        $sections = [
            ['fr'=>'APERÇU', 'sub'=>$tips_list['OVERVIEW']],
            ['fr'=>'CONSEILS GRATUITS', 'sub'=>$tips_list['FREE TIPS']],
            ['fr'=>'ULTIME', 'sub'=>$ultimate],
            ['fr'=>'DIAMANT', 'sub'=>$diamond],
            ['fr'=>'PLATINE', 'sub'=>$platinum]
        ];
    
        $tips_list = array_column($sections, 'sub', $lang);
    }
    return $tips_list;
}

function admin_side_list() {
    return $admin_side_list = [
        'CLIENTS'=>[
            'Check User'=>['link'=>HOME.'/folder/check', 'id'=>'check'],
            'Activate Subscription'=>['link'=>HOME.'/folder/activate', 'id'=>'activate'],
            'Update User'=>['link'=>HOME.'/folder/update', 'id'=>'update'],
            'Confirm Reg'=>['link'=>HOME.'/folder/confirmreg', 'id'=>'confirmreg'],
        ],
        'GAMES'=>[
            'VIP Games'=>['link'=>HOME.'/folder/vipgames', 'id'=>'vipgames'],
            'Free Games'=>['link'=>HOME.'/folder/freegames', 'id'=>'freegames'],
        ],
        'AGENTS'=>[
            'Add Agent'=>['link'=>HOME.'/folder/agents?action=add', 'id'=>'add_agent'],
            'View Agents'=>['link'=>HOME.'/folder/agents?action=view', 'id'=>'view_agent'], //agent link
            'Update Agent'=>['link'=>HOME.'/folder/agents?action=update', 'id'=>'update_agent'],
        ],
        'BOOKIES'=>[
            'Add Bookie'=>['link'=>HOME.'/folder/bookies?action=add', 'id'=>'add_bookie'],
            'View Bookie'=>['link'=>HOME.'/folder/bookies?action=view', 'id'=>'view_bookie'], //bookie landing page, affiliate dashboard
            'Update Bookie'=>['link'=>HOME.'/folder/bookies?action=update', 'id'=>'update_bookie'],
        ],
        'VIP GAMES RECORDS'=>[
            'Update Records'=>['link'=>HOME.'/folder/viprecords?action=update', 'id'=>'update_viprecords'],
            'View Records'=>['link'=>HOME.'/folder/viprecords?action=view', 'id'=>'view_viprecords']
        ],
        'FILES'=>[
            'Upload Files'=>['link'=>HOME.'/folder/adminfiles?action=update', 'id'=>'update_adminfiles'],//select Screenshots Or Admin Files Or Weekend Teams
            'View Admin Files'=>['link'=>HOME.'/folder/adminfiles?action=view', 'id'=>'view_adminfiles']
        ],
        'MISCELLANEOUS'=>[
            'No Games'=>['link'=>HOME.'/folder/nogames', 'id'=>'nogames'],
            'Salaries'=>['link'=>HOME.'/folder/#', 'id'=>'copy'],
            'Affiliates'=>['link'=>HOME.'/folder/#', 'id'=>'copy']
        ]
    ];
}

function sports() {
    $sports = match (LANG) {
        'fr' => ['football'=>'Football', 'tennis'=>'Tennis'],
        default => ['football'=>'Football', 'tennis'=>'Tennis'],
    };
    return $sports;
}

function plans(array $specific=[]) {
    $allplans = [
        'en'=>['ultimate', 'platinum', 'diamond', 'tennis vip'],
        'fr'=>['ultime', 'platine', 'diamant', 'vip tennis']
    ];
    $plans = array_combine($allplans['en'], $allplans[LANG]);
    if(count($specific)) return array_intersect_key($plans, array_flip($specific));
    return $plans;
}

function plan_features($sports) {
    switch (LANG) {
        case 'fr':
            $features = [
                'football'=>[
                    'PLAN GRATUIT'=>['id'=>'free', 'features'=>['Gratuit pendant 1 semaine, 1 mois, 3 mois, 6 mois, 1 an','Pas de gestion des risques','Accès aux conseils gratuits quotidiens']],
                    'PLAN DIAMANT'=>['id'=>'diamond', 'features'=>['Forfaits 1 semaine, 1 mois, 3 mois, 6 mois et 1 an','Accès à 5 cotes','Accès à 10 cotes','Accès à victoire directe','Accès à Double Chance','Accès aux deux équipes pour marquer','Accès aux plus/moins buts']],
                    'PLAN PLATINE'=>['id'=>'platinum', 'features'=>['Forfaits 1 semaine, 1 mois, 3 mois, 6 mois et 1 an','Accès au plan diamant','Access à super simple','Accès à 2 cotes sûres','Accès à 3 cotes sûres','Accès à match nul','Accès à score exact','Accès aux joueurs pour marquer','Accès aux prévisions du week-end','Accès à de grosses cotes']],
                    'PLAN ULTIME'=>['id'=>'ultimate', 'features'=>['Forfaits 3 jours, 7 jours et 12 jours','Accès aux choix quotidiens les plus sûrs (choix alpha)']],
                    'COMBO ARGENT'=>['id'=>'combosil', 'features'=>['Accès au plan ultime de 3 jours','Accès au plan platine 1 semaine']],
                    'COMBO OR'=>['id'=>'combogol', 'features'=>['Accès au plan ultime de 7 jours (choix alpha)','Accès au plan platine 1 mois']],
                    'COMBO PRO'=>['id'=>'combopro', 'features'=>['Accès au plan ultime 1 mois (choix alpha)','Accès au plan platine 1 mois']]
                ],
                'tennis'=>[
                    'VIP TENNIS'=>['id'=>'tennis', 'features'=>['Plan 1 mois','Access à simple','Accès à 2 cotes','Accès à 3 cotes','Accès à 5 cotes','Accès à 10 cotes','Accès à 1-2','Accès à la prédiction de sét (Scores Exacts)','Accès aux plus / moins']],
                    'COMBO SPORTIF'=>['id'=>'combospo', 'features'=>['Accès à 1 mois de tennis VIP','Accès au forfait Platine Football d\'un mois']],
                ]
            ];
            break;

        default:
        $features = [
            'football'=>[
                'FREE PLAN'=>['id'=>'free', 'features'=>['Free for 1 week, 1 month, 3 months, 6 months, 1 year','No Risk Management','Access to the Daily Free Tips']],
                'DIAMOND PLAN'=>['id'=>'diamond', 'features'=>['1 week, 1 month, 3 months, 6 months, 1 year plans','Access to 5 Odds Combo','Access to 10 Odds Combo','Access to Straight Win','Access to Double Chance','Access to Over/Under','Access to Both Teams to Score']],
                'PLATINUM PLAN'=>['id'=>'platinum', 'features'=>['1 week, 1 month, 3 months, 6 months, 1 year plans','Access to Diamond Plan','Access to Super Single','Access to 2 Odds Banker','Access to 3 Odds Banker','Access to Draw','Access to Correct Score','Access to Players to Score','Access to Mega Weekends','Access to Big Odds']],
                'ULTIMATE PLAN'=>['id'=>'ultimate', 'features'=>['3 Days, 7 Days and 12 Days Plans','Access to Daily Surest Picks(Alpha Picks)']],
                'COMBO SILVER'=>['id'=>'combosil', 'features'=>['Access to 3 Days Ultimate Plan (Alpha Picks)','Access to 1 Week Platinum Plan']],
                'COMBO GOLD'=>['id'=>'combogol', 'features'=>['Access to 7 Days Ultimate Plan (Alpha Picks)','Access to 1 Month Platinum Plan']],
                'COMBO PRO'=>['id'=>'combopro', 'features'=>['Access to 1 Month Ultimate Plan (Alpha Picks)','Access to 1 Month Platinum Plan']]
            ],
            'tennis'=>[
                'TENNIS VIP'=>['id'=>'tennis', 'features'=>['1 month plan','Access to Single','Access to 2 Odds','Access to 3 Odds','Access to 5 Odds','Access to 10 Odds','Access to 1-2','Access to Set Bets (Correct Scores)','Access to Over/Under Sets']],
                'SPORTS COMBO'=>['id'=>'football tennis', 'features'=>['Access to 1 Month Tennis VIP','Access to 1 Month Football Platinum Plan']]
            ],
        ];
            break;
    }
    return $features[$sports];
}

function single_price($plan, string|int $duration, $currency=null) {
    $pricing = plan_pricing($plan, $currency);
    if(is_int($duration)) {
        $prices = array_values($pricing);
        return $prices[$duration] ?? $prices[0];
    }
    return $pricing[$duration];
}

function plan_pricing($plan, $currency=null, $lang=null) {
    $pricing = [
        'free'=>[['en'=>'Free', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>'', 'price'=>0, 'description'=>'']],
        'diamond'=> [
            ['en'=>'1 Week', 'fr'=>'1 semaine', 'es'=>'1 Semana', 'pt'=>'1 Semana', 'de'=>'Eine Woche', 'price'=>1500, 'description'=>'Diamond 1 Week', 'link'=>'diam1Week'],
            ['en'=>'1 Month', 'fr'=>'1 mois', 'es'=>'1 Mes', 'pt'=>'1 Mês', 'de'=>'Ein Monat', 'price'=>3000, 'description'=>'Diamond 1 Month', 'link'=>'diam1Month'],
            ['en'=>'3 Months', 'fr'=>'3 mois', 'es'=>'3 Meses', 'pt'=>'3 Mêses', 'de'=>'Drei Monate', 'price'=>8000, 'description'=>'Diamond 3 Months', 'link'=>'diam3Months'],
            ['en'=>'6 Months', 'fr'=>'6 mois', 'es'=>'6 Meses', 'pt'=>'6 Mêses', 'de'=>'Sechs Monate', 'price'=>16000, 'description'=>'Diamond 6 Months', 'link'=>'diam6Months'],
            ['en'=>'1 Year', 'fr'=>'1 an', 'es'=>'1 Año', 'pt'=>'1 Ano', 'de'=>'Ein Jahr', 'price'=>30000, 'description'=>'Diamond 1 Year', 'link'=>'diam1Year']
            ],
        
        'platinum'=> [
            ['en'=>'1 Week', 'fr'=>'1 semaine', 'es'=>'1 Semana', 'pt'=>'1 Semana', 'de'=>'Eine Woche', 'price'=>2000, 'description'=>'Platinum 1 Week', 'link'=>'plat1Week'],
            ['en'=>'1 Month', 'fr'=>'1 mois', 'es'=>'1 Mes', 'pt'=>'1 Mês', 'de'=>'Ein Monat', 'price'=>5000, 'description'=>'Platinum 1 Month', 'link'=>'plat1Month'],
            ['en'=>'3 Months', 'fr'=>'3 mois', 'es'=>'3 Meses', 'pt'=>'3 Mêses', 'de'=>'Drei Monate', 'price'=>12000, 'description'=>'Platinum 3 Months', 'link'=>'plat3Months'],
            ['en'=>'6 Months', 'fr'=>'6 mois', 'es'=>'6 Meses', 'pt'=>'6 Mêses', 'de'=>'Sechs Monate', 'price'=>24000, 'description'=>'Platinum 6 Months', 'link'=>'plat6Months'],
            ['en'=>'1 Year', 'fr'=>'1 an', 'es'=>'1 Año', 'pt'=>'1 Ano', 'de'=>'Ein Jahr', 'price'=>45000, 'description'=>'Platinum 1 Year', 'link'=>'plat1Year']
            ],
        
        'ultimate'=> [
            ['en'=>'3 Days', 'fr'=>'3 journées', 'es'=>'3 Días', 'pt'=>'3 Dias', 'de'=>'3 Tage', 'price'=>4000, 'description'=>'Ultimate 3 Days', 'link'=>'ult3Days'],
            ['en'=>'7 Days', 'fr'=>'7 journées', 'es'=>'7 Días', 'pt'=>'7 Dias', 'de'=>'7 Tage', 'price'=>7000, 'description'=>'Ultimate 7 Days', 'link'=>'ult7Days'],
            ['en'=>'12 Days', 'fr'=>'12 journées', 'es'=>'12 Días', 'pt'=>'12 Dias', 'de'=>'12 Tage', 'price'=>10000, 'description'=>'Ultimate 12 Days', 'link'=>'ult12Days']
            ],
        
        'combo'=> [
            ['en'=>'Combo Silver', 'fr'=>'Combo Argent', 'es'=>'Combo Plata', 'pt'=>'Combo Prata', 'de'=>'Combo Silber', 'price'=>5000, 'description'=>'Combo Silver', 'link'=>'combosilver'],
            ['en'=>'Combo Gold', 'fr'=>'Combo Or', 'es'=>'Combo Oro', 'pt'=>'Combo Ouro', 'de'=>'Combo Gold', 'price'=>10000, 'description'=>'Combo Gold', 'link'=>'combogold'],
            ['en'=>'Combo Pro', 'fr'=>'Combo Pro', 'es'=>'Combo Pro', 'pt'=>'Combo Pro', 'de'=>'Combo Pro', 'price'=>20000, 'description'=>'Combo Pro', 'link'=>'combopro']
            ],

        'combosil'=>[['en'=>'Combo Silver', 'fr'=>'Combo Argent', 'es'=>'Combo Plata', 'pt'=>'Combo Prata', 'de'=>'Combo Silber', 'price'=>5000, 'description'=>'Combo Silver', 'link'=>'combosilver']],
        'combogol'=>[['en'=>'Combo Gold', 'fr'=>'Combo Or', 'es'=>'Combo Oro', 'pt'=>'Combo Ouro', 'de'=>'Combo Gold', 'price'=>10000, 'description'=>'Combo Gold', 'link'=>'combogold']],
        'combopro'=>[['en'=>'Combo Pro', 'fr'=>'Combo Pro', 'es'=>'Combo Pro', 'pt'=>'Combo Pro', 'de'=>'Combo Pro', 'price'=>20000, 'description'=>'Combo Pro', 'link'=>'combopro']],
        
        
        'tennis'=> [
            ['en'=>'1 Month', 'fr'=>'1 mois', 'es'=>'1 Mes', 'pt'=>'1 Mês', 'de'=>'Ein Monat', 'price'=>3000, 'description'=>'Tennis 1 Month', 'link'=>'ten1Month']
            ],
        
        'football tennis'=> [
            ['en'=>'1 Month', 'fr'=>'1 mois', 'es'=>'1 Mes', 'pt'=>'1 Mês', 'de'=>'Ein Monat', 'price'=>7000, 'description'=>'Football Tennis 1 Month', 'link'=>'footten1Month']
            ]
        ];

    $pricelist = array_column($pricing[$plan], 'price', $lang ?? LANG);
    $descriptions = array_column($pricing[$plan], 'description', $lang ?? LANG);
    $currency = $currency ?? currencies(USER_COUNTRY)['currency'];
    $curcheck = $currency=='eur' || $currency=='usd' || $currency=='gbp';
    $rate = rate($currency);
    foreach($pricelist as $key=>$val) {
        $plainprice = round($val*$rate, $curcheck ? 2 : 0);
        $price = number_format($plainprice, $curcheck ? 2 : 0, LANG=='en' ? '.' : ',', LANG=='en' ? ',' : '.');
        $pricelist[$key]=['price'=>$price, 'plainprice'=>$plainprice, 'description'=>$descriptions[$key]];
        if(DISCOUNT) {
            $plaindiscount = round($plainprice*DISCOUNT, $curcheck ? 2 : 0);
            $discount = number_format($plainprice*DISCOUNT, $curcheck ? 2 : 0, LANG=='en' ? '.' : ',', LANG=='en' ? ',' : '.');
            $pricelist[$key]=['price'=>$price, 'discount'=>$discount, 'plaindiscount'=>$plaindiscount, 'description'=>$descriptions[$key]];
        }
    }
    return $pricelist; 
    /*
    returns ['1 week'=>['price'=>1,500, 'plainprice'=>1500, 'description'=>'Diamond 1 Week']] or ['1 week'=>['price'=>1,500, 'plainprice'=>1500, 'discount'=>1000]];
    ['Como Silver'=>['price'=>5,000, 'plainprice'=>5000, 'description'=>'Como Silver']];
    */
    //return array_column($pricing[$plan]['price'], $pricing[$plan], $lang ?? LANG);
    //return array_column('price', $pricing[$plan], $lang ?? LANG);
}

function rate($cur='all') {
    $rate = [
        'cdf'=> 5,
        'eur'=> 0.0024,
        'gbp'=> 0.0021,
        'ghs'=> 0.02,
        'kes'=> 0.29333,
        'mwk'=> 2.4,
        'ngn'=> 1,
        'rwf'=> 2.5,
        'tzs'=> 5.4,
        'ugx'=> 8.4,
        'usd'=> 0.0025,
        'xof'=> 1.6,
        'zar'=> 0.042,
        'zmw'=> 0.046,
        ];
    if($cur=='all') return array_keys($rate);
    return array_key_exists($cur, $rate) ? $rate[$cur] : $rate['usd'];
}

function currencies($coucur) { //$coucur: 2 digit country, 3 digit currency, single: currency, cur_sign, link
    //dropped single, use currencies($coucur)['currency'] instead;
    $curdetails = [
        ['country'=>'CD', 'currency'=>'cdf', 'cur_sign'=>'FC ', 'link'=>'view_prices?id=cdf'],
        ['country'=>'GB', 'currency'=>'gbp', 'cur_sign'=>'&#163;', 'link'=>'rave?id=gbp'],
        ['country'=>'GH', 'currency'=>'ghs', 'cur_sign'=>'GH&#8373;', 'link'=>'rave?id=ghs'],
        ['country'=>'KE', 'currency'=>'kes', 'cur_sign'=>'Ksh ', 'link'=>'rave?id=kes'],
        ['country'=>'LS', 'currency'=>'zar', 'cur_sign'=>'R ', 'link'=>'mukuru?id=zar'],
        ['country'=>'MW', 'currency'=>'mwk', 'cur_sign'=>'K ', 'link'=>'rave?id=mwk'],
        ['country'=>'NG', 'currency'=>'ngn', 'cur_sign'=>'&#8358;', 'link'=>'paystack'],
        ['country'=>'RW', 'currency'=>'rwf', 'cur_sign'=>'R&#8355;', 'link'=>'rave?id=rwf'],
        ['country'=>'TZ', 'currency'=>'tzs', 'cur_sign'=>'Tsh ', 'link'=>'rave?id=tzs'],
        ['country'=>'UG', 'currency'=>'ugx', 'cur_sign'=>'Ush ', 'link'=>'rave?id=ugx'],
        ['country'=>'US', 'currency'=>'usd', 'cur_sign'=>'&#36;', 'link'=>'rave?id=usd'],
        ['country'=>'ZA', 'currency'=>'zar', 'cur_sign'=>'R ', 'link'=>'rave?id=zar'],
        ['country'=>'ZM', 'currency'=>'zmw', 'cur_sign'=>'ZK ', 'link'=>'rave?id=zmw'],
        ['country'=>'ZW', 'currency'=>'usd', 'cur_sign'=>'&#36;', 'link'=>'mukuru?id=usd']
    ];
    $eur = ['AT', 'BE', 'CY', 'EE', 'FI', 'FR', 'DE', 'GR', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PT', 'SK', 'SI', 'ES', 'AD', 'MC', 'SM', 'VA'];
    $xof = ['BF', 'BJ', 'CG', 'CI', 'CM', 'GA', 'ML', 'NE', 'SN'];
    $count = count($curdetails);
    foreach($eur as $val) {
        $curdetails[$count] = ['country'=>$val, 'currency'=>'eur', 'cur_sign'=>'&#8364;', 'link'=>'rave?id=eur'];
        $count++;
    }
    foreach($xof as $val) {
        $curdetails[$count] = ['country'=>$val, 'currency'=>'xof', 'cur_sign'=>'CFA ', 'link'=>'rave?id=xof'];
        $count++;
    }
    $countries = array_column($curdetails, 'country');
    $currencies = array_column($curdetails, 'currency');
    $strlen = strlen($coucur);
    if($strlen==2) {
        $ind = array_search(strtoupper($coucur), $countries);
    } elseif($strlen==3) {
        $ind = array_search($coucur, $currencies);
    }
    if(!isset($ind) || $ind===false) {
        $ind = array_search('usd', $currencies);
    }
    // return $single ? $curdetails[$ind][$single] : $curdetails[$ind];
    return $curdetails[$ind];
}

function bank_details(array $bank) {
    $details = [
        ['en'=>'ACCOUNT NAME', 'fr'=>'NOM DU COMPTE', 'es'=>'NOMBRE DE LA CUENTA', 'pt'=>'NOME DA CONTA', 'de'=>'KONTONAME', 'data'=>$bank['name'] ?? null],
        ['en'=>'ACCOUNT NUMBER', 'fr'=>'NUMÉRO DE COMPTE', 'es'=>'NÚMERO DE CUENTA', 'pt'=>'NÚMERO DA CONTA', 'de'=>'KONTONUMMER', 'data'=>$bank['number'] ?? null],
        ['en'=>'BANK', 'fr'=>'BANQUE', 'es'=>'BANCO', 'pt'=>'BANCO', 'de'=>'BANK', 'data'=>$bank['bank'] ?? null],
        ['en'=>'ACCOUNT TYPE', 'fr'=>'TYPE DE COMPTE', 'es'=>'TIPO DE CUENTA', 'pt'=>'TIPO DE CONTA', 'de'=>'KONTO TYP', 'data'=>$bank['type'] ?? null],
        ['en'=>'BRANCH CODE', 'fr'=>'CODE DE LA SUCCURSALE', 'es'=>'CÓDIGO DE SUCURSAL', 'pt'=>'CÓDIGO DA AGÊNCIA', 'de'=>'BRANCHENCODE', 'data'=>$bank['branchcode'] ?? null],
        ['en'=>'HelloPaisa Unique Reference Number', 'fr'=>'Numéro de référence unique HelloPaisa', 'es'=>'Número de referencia único de HelloPaisa', 'pt'=>'Número de Referência Exclusivo HelloPaisa', 'de'=>'Eindeutige HelloPaisa-Referenznummer', 'data'=>$bank['hellopaisaunique'] ?? null]
    ];
    $bankdetails = array_filter(array_column($details, 'data', LANG));
    foreach($bankdetails as $key=>$val) {
        $output[] = "$key: $val";
    }
    return $output;
}

function all_payment_methods() {
    switch(LANG) {
        case 'en':
            $bank = 'Direct Transfers (Bank, Mobile or ATM)';
            $cards = 'Cards';
            $diff_countries = 'Different Countries';
            $crypto = 'Cryptocurrency';
            $direct_tran = 'Direct Transfers';
            $other_tran = 'Other Transfers';
            $etc = 'etc';
        break;
        case 'fr':
            $bank = 'Transferts directs (bancaires, mobiles ou ATM)';
            $cards = 'Carte';
            $diff_countries = 'différents pays';
            $crypto = 'Crypto-monnaie';
            $direct_tran = 'Transferts directs';
            $other_tran = 'Autres transferts';
            $etc = 'etc.';
        break;
        case 'es':
            $bank = 'Transferencias Directas (Banco, Móvil o Cajero Automático)';
            $cards = 'Tarjetas';
            $diff_countries = 'diferentes países';
            $crypto = 'Criptomoneda';
            $direct_tran = 'Transferencias Directas';
            $other_tran = 'Otras Transferencias';
            $etc = 'etc';
        break;
        case 'pt':
            $bank = 'Transferências diretas (banco, celular ou caixa eletrônico)';
            $cards = 'Cartões';
            $diff_countries = 'Países diferentes';
            $crypto = 'Criptografia';
            $direct_tran = 'Transferências diretas';
            $other_tran = 'Outras transferências';
            $etc = 'etc';
        break;
        case 'de':
            $bank = 'Direktüberweisungen (Bank, Handy oder Geldautomat)';
            $cards = 'Karten';
            $diff_countries = 'Verschiedene Länder';
            $crypto = 'Kryptowährung';
            $direct_tran = 'Direktüberweisungen';
            $other_tran = 'Andere Überweisungen';
            $etc = 'etc';
        break;
        default:
            $bank = $cards = $diff_countries = $crypto = $direct_tran = $other_tran = $etc = '';
    }
    return [
        $bank,
        $cards,
        "MPESA",
        "Mobile Money ($diff_countries)",
        "PayPal",
        "Skrill",
        "Neteller",
        $crypto,
        "$direct_tran (WorldRemit, Transferwise $etc)",
        "$other_tran (Western Union, Monegram, Ria $etc)"
    ];
}

function all_versions() {
    return [
        'en'=>'https://betagamers.net',
		'fr'=>'https://fr.betagamers.net',
		'es'=>'https://es.betagamers.net',
		'pt'=>'https://pt.betagamers.net',
		'de'=>'https://de.betagamers.net',
    ];
}
    
function controller_translations($controller) { //folders
    $list = [
		'account'=>['en'=>'account', 'fr'=>'compte', 'es'=>'', 'pt'=>'', 'de'=>''],
		'bookmakers'=>['en'=>'bookmakers', 'fr'=>'bookmakers', 'es'=>'', 'pt'=>'', 'de'=>''],
        'free_predictions'=>['en'=>'free_predictions', 'fr'=>'pronostics_gratuits', 'es'=>'', 'pt'=>'', 'de'=>''],
        'payments'=>['en'=>'payments', 'fr'=>'paiements', 'es'=>'', 'pt'=>'', 'de'=>''],
        //requests, because of mailer and otp
        'requests'=>['en'=>'requests', 'fr'=>'demandes', 'es'=>'', 'pt'=>'', 'de'=>''],
		'support'=>['en'=>'support', 'fr'=>'soutien', 'es'=>'apoyo', 'pt'=>'', 'de'=>''],
		'tips'=>['en'=>'tips', 'fr'=>'prono', 'es'=>'vip', 'pt'=>'', 'de'=>''],
	];
    return $controller=='all' ? $list : $list[$controller];
}

function directory_listing($controller) {
    $list = [
        'account'=>[
            'auth'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'auth'),
            'forgot'=>['en'=>'forgot', 'fr'=>'oublie'],
            'login'=>['en'=>'login', 'fr'=>'connecter'],
            'logout'=>['en'=>'logout', 'fr'=>'deconnecter'],
            'profile'=>['en'=>'profile', 'fr'=>'profil'],
            'register'=>['en'=>'register', 'fr'=>'inscrire'],
            'reset'=>['en'=>'reset', 'fr'=>'reinitialiser'],
            'verify'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'verify'),
        ],
        'free_predictions'=>[
            'epl'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'epl'),
            'laliga'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'laliga'),
            'bundesliga'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'bundesliga'),
            'ligue1'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'ligue1'),
            'seriea'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'seriea'),
            'ucl'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'ucl'),
            'europa'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'europa'),
            'euro'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'euro'),
            'afcon'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'afcon'),
            'teams'=>['en'=>'teams', 'fr'=>'equipes', 'es'=>'', 'pt'=>'', 'de'=>''],
            'howtopredict'=>['en'=>'howtopredict', 'fr'=>'comment_predire', 'es'=>'', 'pt'=>'', 'de'=>''],
            'guide'=>['en'=>'guide', 'fr'=>'guider', 'es'=>'', 'pt'=>'', 'de'=>''],
        ],
        'payments'=>[
            'rave'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'rave'),
            'mukuru'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'mukuru'),
            'paystack'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'paystack'),
            'paypal'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'paypal'),
            'coinbase'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'coinbase'),
            'system'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'system'),
            'statusrave'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'statusrave'),
            'statuspsk'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'statuspsk'),
            'statuscb'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'statuscb'),
            'skrill'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'skrill'),
            'sticpay'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'sticpay'),
            'astropay'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'astropay'),
            'chippercash'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'chippercash'),
            'failed'=>['en'=>'failed', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>''],
            'pending'=>['en'=>'pending', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>''],
            'success'=>['en'=>'success', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>''],
            'topup'=>['en'=>'topup', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>''],
            'view_prices'=>['en'=>'view_prices', 'fr'=>'', 'es'=>'', 'pt'=>'', 'de'=>''],
        ],
        'support'=>[
            'aboutus'=>['en'=>'aboutus', 'fr'=>'proposnous', 'es'=>'', 'pt'=>'', 'de'=>''],
            'faqs'=>['en'=>'faqs', 'fr'=>'faqs', 'es'=>'', 'pt'=>'', 'de'=>''],
            'howitworks'=>['en'=>'howitworks', 'fr'=>'fonctionne', 'es'=>'', 'pt'=>'', 'de'=>''],
            'jobs'=>['en'=>'jobs', 'fr'=>'emploi', 'es'=>'', 'pt'=>'', 'de'=>''],
            'mailus'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'mailus'),
            'prices'=>['en'=>'prices', 'fr'=>'prix', 'es'=>'', 'pt'=>'', 'de'=>''],
            'privacy'=>['en'=>'privacy', 'fr'=>'confidentialite', 'es'=>'', 'pt'=>'', 'de'=>''],
            'terms'=>['en'=>'terms', 'fr'=>'fonctionne', 'es'=>'', 'pt'=>'', 'de'=>''],
        ],
        'tips'=>[
            'wins'=>['en'=>'wins', 'fr'=>'tickets_gagnant', 'es'=>'', 'pt'=>'', 'de'=>''],
            'vip'=>array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'vip'),
        ],
    ];
    return $list[$controller];
}

function pay_links($suffix=''){
    return HOME.'/'.controller_translations('payments')[LANG].($suffix ? "/$suffix" : '');
}
    
function old_pay_links($suffix=''){
    $link = match(LANG){
    'en'=>'/payments/'.$suffix,
    'fr'=>'/paiements/'.$suffix,
    'es'=>'/pagos/'.$suffix,
    'pt'=>'/pagamentos/'.$suffix,
    'de'=>'/zahlungen/'.$suffix,
    default=>''
    };
    return HOME.$link;
}
    
function support_links($page='', $arrayformat=false){
    $pages = directory_listing('support');
    if(array_key_exists($page, $pages) || $page=='') {
        $suffix = $pages[$page][LANG] ?? ''; //$suffix = $pages[$page][LANG] ?? ''
        if($arrayformat===false) {
            return HOME.'/'.controller_translations('support')[LANG].($suffix ? "/$suffix" : '');
        } else {
            foreach(all_versions() as $key=>$val) {
                $link[$key] = "$val/".controller_translations('support')[$key].($page=='' ? '' : '/'.directory_listing('support')[$page][$key]);
            }
            return $link;
        }
    }
}

function account_links($page='') {
    $pages = directory_listing('account');
    if(array_key_exists($page, $pages)) {
        $suffix = $pages[$page][LANG]; //$suffix = $pages[$page][LANG] ?? ''
        return HOME.'/'.controller_translations('account')[LANG]."/$suffix";
    }
}

function tips_links($page='', $arrayformat=false) {
    $pages = directory_listing('tips');
    if(array_key_exists($page, $pages) || $page=='') {
        $suffix = $pages[$page][LANG] ?? ''; //$suffix = $pages[$page][LANG] ?? ''
        if($arrayformat===false) {
            return HOME.'/'.controller_translations('tips')[LANG].($suffix ? "/$suffix" : '');
        } else {
            foreach(all_versions() as $key=>$val) {
                $link[$key] = "$val/".controller_translations('tips')[$key].($page=='' ? '' : '/'.directory_listing('tips')[$page][$key]);
            }
            return $link;
        }
    } else {
        return HOME.'/'.controller_translations('tips')[LANG].'/'.directory_listing('tips')['vip'][LANG]."?odds=$page";
    }
}

function free_games_link($page='', $arrayformat=false) {
    $pages = directory_listing('free_predictions');
    if(array_key_exists($page, $pages) || $page=='') {
        $suffix = $pages[$page][LANG] ?? ''; //$suffix = $pages[$page][LANG] ?? ''
        if($arrayformat===false) {
            return HOME.'/'.controller_translations('free_predictions')[LANG].($suffix ? "/$suffix" : '');
        } else {
            foreach(all_versions() as $key=>$val) {
                $link[$key] = "$val/".controller_translations('free_predictions')[$key].($page=='' ? '' : '/'.directory_listing('free_predictions')[$page][$key]);
            }
            return $link;
        }
    }
}

function bookies_link($page='', $arrayformat=false) {
    if($arrayformat===false) {
        return HOME.'/'.controller_translations('bookmakers')[LANG];
    } else {
        foreach(all_versions() as $key=>$val) {
            $link[$key] = "$val/".controller_translations('bookmakers')[$key];
        }
        return $link;
    }
}

function error_page() {
    http_response_code(404);
    include ROOT.'/'.(LANG=='en' ? 'public_html' : LANG.'.betagamers.net').'/404.php';
    exit();
}

function payment_table_headers($length=3) {
    $headers = match (LANG) {
        'fr'=>['Durée', 'Prix', 'Option'],
        'es'=>['Duración', 'Precio', 'Opción'],
        'pt'=>['Duração', 'Preço', 'Opção'],
        'de'=>['Dauer', 'Preis', 'Option'],
        default => ['Duration', 'Price', 'Option'],
    };
    return $length<3 ? array_slice($headers, 0, $length) : $headers;
}

function related_posts(array $posts) {
    if(LANG == 'en') {
        $allposts = [
        'epl'=>[
            'alt'=>'EPL Logo',
            'text'=>'Premier League Predictions',
            'index'=>'Premier League Predictions and Results'
            ],
        'laliga'=>[
            'alt'=>'Spanish Laliga Logo',
            'text'=>'LaLiga Predictions',
            'index'=>'LaLiga Predictions and Results'
            ],
        'seriea'=>[
            'alt'=>'Italian Serie A Logo',
            'text'=>'Serie A Predictions',
            'index'=>'Serie A Predictions and Results'
            ], 
        'bundesliga'=>[
            'alt'=>'Bundesliga Logo',
            'text'=>'Bundesliga Predictions',
            'index'=>'Bundesliga Predictions and Results'
            ], 
        'ligue1'=>[
            'alt'=>'French Ligue 1 Logo',
            'text'=>'Ligue 1 Predictions',
            'index'=>'Ligue 1 Predictions and Results'
            ], 
        'ucl'=>[
            'alt'=>'UCL Logo',
            'text'=>'Champions League Predictions',
            'index'=>'Champions League Predictions and Results'
            ], 
        'europa'=>[
            'alt'=>'Europa League Logo',
            'text'=>'Europa League Predictions',
            'index'=>'Europa League Predictions and Results'
            ], 
        'teams'=>[
            'alt'=>'Top Teams to bet on',
            'text'=>'Best Predictions for the Weekend',
            'index'=>'Top Ten Good Teams to Bet on this Weekend'
            ], 
        'predict'=>[
            'alt'=>'Predicting Football Matches Correctly',
            'text'=>'How to predict football matches accurately',
            'index'=>'How to Predict Football Matches Correctly',
            'filename'=>'howtopredict',
            ], 
        'euro'=>[
            'alt'=>'UEFA Euro Logo',
            'text'=>'European Championship Predictions',
            'index'=>'European Championship (EURO) Predictions and Results'
            ],
        'afcon'=>[
            'alt'=>'Afcon Logo',
            'text'=>'African Nations Cup Predictions',
            'index'=>'African Nations Cup Predictions and Results'
            ],
        'guide'=>[
            'alt'=>'Common Terms used in FootBall Betting',
            'text'=>'Betting Symbols for Beginners',
            'index'=>'Betting Guide for Beginners'
            ],
        'tennisguide'=>[
            'filename'=>'/tennis/free_predictions/tennisguide',
            'alt'=>'Tennis',
            'text'=>'Beginner\'s Guide to Tennis Markets'
            ]
        ];
    } elseif($this->lang == 'fr') {
        $allposts = [
        'epl'=>[
            'alt'=>'Logo EPL',
            'text'=>'Pronostic Premier League',
            'index'=>'Prédictions et résultats de Premier League'
            ],
        'laliga'=>[
            'alt'=>'Logo de la Liga espagnole',
            'text'=>'Pronostic Liga Espagnol',
            'index'=>'Prédictions et résultats de la Liga'
            ], 
        'bundesliga'=>[
            'alt'=>'logo de la bundesliga allemande',
            'text'=>'Pronostic Bundesliga',
            'index'=>'Prédictions et résultats de la Bundesliga'
            ],
        'seriea'=>[
            'alt'=>'Logo de la Serie A italienne',
            'text'=>'Pronostic Serie A',
            'index'=>'Pronostics et résultats Serie A'
            ], 
        'ligue1'=>[
            'alt'=>'Logo de la Ligue 1 française',
            'text'=>'Pronostic Ligue 1',
            'index'=>'Pronostics et résultats de Ligue 1'
            ], 
        'ucl'=>[
            'alt'=>'Logo de l\'UEFA Champions League',
            'text'=>'Pronostic Ligue des Champions',
            'index'=>'Prédictions et résultats de la Ligue des champions'
            ], 
        'europa'=>[
            'alt'=>'Logo de l\'UEFA Europa League',
            'text'=>'Pronostic de la Ligue Europa',
            'index'=>'Prédictions et résultats de la Ligue Europa'
            ], 
        'teams'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ], 
        'predict'=>[
            'filename'=>'comment_predire',
            'alt'=>'Prédire correctement les matchs de football',
            'text'=>'Comment prédire les matchs de football avec précision',
            'index'=>'Comment prédire correctement les matchs de football'
            ], 
        'euro'=>[
            'alt'=>'Logo euro',
            'text'=>'Pronostics Championnat d\'Europe',
            'index'=>'Pronostics et résultats de l\'Euro de l\'UEFA'
            ], 
        'afcon'=>[
            'alt'=>'Logo afcon',
            'text'=>'Pronostics Coupe d\'Afrique des nations',
            'index'=>'Prédictions et résultats de la Coupe d\'Afrique des Nations'
            ],
        'guide'=>[
            'filename'=>'guider',
            'alt'=>'termes dans les paris sur le football',
            'text'=>'Guide de paris pour les débutants'
            ],
        'tennisguide'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ]
        ];
    } elseif($this->lang == 'es') {
        $allposts = [
        'epl'=>[
            'alt'=>'Logo de EPL',
            'text'=>'Pronosticos EPL',
            'index'=>'Pronosticos y resultados de EPL'
            ],
        'laliga'=>[
            'alt'=>'Logo de La Liga española',
            'text'=>'Pronosticos La Liga',
            'index'=>'Pronosticos y resultados de La Liga'
            ], 
        'bundesliga'=>[
            'alt'=>'Logo de la Bundesliga alemana',
            'text'=>'Pronosticos Bundesliga',
            'index'=>'Pronosticos y resultados de Bundesliga'
            ],
        'seriea'=>[
            'alt'=>'Logo de la Serie A italiana',
            'text'=>'Pronosticos Serie A',
            'index'=>'Pronosticos y resultados de la Serie A'
            ], 
        'ligue1'=>[
            'alt'=>'Logo de la Ligue 1 francesa',
            'text'=>'Pronosticos Ligue 1',
            'index'=>'Pronosticos y resultados de la Ligue 1'
            ], 
        'ucl'=>[
            'alt'=>'Logo de la Liga de Campeones de la UEFA',
            'text'=>'Pronosticos Champions League',
            'index'=>'Pronosticos y resultados de Champions League'
            ], 
        'europa'=>[
            'alt'=>'Logo de la liga europea',
            'text'=>'Pronosticos Europa League',
            'index'=>'Pronosticos  y resultados de Europa League'
            ], 
        'teams'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ], 
        'predict'=>[
            'filename'=>'como_predecir',
            'alt'=>'Predecir partidos de fútbol correctamente',
            'text'=>'Cómo predecir partidos de fútbol con precisión',
            'index'=>'Cómo predecir con precisión los partidos de fútbol'
            ], 
        'euro'=>[
            'alt'=>'Logo de Euro de UEFA',
            'text'=>'Pronosticos del Campeonato de Europa',
            'index'=>'Pronosticos y resultados de Campeonato de Europa (EURO)'
            ], 
        'afcon'=>[
            'alt'=>'Logo de AFCON',
            'text'=>'Pronosticos de la Copa Africana de Naciones',
            'index'=>'Pronosticos y resultados de la Copa Africana de Naciones'
            ],
        'guide'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ],
        ];
    } elseif($this->lang == 'pt') {
        $allposts = [
        'epl'=>[
            'alt'=>'Logo do EPL',
            'text'=>'Previsões da Premier League',
            'index'=>'Prognósticos e resultados da Premier League'
            ],
        'laliga'=>[
            'alt'=>'Logo da Laliga Espanhola',
            'text'=>'Previsões da La Liga',
            'index'=>'Prognósticos e resultados da La Liga Espanhola'
            ], 
        'bundesliga'=>[
            'alt'=>'Logo da Bundesliga',
            'text'=>'Previsões da Bundesliga',
            'index'=>'Prognósticos e resultados da Bundesliga'
            ],
        'seriea'=>[
            'alt'=>'Logo da Série A italiana',
            'text'=>'Previsões da Série A',
            'index'=>'Prognósticos e resultados da Serie A Italiana'
            ], 
        'ligue1'=>[
            'alt'=>'Logo da Ligue 1 Francesa',
            'text'=>'Previsões da Ligue 1',
            'index'=>'Prognósticos e resultados da Ligue 1 Francesa'
            ], 
        'ucl'=>[
            'alt'=>'Logo do UCL',
            'text'=>'Previsões da Liga dos Campeões',
            'index'=>'Prognósticos e resultados da Liga dos Campeões'
            ], 
        'europa'=>[
            'alt'=>'Logo da Liga Europa',
            'text'=>'Previsões da Liga Europa',
            'index'=>'Prognósticos e resultados da Liga Europa'
            ], 
        'teams'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ], 
        'predict'=>[
            'filename'=>'como_prever',
            'alt'=>'Prevendo partidas de futebol corretamente',
            'text'=>'Como prever partidas de futebol com precisão',
            'index'=>'Como prever partidas de futebol corretamente'
            ], 
        'euro'=>[
            'alt'=>'Logo da UEFA Euro',
            'text'=>'Prognósticos do Campeonato Europeu',
            'index'=>'Prognósticos e Resultados do Campeonato Europeu (EURO)'
            ], 
        'afcon'=>[
            'alt'=>'Logo da afcon',
            'text'=>'Prognósticos da Copa das Nações Africanas',
            'index'=>'Prognósticos e resultados da AFCON'
            ],
        'guide'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ],
        ];
    } elseif($this->lang == 'de') {
        $allposts = [
        'epl'=>[
            'alt'=>'EPL-Logo',
            'text'=>'Premier League Prognosen',
            'index'=>'Prognosen und Ergebnisse der Premier League'
            ],
        'laliga'=>[
            'alt'=>'Logo der spanischen LaLiga',
            'text'=>'LaLiga Prognosen',
            'index'=>'La Liga Prognosen und Ergebnisse'
            ], 
        'bundesliga'=>[
            'alt'=>'Bundesliga-Logo',
            'text'=>'Bundesliga Prognosen',
            'index'=>'Bundesliga Prognosen und Ergebnisse'
            ],
        'seriea'=>[
            'alt'=>'Logo der italienischen Serie A',
            'text'=>'Serie A Prognosen',
            'index'=>'Prognosen und Ergebnisse der Serie A'
            ], 
        'ligue1'=>[
            'alt'=>'Logo der französischen Ligue 1',
            'text'=>'Ligue 1 Prognosen',
            'index'=>'Prognosen und Ergebnisse der Ligue 1'
            ], 
        'ucl'=>[
            'alt'=>'UCL-Logo',
            'text'=>'Champions League Prognosen',
            'index'=>'Prognosen und Ergebnisse der Champions League'
            ], 
        'europa'=>[
            'alt'=>'Logo der Europa League',
            'text'=>'Europa League Prognosen',
            'index'=>'Prognosen und Ergebnisse der Europa League'
            ], 
        'teams'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ], 
        'predict'=>[
            'filename'=>'vorhersagen',
            'alt'=>'Fußballspiele richtig vorhersagen',
            'text'=>'Wie man Fußballspiele genau vorhersagt',
            'index'=>'Wie man Fußballspiele richtig vorhersagt'
            ], 
        'euro'=>[
            'alt'=>'UEFA Euro-Logo',
            'text'=>'Prognosen zur Europameisterschaft',
            'index'=>'EURO Prognosen und Ergebnisse'
            ], 
        'afcon'=>[
            'alt'=>'Afcon-Logo',
            'text'=>'Prognosen zum Afrikanischen Nationenpokal',
            'index'=>'Prognosen zum Afrikanischen Nationenpokal and Results'
            ],
        'guide'=>[
            'filename'=>'',
            'alt'=>'',
            'text'=>''
            ],
        ];
    } else {}
    foreach($posts as $val) {
        $relatedposts[$val] = $allposts[$val];
    }
    return $relatedposts;
}

function format_number($number) {
    return match (LANG) {
        'en' => number_format($number, 2, '.', ','),
        default => number_format($number, 2, ',', '.'),
    };
}

function tag_format($str, array $links=[]) {
    //## link, ** bold, __ italic
    $bold = '/\*([\pL\d@]+\s*\.*\/*[ \pL\d]+)\*/ui';
    $italic = '/_([\pL\d@]+\s*\.*\/*[ \pL\d]+)_/ui';
    $patterns = [$bold, $italic];
    $replace = ['<b>$1</b>', '<i>$1</i>'];
    $str = preg_replace($patterns, $replace, $str);
    if(count($links)) {
        /*$str = preg_replace_callback('/\#([\pL\d]+(?>\s*\.*@*[\pL\d]+)*)#/ui',*/
        $str = preg_replace_callback('/#([\pL\d]+(?>\s*\.*@*[\pL\d\(\)]+)*)#/ui',
        /*$str = preg_replace_callback('/#([\w]+(?>[^\#]*[\w"\<\/i\>"]+)*)#/ui',*/
        function ($matches) use($links) {
            static $ind = -1;
            $ind++;
            $temp = "<a";
            foreach($links[$ind] as $key=>$val) {
                $temp .= " $key='$val'";
            }
            return $temp.">".$matches[1]."</a>";
            //$ind++;
            //undefined array key error means number of elements in $links is not equal to the number of regexp matches.
            //return sprintf("<a href='".$links[$ind]['href']."'>".$matches[1]."</a>", $ind++);
            //return sprintf("<a href='".$links[$ind]['href']."'".(isset($links[$ind]['style']) ? ' style='.$links[$ind]['style'] : '').(isset($links[$ind]['target']) ? ' target='.$links[$ind]['target'] : '').">".$matches[1]."</a>", $ind++);
        }, $str);
    }
    // echo $str;
    return $str;
    //([\pL\d]+\s*\.*@*[\pL\d]+)+ matches _two words_, here, _test string abcdq_, it matches only test string (two words again)
    //the ?gt simply merges as many as the latter to the former. so instead of matching just explicitly 2(former + latter) that passed the criteria, it matches as many as possible (former + as many latter as possible) that passed the criteria
}

function writeup_format($data) {
    //show($data);
    //try working with array_walk_recursive
    static $writeup = '';
    foreach($data as $key=>$val) {

        if(is_array($val) && !array_is_list($val)) {
            // if($key=='ul') {
            //     $writeup .= '<ul>';
            // }
            return writeup_format($val);

        } else {
            // if($key=='ul') {
            //     $writeup .= '<ul>';
            //     //return writeup_format($val);
            // }
            if(str_starts_with_number($key)) {
                $key = trim_starting_number($key);
            }
            
            if(str_contains($key, ' class')) {
                list($tag, $class) = explode(' ', $key, 2);
                $writeup .= "<$tag $class>".(is_array($val) ? implode("</$tag><$tag>", $val) : $val)."</$tag>";
            } else {
                $writeup .= "<$key>".(is_array($val) ? implode("</$key><$key>", $val) : $val)."</$key>";
            }
        }
    }



    // foreach($data as $val) {
    //     foreach($val as $subkey=>$subval) {
    //         if(str_contains($subkey, ' class')) {
    //             list($tag, $class) = explode(' ', $subkey, 2);
    //             $writeup[] = "<$tag $class>".(is_array($subval) ? implode("</$tag><$tag>", $subval) : $subval)."</$tag>";
    //         } else {
    //             $writeup[] = "<$subkey>".(is_array($subval) ? implode("</$subkey><$subkey>", $subval) : $subval)."</$subkey>";
    //         }
    //     }
    // }
    //echo $writeup;
    $output = $writeup;
    $writeup = $ul = '';
    return $output ?? null;
}

function sub_ul_format(array $subul) {
    return $subul[0].'<ul><li>'.implode('</li><li>', $subul[1]).'</li></ul>';
}

function ul_format(array $ul) {
    return '<li>'.implode('</li><li>', $ul['li']).'</li>';
}

function writeup_format_old($data) {
    //show($data);
    //try working with array_walk_recursive
    static $writeup = '';
    foreach($data as $key=>$val) {
        if(is_array($val)) {
            foreach($val as $subkey=>$subval) {
                if(is_numeric($subkey)) {
                    if(str_contains($key, ' class')) {
                        list($tag, $class) = explode(' ', $key, 2);
                        $writeup .= "<$tag $class>".(is_array($subval) ? implode("</$tag><$tag>", $subval) : $subval)."</$tag>";
                    } else {
                        $writeup .= "<$key>".(is_array($subval) ? implode("</$key><$key>", $subval) : $subval)."</$key>";
                    }
                } else {
                    return writeup_format($val);
                }
            }
            // if($key=='ul') {

            // }
            // return writeup_format($val);

        } else {
            if(str_contains($key, ' class')) {
                list($tag, $class) = explode(' ', $key, 2);
                $writeup .= "<$tag $class>".(is_array($val) ? implode("</$tag><$tag>", $val) : $val)."</$tag>";
            } else {
                $writeup .= "<$key>".(is_array($val) ? implode("</$key><$key>", $val) : $val)."</$key>";
            }
        }
    }



    // foreach($data as $val) {
    //     foreach($val as $subkey=>$subval) {
    //         if(str_contains($subkey, ' class')) {
    //             list($tag, $class) = explode(' ', $subkey, 2);
    //             $writeup[] = "<$tag $class>".(is_array($subval) ? implode("</$tag><$tag>", $subval) : $subval)."</$tag>";
    //         } else {
    //             $writeup[] = "<$subkey>".(is_array($subval) ? implode("</$subkey><$subkey>", $subval) : $subval)."</$subkey>";
    //         }
    //     }
    // }
    return $writeup ?? null;
}

function nogames($extra=false) {
    $extra = $extra===true ? match(LANG) {
        'fr'=>'Tous les abonnements sont toujours intacts.',
        'es'=>'Todas las suscripciones siguen intactas.',
        'pt'=>'Todas as assinaturas ainda estão intactas.',
        'de'=>'Alle Abonnements sind noch intakt.',
        default=>'All Subscriptions are still in tact.'
    } : '';
    return [
        'yes'=>match(LANG) {
            'fr'=>'Aucun jeu ici pour le jour sélectionné.',
            'es'=>'No hay juegos aquí para el día seleccionado.',
            'pt'=>'Não há jogos aqui para o dia selecionado.',
            'de'=>'Keine Spiele für den ausgewählten Tag hier.',
            default=>'No Games Here for the Selected Day.',
        }." $extra",
        ''=>match(LANG) {
            'fr'=>'Pas de jeux ici pour aujourd\'hui.',
            'es'=>'No hay juegos aquí por hoy.',
            'pt'=>'Não há jogos aqui por hoje.',
            'de'=>'Keine Spiele hier für heute.',
            default => 'No Games Here for Today.',
        }." $extra",
        'tom'=>match(LANG) {
            'fr'=>'Pas encore de jeux ici. Revenez plus tard.',
            'es'=>'No hay juegos aquí todavía. Vuelva más tarde.',
            'pt'=>'Ainda não há jogos aqui. Volte mais tarde.',
            'de'=>'Noch keine Spiele hier. Komme später wieder.',
            default=>'No Games here Yet. Check back later.',
        },
    ];
}

function tab_names(array $tabkeys=[]){
    $tab_names = match(LANG) {
        'fr'=>['yes'=>'Hier', ''=>'Aujourd\'hui', 'tom'=>'Avenir'],
        'es'=>['yes'=>'Ayer', ''=>'Hoy', 'tom'=>'Próximos'],
        'pt'=>['yes'=>'Ontem', ''=>'Hoje', 'tom'=>'Próximo'],
        'de'=>['yes'=>'Gestern', ''=>'Heute', 'tom'=>'Bevorstehende'],
        default=>['yes'=>'Yesterday', ''=>'Today', 'tom'=>'Upcoming']
    };
    return array_intersect_key($tab_names, array_flip($tabkeys));
}

function wknd_tab_names(array $tabkeys=[]){
    $tab_names = match(LANG) {
        'fr'=>['yes'=>'Week-end dernier', ''=>'Ce week-end', 'tom'=>'Le week-end prochain'],
        'es'=>['yes'=>'Fin de semana pasado', ''=>'Este fin de semana', 'tom'=>'Próximo fin de semana'],
        'pt'=>['yes'=>'Fim de semana anterior', ''=>'Este fim de semana', 'tom'=>'Próximo fim de semana'],
        'de'=>['yes'=>'Dieses Wochenende', ''=>'Vorheriges Wochenende', 'tom'=>'Nächstes Wochenende'],
        default=>['yes'=>'Last Weekend', ''=>'This Weekend', 'tom'=>'Next Weekend']
    };
    return array_intersect_key($tab_names, array_flip($tabkeys));
}

function free_tab_names(array $tabkeys=[]){
    $tab_names = match(LANG) {
        'fr'=>['yes'=>'Hier', ''=>'Aujourd\'hui', 'tom'=>'Avenir'],
        'es'=>['yes'=>'Ayer', ''=>'Hoy', 'tom'=>'Próximos'],
        'pt'=>['yes'=>'Ontem', ''=>'Hoje', 'tom'=>'Próximo'],
        'de'=>['yes'=>'Gestern', ''=>'Heute', 'tom'=>'Bevorstehende'],
        default=>['yes'=>'Previous', ''=>'Current', 'tom'=>'Upcoming']
    };
    return array_intersect_key($tab_names, array_flip($tabkeys));
}

function set_table_header($odd=''){
    $head['en'] = ['DATE', 'LEAGUE', 'FIXTURE', 'TIP', 'RESULT'];
    $head['fr'] = ['DATE', 'LIGUE', 'MATCH', 'CONSEIL', 'RÉSULTAT'];
    $head['es'] = ['Fecha', 'Liga', 'Partido', 'Consejo', 'Res'];
    $head['pt'] = ['DATA', 'LIGA', 'PARTIDA', 'DICA', 'RESULT'];
    $head['de'] = ['DATUM', 'LIGA', 'DAS', 'TIPP', 'ERGEBNIS'];
    
    $theader = match($odd){
        'free'=>['LEAGUE', 'FIXTURE', 'TIP', 'RESULT'],
        'popular'=>['LEAGUE', 'FIXTURE', 'TIP'],
        'upcoming'=>['DATE', 'LEAGUE', 'FIXTURE', 'TIP'],
        default=>['DATE', 'LEAGUE', 'FIXTURE', 'TIP', 'RESULT']
    };
    
    return $table_header = (LANG == 'en') ? $theader : str_ireplace($head['en'], $head[LANG], $theader);
}

function display_games(array $tabs, string $odd, array $totalodds=[], $extras='', $mode='vip') {
    if($mode=='vip') {
        $th = set_table_header($odd);
        if($odd != 'free' && $odd != 'ape') {
            $header = get_odds_details($odd)['header'];
            $set2 = "</table><br><br><h2>$header 2</h2><table><tr><th>".implode('</th><th>', $th)."</th></tr>";
            $set3 = "</table><br><br><h2>$header 3</h2><table><tr><th>".implode('</th><th>', $th)."</th></tr>";
        }
    }?>
    <div class="w3-center">
        <div class="w3-bar w3-white"><?php
            foreach($tabs as $key=>$val) {?>
                <span class="w3-bar-item w3-btn tablinks w3-hover-none <?=($key=='') ? 'w3-green' : ''?>"><?=$val?></span><?php
            }?>
        </div>
    </div><?php
    if($odd == 'free') {echo '<br>';}
    foreach($tabs as $key=>$val) {?>
        <div class="tabscroll tabcontent" <?=($key != '') ? 'style="display:none"' : '' ?> ><?php
        if($mode=='vip') {?>
            <table>
                <tr><th><?=implode('</th><th>', $th)?></th></tr><?php
                include $fullpath = ROOT."/app/betagamers/incs/table/".LANG."/$key$odd.php";
                ?>
            </table><?php
            if(trim(file_get_contents($fullpath))== "") {
                $gamesclass = new Games;
                $nogames = nogames(in_array($odd, $gamesclass->gamesfocus) ? true : false);
                echo '<p>'.$nogames[$key].'</p>';
            }
            if(isset($totalodds[$key])) echo '<p>*'.$totalodds[$key].'</p>';
        } else {
            include $fullpath = ROOT."/app/betagamers/incs/free_predicts/".LANG."/$key$odd.php";
        }?>
        </div>
        <?php
    }
    echo "<p><i>$extras</i></p>";

    // foreach($tabs as $key=>$val) {}
}

function setlocaledate($strtotime, $pattern='') {
    switch(LANG) {
        case 'fr':
            $locale = 'fr_FR';
            $timezone = 'Africa/Lagos';
            break;
        case 'es':
            $locale = 'es_ES';
            $timezone = 'Europe/Madrid';
            break;
        case 'pt':
            $locale = 'pt_BR';
            $timezone = 'America/Sao_Paulo';
            break;
        case 'de':
            $locale = 'de_DE';
            $timezone = 'Europe/Berlin';
            break;
        default:
            $locale = 'en_GB';
            $timezone = 'Africa/Lagos';
            break;
    }
    $fmt = new IntlDateFormatter(
        $locale,
        IntlDateFormatter::FULL, //$dateType FULL, LONG, MEDIUM, SHORT, NONE
        IntlDateFormatter::NONE, //$timeType
        $timezone,
        IntlDateFormatter::GREGORIAN, //Calendar type
        $pattern //'d/m/y' //https://unicode-org.github.io/icu/userguide/format_parse/datetime/
    );
    return $fmt->format($strtotime);
}

function filemodify($mtime) {
    $lastupdated = match(LANG) {
        'fr'=>'Dernière mise à jour',
        'es'=>'Última actualización',
        'pt'=>'Ultima atualização',
        'de'=>'Zuletzt aktualisiert',
        default=>'Last Updated'
    };
    
    return "$lastupdated: " . setlocaledate($mtime);
}