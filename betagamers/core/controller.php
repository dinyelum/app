<?php
//mother controller

Class Controller
{
	public $adminmode;
	public $sports = 'football';
	public $themeclass = 'w3-green';
	public $themecolor = 'green';
	public $page;
	public $lang;
	public $country;
	public $metabots;
	public $keywords;
	public $description;
	public $og = [];
	public $style;
	public $tags;
	public $displayheadermenu = 'default'; //default, profile, false
	public $urls = [];

		protected function view($view,$data = [])
	{
		//$generalclass = new General;
		//$data['footersocials'] = $generalclass->get_by_active('contacts', ['channel', 'icon', 'value', 'link'], [1]);
		//include header
		if(file_exists(ROOT."/app/betagamers/views/". $view .".php"))
 		{
			$data['header'] = $this->header();
			$data['footer'] = $this->footer();
 			include ROOT."/app/betagamers/views/". $view .".php";
			echo '</body></html>';
 		}else{
 		    $errorlevel = 'view';
 			include ROOT."/app/betagamers/views/404.php";
 		    trigger_error("View page, $view not found for: ".HOME.URI, E_USER_ERROR);
 		}
		// include "../app/betagamers/incs/footer.php"; //not all pages have the same footer (Signup and Login pages).
	}

	public function header($output=false) {
		if(LANG=='en') {
			$home = 'Home';
			$vip = 'VIP Tips';
			$login = 'Login';
			$logout = 'Logout';
			$sports = 'Sports';
			$football = 'Football';
			$tennis = 'Tennis';
		}
		$langarr = LANGUAGES;
		if ($offset = array_search(LANG, array_keys(LANGUAGES))) {
			$langarr = array_merge(array_slice(LANGUAGES, $offset, null, true), array_slice(LANGUAGES, 0, $offset, true));
		}
		foreach($langarr as $key=>$val) {
			$header['langs'][$key] = ['text'=>$val, 'locale'=>LANGUAGES_LOCALE[$key]];
		}
		$header['navlinks'] = [
			'sports'=>[
			   'text'=>$sports,
			   ['link'=>HOME, 'text'=>$football, 'icon'=>'fas fa-futbol'],
			   ['link'=>'#', 'text'=>$tennis, 'icon'=>'fas fa-baseball-ball']
			],
			'login'=>USER_LOGGED_IN === true ? ['link'=>account_links('logout'), 'text'=>$logout] : ['link'=>account_links('login'), 'text'=>$login],
			'tips'=>['link'=>tips_links(), 'text'=>$vip],
			'home'=>['link'=>HOME, 'text'=>$home]
		];
		if($output===true) {
			$data['header'] = $header;
			include INCS."/headermenu.php";
			return;
		}
		return $header;
	}

	public function footer($output=false) {
		if(LANG=='en') {
			$accountlinks = USER_LOGGED_IN===true ? ['profile'=>'My Profile', 'logout'=>'Logout'] : ['register'=>'Register', 'login'=>'Login'];
			$general = [
				'General',
				...$accountlinks,
				'bookmakers'=>'Bookmakers',
				'blog'=>'Sports News Blog',
				'freetips'=>'Football Bet Tips',
				'tennis'=>'Tennis'
			];

			$freebets = [
				'Free Bets',
				'epl'=>'EPL Tips',
				'ligue1'=>'Ligue 1 Tips',
				'seriea'=>'Serie A Tips',
				'laliga'=>'La Liga Tips',
				'bundesliga'=>'Bundesliga Tips',
				'ucl'=>'UCL Tips',
				'europa'=>'Europa Tips'
			];

			$support = [
				'Support',
				'contactus'=>'Contact Us',
				'prices'=>'Prices',
				'terms'=>'Terms',
				'faqs'=>'FAQS',
				'aboutus'=>'About Us',
				'jobs'=>'Jobs'
			];

			$socialmedia = ['Social Media'];

			$footerbottom = [
				'account'=>[
					'https://www.begambleaware.org/'=>'Be Gamble Aware',
					'https://www.responsiblegambling.org'=>'Gamble Responsibly'
				],
				'bggroup'=>'The BetaGamers Group',
				'rights'=>'All rights reserved'
			];
		}
		$footer['sec1'] = [
			[
				$general[0]=>[
					['link'=>account_links(isset($general['profile']) ? 'profile' : 'register'), 'text'=>$general['profile'] ?? $general['register']],
					['link'=>account_links(isset($general['logout']) ? 'logout' : 'login'), 'text'=>$general['logout'] ?? $general['login']],
					['link'=>bookies_link(), 'text'=>$general['bookmakers']],
					['link'=>'https://betagamers.net/blog', 'text'=>$general['blog']],
					['link'=>free_games_link(), 'text'=>$general['freetips']],
					['link'=>'#', 'text'=>$general['tennis']]
				],
				$freebets[0]=>[
					['link'=>free_games_link('epl'), 'text'=>$freebets['epl']],
					['link'=>free_games_link('ligue1'), 'text'=>$freebets['ligue1']],
					['link'=>free_games_link('seriea'), 'text'=>$freebets['seriea']],
					['link'=>free_games_link('laliga'), 'text'=>$freebets['laliga']],
					['link'=>free_games_link('bundesliga'), 'text'=>$freebets['bundesliga']],
					['link'=>free_games_link('ucl'), 'text'=>$freebets['ucl']],
					['link'=>free_games_link('europa'), 'text'=>$freebets['europa']]
				]
			],
			[
				$support[0]=>[
					['link'=>support_links(), 'text'=>$support['contactus']],
					['link'=>support_links('prices'), 'text'=>$support['prices']],
					['link'=>support_links('terms'), 'text'=>$support['terms']],
					['link'=>support_links('faqs'), 'text'=>$support['faqs']],
					['link'=>support_links('aboutus'), 'text'=>$support['aboutus']],
					['link'=>support_links('jobs'), 'text'=>$support['jobs']],
				],
				$socialmedia[0]=>[
					['link'=>FBLINK, 'text'=>'Facebook', 'target'=>'_blank', 'icon'=>'fa-facebook-square'],
					['link'=>XLINK, 'text'=>'X', 'target'=>'_blank', 'icon'=>'fa-twitter-square'],
					['link'=>IGLINK, 'text'=>'Instagram', 'target'=>'_blank', 'icon'=>'fa-instagram'],
					['link'=>WHATSAPP_LINK, 'text'=>'Whatsapp', 'icon'=>'fa-whatsapp'],
					['link'=>TELEGRAM_LINK, 'text'=>'Telegram', 'target'=>'_blank', 'icon'=>'fa-telegram'],
					['link'=>PINTERESTLINK, 'text'=>'Pinterest', 'target'=>'_blank', 'icon'=>'fa-pinterest-square']
				]
			]
		];
		$footer['sec2'] = $footerbottom;
		if($output===true) {
			$data['header']['langs'] = $this->header()['langs'];
			$data['footer'] = $footer;
			include INCS."/footer.php";
			return;
		}
		return $footer;
	}

    // protected function loadModel($model)
	// {
	// 	if(file_exists("../app/models/". $model .".php"))
 	// 	{
 	// 		include "../app/models/". $model .".php";
 	// 		return $model = new $model();
 	// 	}

 	// 	return false;
	// }


}