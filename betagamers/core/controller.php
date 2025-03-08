<?php
//mother controller

Class Controller
{
	public $adminmode;
	public $sports = 'football';
	public $themeclass = 'w3-green';
	public $themecolor = 'green';
	public $page;
	public $activepage;
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
 		    //header('Content-Type: text/html; charset=ISO-8859-1');
 		    //echo 'maintenance mode';
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
		} elseif(LANG=='fr') {
			$home = 'Accueil';
			$vip = 'Pronos VIP';
			$login = 'Connecter';
			$logout = 'Déconnexion';
			$sports = 'Sports';
			$football = 'Football';
			$tennis = 'Tennis';
		} elseif(LANG=='es') {
			$home = 'Inicio';
			$vip = 'VIP';
			$login = 'Login';
			$logout = 'Cerrar Sesión';
			$sports = 'Deportes';
			$football = 'Fútbol';
			$tennis = 'Tenis';
		}  elseif(LANG=='pt') {
			$home = 'Inicial';
			$vip = 'VIP';
			$login = 'Entrar';
			$logout = 'Sair';
			$sports = 'Esportes';
			$football = 'Futebol';
			$tennis = 'Tênis';
		}  elseif(LANG=='de') {
			$home = 'Startseite';
			$vip = 'VIP-Tipps';
			$login = 'Einloggen';
			$logout = 'Ausloggen';
			$sports = 'Sport';
			$football = 'Fußball';
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
				'above18'=>'Above 18',
				'bggroup'=>'The BetaGamers Group',
				'rights'=>'All rights reserved'
			];
		} elseif(LANG=='fr') {
			$accountlinks = USER_LOGGED_IN===true ? ['profile'=>'Mon Profil', 'logout'=>'Déconnexion'] : ['register'=>"S'Inscrire", 'login'=>'Se Connecter'];
			$general = [
				'Général',
				...$accountlinks,
				'bookmakers'=>'Bookmakers',
				'blog'=>"Blog d'actualité sportive (Anglais)",
				'freetips'=>'Conseils de Paris sur le Football',
				'tennis'=>'Tennis'
			];

			$freebets = [
				'Paris Gratuits',
				'ligue1'=>'Pronos Ligue 1',
				'seriea'=>'Pronos Serie A',
				'laliga'=>'Pronos Liga',
				'bundesliga'=>'Pronos Bundesliga',
				'epl'=>'Pronos Premier League',
				'ucl'=>'Pronos Ligue des Champions',
				'europa'=>'Pronos Ligue Europa'
			];

			$support = [
				'Soutien',
				'contactus'=>'Nous Contacter',
				'prices'=>'Plans Tarifaires',
				'terms'=>'Termes',
				'faqs'=>'FAQ',
				'aboutus'=>'À propos de Nous',
				'jobs'=>'Emploi'
			];

			$socialmedia = ['Médias Sociaux'];

			$footerbottom = [
				'account'=>[
					'https://frcasinospot.com/jeu-responsable/'=>'Conseils pour un Jeu Responsable'
				],
				'above18'=>'au-dessus de 18',
				'bggroup'=>'Le Groupe BetaGamers',
				'rights'=>'Tous Droits Réservés'
			];
		} elseif(LANG=='es') {
			$accountlinks = USER_LOGGED_IN===true ? ['profile'=>'Mi perfil', 'logout'=>'Cerrar sesión'] : ['register'=>'Registrarse', 'login'=>'Login'];
			$general = [
				'General',
				...$accountlinks,
				'bookmakers'=>'Casas de Apuestas',
				'blog'=>'Blog de noticias deportivas (en inglés)',
				'freetips'=>'Fin de semana',
				'tennis'=>'Tenis'
			];

			$freebets = [
				'Apuestas Gratis',
				'epl'=>'Consejos EPL',
				'ligue1'=>'Consejos Ligue 1',
				'seriea'=>'Consejos Serie A',
				'laliga'=>'Consejos La Liga',
				'bundesliga'=>'Bundesliga',
				'ucl'=>'Consejos UCL',
				'europa'=>'Consejos Europea'
			];

			$support = [
				'Apoyo',
				'contactus'=>'Contacto',
				'prices'=>'Precios',
				'terms'=>'Condiciones',
				'faqs'=>'Preguntas',
				'aboutus'=>'Sobre nosotros',
				'jobs'=>'Empleos'
			];

			$socialmedia = ['Social'];

			$footerbottom = [
				'account'=>[
					'https://www.gob.pe/institucion/mincetur/noticias/18620-apuestas-deportivas-consejos-para-un-juego-responsable'=>'Apuesta responsablemente'
				],
				'above18'=>'mayores de 18',
				'bggroup'=>'Grupo BetaGamers',
				'rights'=>'Todos los derechos reservados'
			];
		} elseif(LANG=='pt') {
			$accountlinks = USER_LOGGED_IN===true ? ['profile'=>'Meu perfil', 'logout'=>'Sair'] : ['register'=>'Registro', 'login'=>'Entrar'];
			$general = [
				'Geral',
				...$accountlinks,
				'bookmakers'=>'Casas de apostas',
				'blog'=>'Blog de notícias esportivas (inglês)',
				'freetips'=>'Futebol Europeu',
				'tennis'=>'Tênis'
			];

			$freebets = [
				'Apostas Grátis',
				'epl'=>'Dicas EPL',
				'ligue1'=>'Dicas Ligue 1',
				'seriea'=>'Dicas Liga Itália',
				'laliga'=>'Dicas La Liga',
				'bundesliga'=>'Dicas Bundesliga',
				'ucl'=>'Dicas UCL',
				'europa'=>'Dicas Europas'
			];

			$support = [
				'Apoio',
				'contactus'=>'Contato conosco',
				'prices'=>'Preços',
				'terms'=>'Termos',
				'faqs'=>'Perguntas',
				'aboutus'=>'Sobre nós',
				'jobs'=>'Empregos'
			];

			$socialmedia = ['Mídia social'];

			$footerbottom = [
				'account'=>[
					'https://jogoresponsavel.pt/'=>'Jogue com responsabilidade'
				],
				'above18'=>'au-dessus de 18',
				'bggroup'=>'O Grupo BetaGamers',
				'rights'=>'Todos os direitos reservados'
			];
		} elseif(LANG=='de') {
			$accountlinks = USER_LOGGED_IN===true ? ['profile'=>'Mein Profil', 'logout'=>'Ausloggen'] : ['register'=>'Registrieren', 'login'=>'Einloggen'];
			$general = [
				'Allgemein',
				...$accountlinks,
				'bookmakers'=>'Buchmacher',
				'blog'=>'Sportnachrichten-Blog (Englisch)',
				'freetips'=>'Wochenende-Tipps',
				'tennis'=>'Tennis'
			];

			$freebets = [
				'Kostenlose Wetten',
				'epl'=>'EPL Tipps',
				'ligue1'=>'Ligue 1 Tipps',
				'seriea'=>'Serie A Tipps',
				'laliga'=>'La Liga Tipps',
				'bundesliga'=>'Bundesliga Tipps',
				'ucl'=>'UCL Tipps',
				'europa'=>'Europa Tipps'
			];

			$support = [
				'Hilfecenter',
				'contactus'=>'Kontaktiere uns',
				'prices'=>'Preise',
				'terms'=>'Bedingungen',
				'faqs'=>'Fragen',
				'aboutus'=>'Über uns',
				'jobs'=>'Arbeitsplätze'
			];

			$socialmedia = ['Sozialen Medien'];

			$footerbottom = [
				'account'=>[
					'https://www.gambling.com/de/verantwortung/verantwortungsbewusstes-spielen'=>'Spielen Sie verantwortungsvoll'
				],
				'above18'=>'Über 18',
				'bggroup'=>'Die BetaGamers-Gruppe',
				'rights'=>'Alle Rechte vorbehalten'
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