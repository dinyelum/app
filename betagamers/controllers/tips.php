<?php
class Tips extends Controller {
    function sidelist() {
        include ROOT."/app/betagamers/incs/menutips.php";
        return $sidelist;
    }

    private function urls($custom='') {
        $this->urls = tips_links($this->page ?? $custom, true);
    }

    function index() {
        $this->urls(); //when $this->page hasn't been set, so that parameter=''
        $marksclass = new Marks;
        $tabquery = [
            'marks'=>[
                'custom_query'=>[
                    "SELECT date, games, mark, percent, best FROM marks where games='ap' and date=(select max(date) from marks)
                    union all
                    SELECT date, games, mark, percent, best FROM (
                        SELECT date, games, mark, percent, best, ROW_NUMBER() OVER(PARTITION BY games ORDER BY date desc ) AS RN FROM marks where games in ('single', '2odds', '3odds') ORDER BY FIND_IN_SET(games, 'single,2odds,3odds'), date desc
                    ) sub WHERE RN <= 4"
                ],
                '1custom_query'=>["select date, mark, games from marks where games=(SELECT games FROM marks where  best!='' order by date desc limit 1) and date LIKE concat((SELECT best FROM marks where  best!=''  order by date desc limit 1), '%') order by date"]
            ],
            'odds'=>[
                'custom_query'=>["select totalodds from odds where games='bigodds' and date=curdate();"]
            ],
            'screenshots'=>[
                'custom_query'=>[
                    "SELECT date, img_src FROM screenshots where lang='".LANG."' order by date desc limit 10"
                ]
            ]
        ];
        $marksclass = new Marks;
        $db = $marksclass->transaction($tabquery);

        if(count($db['marks']['custom_query'])) {
            foreach($db['marks']['custom_query'] as $val) { //just to make getting the percents easier, otherwise just like in admin/marks, marks, odds and date can be formatted directly from here
                $sections[$val['games']][] = $val;
            }
            foreach($sections as $key=>$val) {
                foreach($val as $ind=>$subval) {
                    if($ind==0) {
                        $percent[$key] = ($subval['percent'] > 50 ? format_number($subval['percent']) : format_number(50)).'%';
                        //$percent[$key] = $subval['percent'];
                    }
                }
                if($key=='ap') continue;
                $marksarr = array_column($val, 'mark', 'date');
                $secmarks = '';
                foreach($marksarr as $mkey=>$mval) {
                    list($mark, $size, $color) = explode(',', $mval);
                    $date = date('d/m/Y', strtotime($mkey));
                    $secmarks .= "<div class='w3-col s6 w3-padding-top'><br>".$marksclass->fa_fa_mark($mark, '76px', $color, $date)."</div>";
                }
                $marks[$key] = $secmarks;
            }
            // arsort($percent);
            // show($percent);
        }

        if(is_array($db['marks']['1custom_query']) && count($db['marks']['1custom_query']) && ($strtotime =strtotime($db['marks']['1custom_query'][0]['date']))>0) {
            $marksarr = array_column($db['marks']['1custom_query'], 'mark', 'date');
            $bestmarks = '';
            foreach($marksarr as $mkey=>$mval) {
                list($mark, $size, $color) = explode(',', $mval);
                $date = date('d', strtotime($mkey));
                $bestmarks .= "<div class='w3-col s2 w3-padding-top'><br>".$marksclass->fa_fa_mark($mark, '30px', $color, $date)."</div>";
            }
            // $odd = $db['marks']['1custom_query'][0]['games'];
            $besttext = 'Betagamers '.$marksclass->set_games()[$db['marks']['1custom_query'][0]['games']];
            $bestmonth = setlocaledate($strtotime, 'MMMM');
            // var_dump($bestmonth);
        }

        $bigodds = isset($db['odds']['custom_query'][0]['totalodds']) ? (format_number($db['odds']['custom_query'][0]['totalodds']) ?: '...') : '...';
        
        $screenshots = is_array($db['screenshots']['custom_query']) ? $db['screenshots']['custom_query'] : [];

        $this->page = $this->activepage = 'tips';
		$this->metabots = 'index, follow';
        $this->tags = true;
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, victors predict';
            $this->description = 'Best paid vip tips. Get access to premium quality daily vip tips prediction';
            $this->og = [
                'title'=>'Best Vip Tips',
                'description'=>'Get access to the best quality vip tips prediction daily',
                'imagetype'=>'image/jpg'
            ];
            $data['page_title'] = "Best Vip Tips";
            $prompts= ['Register', 'Pricing', 'Subscribe'];
            $bigoddsh = 'BIG ODDS';
            $bigoddst = 'Big Odds Prediction';
            $bigoddsp = 'View Now';
            $wins = ['VIP Won Tickets', 'vip bet won ticket', 'More'];
            $bestmthheader = isset($bestmonth) ? "BEST VIP IN ".strtoupper($bestmonth) : '';
            $tracker = ['Accuracy Tracker (Last 20 Days)', ['TIP', 'ACCURACY'], $percent ?? []];
        } elseif(LANG=='fr') {
            $data['page_title'] = "Meilleur site pour les pronostics gratuits et vip de football";
            $this->description = 'Meilleur site pour les pronostics gratuits et vip de football. Accédez aux prévisions les plus précises et réelles pour aujourd\'hui et chaque week-end';
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, fr.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, victors predict';
            $this->og = [
                'title'=>'Meilleurs pronos VIP',
                'description'=>'Accédez quotidiennement aux meilleures prédictions de conseils vip',
                'imagetype'=>'image/jpg'
            ];
            $prompts= ['S\'inscrire', 'Les Prix', 'Abonnez-vous'];
            $bigoddsh = 'COTES GRANDES';
            $bigoddst = 'Pronos du Grandes Cotes';
            $bigoddsp = 'Voir maintenant';
            $wins = ['Billets VIP gagnés', 'pari VIP gagné ticket', 'Voir le plus'];
            $bestmthheader = isset($bestmonth) ? "MEILLEUR VIP EN ".strtoupper($bestmonth) : '';
            $tracker = ['Traqueur de précision (Les 20 jours précédents)', ['CONSEIL', 'PRÉCISION'], $percent ?? []];
        }
        $this->style = ".content a {color: green;text-decoration: underline;}.content p {text-align: justify;}@font-face {font-family: 'Font Awesome';font-style: normal;src: url('/webfonts/fa-solid-900.woff2') format('woff2');font-display: swap;}@font-face {font-family: 'tawkwidget';font-style: normal;src: url('https://static-v.tawk.to/a-v3-47/fonts/tawk-widget.ttf?yh9epr')format('ttf');font-display: swap;}";
        $this->og['url'] = $this->urls[LANG];
        $this->og['image'] = $this->urls[LANG].'/images/bgslide1x.jpg';
        $data['sidelist'] = $this->sidelist();
        $data['games'] = $marksclass->set_games();
        $data['marks'] = $marks ?? [];
        $data['prompts'] = array_combine(['reg', 'price', 'sub'], $prompts);
        $data['bigodds'] = ['header'=>$bigoddsh, 'text'=>$bigoddst, 'odds'=>$bigodds, 'prompt'=>$bigoddsp];
        $data['screenshots'] = $screenshots;
        $data['wins'] = array_combine(['header', 'alt', 'prompt'], $wins);
        $data['bestmarks'] = ['header'=>$bestmthheader ?? '', 'text'=>$besttext ?? '', 'marks'=>$bestmarks ?? ''];
        $data['tracker'] = array_combine(['header', 'th', 'percent'], $tracker);
        $this->view("tips/index",$data);
    }

    function wins() {
        $screenshotsclass = new Adminfiles;
        $screenshotsclass::$table = 'screenshots';
        $db = $screenshotsclass->select('date, img_src')->where("lang='".LANG."' and date >= (select min(date) from (
            select distinct date from screenshots order by date desc limit 5) min10) order by date desc");
        
        if(count($db)) {
            foreach($db as $val) {
                $screenshots[$val['date']][] = $val;
            }
        } else {
            $screenshots = [];
        }

        $this->page = $this->activepage = 'wins';
        $this->urls();
        if(LANG=='en') {
            $this->keywords = 'won bet tickets, won bet slips, winning tickets';
            $this->description = 'View the recently won bet slips on betagamers';
            $title = "Won Bet Tickets";
            $alt = 'winning bet slips';
        } elseif(LANG=='fr') {
            $title = "Tickets Gagnant</titl";
            $this->description = 'gagné des billets de pari, billets de pari gagnés, les tickets gagnant';
            $this->keywords = 'Voir les bulletins de paris récemment gagnés sur Betagamers';
            $alt = 'bulletins de paris gagnants';
        }
        $data['page_title'] = $data['h1'] = $title;
        $data['screenshots'] = $screenshots;
        $data['alt'] = $alt;
        $this->view("tips/wins",$data);
    }

    function vip() {
        if(LANG=='en') {
            $apeheader = 'ALPHA PICKS EXTRA';
            $totaloddstxt = 'Total: ... Odds';
            $putalltxt = 'DO NOT Put All in One Ticket';
            $subdiam = "Please Subscribe to atleast the #Diamond Plan# to view this content. Thanks.";
            $subplat = "Please Subscribe to the #Platinum Plan# to view this content. Thanks.";
            $subalpha = "Please Subscribe to the #Ultimate Plan (Alpha Picks)# to view this content. Thanks.";
        } elseif(LANG=='fr') {
            $apeheader = 'CHOIX ALPHA SUPPLÉMENTAIRE';
            $totaloddstxt = 'Total: ... Cotes';
            $putalltxt = 'Ne mettez pas tout dans un seul ticket';
            $subdiam = "Veuillez vous abonner au moins au #forfait diamant# pour voir ce contenu. Je vous remercie.";
            $subplat = "Veuillez vous abonner au #forfait platine# pour voir ce contenu. Je vous remercie.";
            $subalpha = "Veuillez vous abonner au #forfait ultime (Alpha Picks)# pour voir ce contenu. Je vous remercie.";
        }
        $nosub = ['diamond'=>$subdiam, 'platinum'=>$subplat, 'ultimate'=>$subalpha];
        if(isset($_GET['odds'])) {
            $odds = $_GET['odds'];
            $this->page = $this->activepage = $odds;
            //$sections = tips_sections();
            //$section = array_search($_GET['odds'], $sections);
            $oddsdetail = get_odds_details($_GET['odds']);
            // show($oddsdetail);
            if($oddsdetail) {
                $title = ucwords(strtolower($h2 = $oddsdetail['header']));
                $subscriber = check_subscriber($oddsdetail['plan']);
                if($subscriber===true) {
                    $oddsclass = new Odds;
                    $dbodds = $oddsclass->select(
                        "(case 
                        when date=DATE_SUB(curdate(), INTERVAL 1 DAY) then 'yes' 
                        when date=DATE_ADD(curdate(), INTERVAL 1 DAY) then 'tom' 
                        else '' 
                        end) as date, totalodds"
                    )->where("games=:games and date between DATE_SUB(curdate(), INTERVAL 1 DAY) and DATE_ADD(curdate(), INTERVAL 1 DAY)", ['games'=>$odds]);
                    // show($dbodds);
                    if(is_array($dbodds) && count($dbodds) && $odds!='ap') {
                        foreach($dbodds as $ind=>$val) {
                            $totalodds[$val['date']] = str_replace('...', format_number($val['totalodds']), $totaloddstxt);
                        }
                    }
                    $gamesclass = new Games;
                    $tabs = $odds=='weekend' ? wknd_tab_names(['yes', '']) : (in_array($odds, $gamesclass->gamesfocus) ? tab_names(['yes', '']) : tab_names(['yes', '', 'tom']));
                    // $oddsarr = glob(INCS."/table/".LANG."/*$odds.php");
                    //$dates = $odds=='weekend' ? ['prev', 'cur', 'Tomorrow'] : ['Yesterday', 'Today', 'Tomorrow'];
                    // $specialarr = ['ap', 'single', '2odds', '3odds', '5odds', '10odds'];
                    $putallarr = ['dblchance', 'ovun', 'bts', 'straight', 'draw', 'cscore', 'p2s'];
                    // $totaloddsarr = ['weekend', 'bigodds'];
                    if(in_array($odds, $putallarr)) {
                        $putall = "*$putalltxt";
                    }
                    // if(in_array($odds, $totaloddsarr)) {
                    //     $this->totalodds = true;
                    //     $data['totalodds'] = "*$totalodds";
                    // }
                    // if(in_array($odds, $specialarr)) {
                    //     $data['nogames'] = [$nogamesubyes, $nogamesubtod, $nogamestom];
                    // }
                } else {
                    $data['nosub'] = $nosub[strtolower($oddsdetail['plan'])];
                }
            } else {
                error_page();
            }
        }
        $data['page_title'] = $title ?? '';
        $data['h2'] = $h2 ?? '';
        $data['sidelist'] = $this->sidelist();
        $data['tabs'] = $tabs ?? [];
        $data['odds'] = $odds ?? '';
        $data['totalodds'] = $totalodds ?? [];
        $data['apeheader'] = $apeheader;
        $data['putall'] = $putall ?? '';
        $this->view("tips/vip",$data);
    }
}