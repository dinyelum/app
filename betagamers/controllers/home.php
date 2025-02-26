<?php

Class Home extends Controller 
{
    function __construct() {
        //$this->country = $_SESSION['country'] ?? $_SERVER['HTTP_CF_IPCOUNTRY'] ?? '';
    }

	public $discount_banner = [
        'en'=>[
            'text1'=>'MERRY CHRISTMAS AND HAPPY NEW YEAR', 
            'text2'=>'Christmas discount ends in', 'd'=>'d', 'h'=>'h', 'm'=>'m', 's'=>'s'],
        'fr'=>[
            'text1'=>'JOYEUX NOEL ET BONNE ANNÉE', 
            'text2'=>'La réduction de Noël se termine dans', 'd'=>'j', 'h'=>'h', 'm'=>'m', 's'=>'s'],
        'es'=>[
            'text1'=>'FELIZ NAVIDAD Y PRÓSPERO AÑO NUEVO', 
            'text2'=>'El descuento de Navidad finaliza en', 'd'=>'d', 'h'=>'h', 'm'=>'m', 's'=>'s'],
        'pt'=>[
            'text1'=>'FELIZ NATAL E FELIZ ANO NOVO', 
            'text2'=>'O desconto de Natal termina em', 'd'=>'d', 'h'=>'h', 'm'=>'m', 's'=>'s'],
        'de'=>[
            'text1'=>'FROHE WEIHNACHTEN UND EIN GLÜCKLICHES NEUES JAHR', 
            'text2'=>'Der Weihnachtsrabatt endet in', 'd'=>'T', 'h'=>'h', 'm'=>'m', 's'=>'s'],
    ];
    
    function index() {
        //bookies, alphasectotalodds, marks, percent
        $tabquery = [
            'bookies'=>[
                'select'=>['bookie, description_'.LANG.', reflink'],
                'where'=>['active=1 and homepage=1']
            ],
            'odds'=>[
                '1select'=>['totalodds'],
                '1where'=>["games='ap' and date=curdate()"]
            ],
            'marks'=>[
                '2select'=>['date, mark, percent'],
                '2where'=>["games='ap' order by date desc limit 4"]
            ]
        ];
        $marksclass = new Marks;
        $db = $marksclass->transaction($tabquery);
        $totalodds = isset($db['odds']['1where'][0]['totalodds']) ? (format_number($db['odds']['1where'][0]['totalodds']) ?: '...') : '...';
        if(count($db['marks']['2where'])) {
            $percent = ($db['marks']['2where'][0]['percent'] > 50 ? format_number($db['marks']['2where'][0]['percent']) : format_number(50)).'%';
            $marksarr = array_column($db['marks']['2where'], 'mark', 'date');
            $marks = '';
            foreach($marksarr as $key=>$val) {
                list($mark, $size, $color) = explode(',', $val);
                $date = date('d/m/Y', strtotime($key));
                $marks .= "<div class='w3-col s6 w3-padding-top'><br>".$marksclass->fa_fa_mark($mark, $size, $color, $date)."</div>";
            }
        }
        $bookies = $db['bookies']['where'];

        $this->page = $this->activepage = 'homepage';
		$this->metabots = 'index, follow';
        $this->tags = true;
        $this->urls = all_versions();
        $this->og = [
            'url'=> $this->urls[LANG],
            'image'=>$this->urls[LANG].'/assets/images/bgslide1x.jpg'
        ];
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, accurate football prediction website, sure wins, betting tips, free soccer forecast, best football prdiction website in the world';
            $this->description = 'An accurate football prediction website. Get the best soccer betting tips for today, tomorrow and the weekend from our reliable expert forecast site.';
            $this->og['title'] = 'Best football prediction website';
            $this->og['description'] = 'Accurate football prediction and realest source of sure 2 Odds, 3 Odds, 5 Odds and 10 Odds';
            $this->og['imagetype'] = 'image/jpg';
            $data['page_title'] = "Best Football Prediction Site Worldwide";
            $data['slide_images'] = [
                'epl' => [
                    'alt'=>'English Premier League Logo',
                    'text'=>'Premier League Predictions and Results'
                ],
                'laliga' => [
                    'alt'=>'Spanish LaLiga Logo',
                    'text'=>'LaLiga Predictions and Results'
                ],
                'seriea' => [
                    'alt'=>'Italian Serie A Logo',
                    'text'=>'Serie A Predictions and Results'
                ],
                'bundesliga' => [
                    'alt'=>'German Bundesliga Logo',
                    'text'=>'German Bundesliga Predictions and Results'
                ],
                'ligue1' => [
                    'alt'=>'French Ligue 1 Logo',
                    'text'=>'French Ligue 1 Predictions and Results'
                ],
                'ucl' => [
                    'alt'=>'UEFA Champions League Logo',
                    'text'=>'UEFA Champions League Predictions and Results'
                ],
                'europa' => [
                    'alt'=>'Europa League Logo',
                    'text'=>'Europa League Predictions and Results'
                ],
                'bgslide' => [
                    'alt'=>'Betagamers Logo',
                    'text'=>'Best Football Prediction Site in the World'
                ],
            ];
            $data['herolinks'] = [
                'reg'=>['link'=>account_links('register'), 'text'=>'REGISTER'],
                'login'=>['link'=>account_links('login'), 'text'=>'LOGIN'],
                'profile'=>['link'=>account_links('profile'), 'text'=>'My Profile'],
                'pricing'=>['link'=>support_links('prices'), 'text'=>'Pricing Plans'],
                'modus'=>['link'=>support_links('howitworks'), 'text'=>'How it Works'],
                'blog'=>['link'=>HOME.'/blog', 'text'=>'Sports News'],
                'scores'=>['link'=>HOME.'/livescores.php', 'text'=>'Livescores']
            ];
            $data['freegames'] = [
                'header'=>'FREE SOCCER PREDICTIONS',
                'tabs'=>tab_names(['yes', '']),
                'free_games_page'=>free_games_link(),
                'viewmore'=>'More Free Tips'
            ];
            $data['accurate'] = [
                'header'=>'RECENT ACCURATE TIPS',
                'theaders'=>set_table_header(),
            ];
            $data['alphasec'] = [
                'header'=>'ALPHA PICKS',
                'oddstxt'=>'Football Match Prediction Banker for Today',
                'oddsdesc'=>'Daily best odds between 1.65 - 2.50',
                'totalodds'=>$totalodds,
                'get'=>'Get Access',
                'marks'=>$marks,
                'accuracytxt'=>"Last 20 Days Accuracy: ".($percent ?? '...'),
                'moreresults'=>'View More Results',
            ];
            $data['popular'] = [
                'header'=>'BEST POPULAR BETS',
                'populartxt'=>'Here are the latest football predictions a lot of people are betting on today',
                'theaders'=>set_table_header('popular')
            ];
            $data['upcoming'] = [
                'header'=>'HOT UPCOMING PREDICTIONS',
                'theaders'=>set_table_header('upcoming'),
            ];
            $bookiesheader = 'Latest Betting Deals and Offers';
            $bookieslink = HOME.'/bookies?bookie=';
            $bookiesprompt = 'Claim Offer';
            $diamodds = [tips_links('5odds')=>'5 ODDS', tips_links('10odds')=>'10 ODDS', tips_links('straight')=>'Straight Win', tips_links('dblchance')=>'Double Chance', tips_links('bts')=>'GG/NGG', tips_links('ovun')=>'Over/Under'];
            $platodds = [tips_links('2odds')=>'Sure 2odds', tips_links('3odds')=>'3odds Banker', tips_links('single')=>'Super Single', tips_links('p2s')=>'Players to Score', tips_links('draw')=>'Draws', tips_links('bigodds')=>'High Odds', tips_links('cscore')=>'Correct Score', tips_links('weekend')=>'Weekend Acca'];
            $freesec = ['./'=>'FREE TIPS', TELEGRAM_CHANNEL_LINK=>'Telegram', ''=>'Weekend Soccer Predictions'];
            // $diamodds = ['5 ODDS', '10 ODDS', 'Straight Win', 'Double Chance', 'GG/NGG', 'Over/Under'];
            // $platodds = ['Sure 2odds', '3odds Banker', 'Super Single', 'Players to Score', 'Draws', 'High Odds', 'Correct Score', 'Weekend Acca'];
            // $diamlinks = ['5odds', '10odds', 'straight', 'dblchance', 'bts', 'ovun'];
            // $platlinks = ['2odds', '3odds', 'single', 'p2s', 'draw', 'bigodds', 'cscore', 'weekend'];
            //$diamsec = $this->format_plan_links($diamodds, $diamlinks);
            //$platsec = $this->format_plan_links($platodds, $platlinks);
            //$prices = $this->format_plan_sec();
            //$supp_price = $this->supp_pricing();
            //$pricing = (isset($_SESSION['country'])) ? $this->pay_links($this->cur_details['extralink']) : $supp_price['link'];
            $data['plansec'] = [
                'header'=>'PLANS',
                'subheaders'=>[
                    'free'=>'FREE PLANS',
                    'diam'=>'DIAMOND PLANS',
                    'plat'=>'PLATINUM PLANS',
                ],
                'sections'=>[
                    'free'=>$freesec,
                    'diam'=>$diamodds,
                    'plat'=>$platodds,
                ]
                //'freesec'=>$freesec,
                //'diamsec'=>$diamsec,
                //'platsec'=>$platsec,
            ];
            $curdetails = currencies(USER_COUNTRY);
            // show(single_price('diamond', 1, $curdetails['currency']));
            // single_price($key, 1, currencies(USER_COUNTRY, $data['pricingsec']['currency']))
            $data['pricingsec'] = [
                'header'=>'BETAGamers Plans',
                'plans'=>plans(['diamond', 'platinum', 'ultimate']),
                'currency'=>$curdetails['currency'],
                'cursign'=>$curdetails['cur_sign'],
                'duration'=>'Month',
                'view'=>'View Plan'
                //'prices'=>$prices,
            ];
            ksort($data['pricingsec']['plans']);
        }
        $data['slide_images_count'] = count($data['slide_images']);
		$this->style = '';
        $data['bookies'] = [
            'companies' => $bookies,
            'header' => $bookiesheader,
            'colors' => [
                '1xbet'=>'background-color:#054146; color:white;'
            ],
            'link'=>$bookieslink,
            'prompt'=>$bookiesprompt
        ];




/*
		$generalclass = new General;
		$ordersclass = new Orders;
		$getsubjects = $generalclass->get_by_active('subjects', ['subject'], [1], 'order by subject');
		$getreviews = $ordersclass->custom_query(
			"select id, subject, type, pages, review, rating, date, deadline from (
			select id, subject, type, pages, review, rating, DATE_FORMAT(expdate, '%D %M, %Y') as date, @days := HOUR(TIMEDIFF(expdate, regdate)) DIV 24, (
			CASE
			when @days<1 THEN CONCAT(@days, ' hours')
			WHEN @days=1 THEN CONCAT(@days, ' day') ELSE 
			CONCAT(@days, ' days') END) as deadline FROM `orders`  where rating >= 3 and review != '' order by expdate desc limit 9) as subset;");
		$data['subjects'] = is_array($getsubjects) ? array_chunk(array_column($getsubjects, 'subject'), ceil(count($getsubjects)/4)) : ['subject'=>''];
		$allreviews = is_array($getreviews) ? $getreviews : [];
		$data['reviews'] = array_chunk($allreviews, 3);
        */
		$this->view("home",$data);
	}
}
/*
ceil(count($getsubjects)/4) is
an attempt at making sure list items have the same number of rows on all screen sizes without 
having to echo the list items multiple times for differnt screen sizes. There's 
already CSS grid auto auto dividing the list items in two and two foreach making sure batch A starts at A 
and batch B starts somewhere in the middle.
For a later increased number of list items(20 list items currently gives me 5555 on big screens and 1010 on small screens), you can adjust the number 4, to any other numer till it suits what you want.
The mobile view meanwhile will always have two columns of equal / almost equal length.
*/
