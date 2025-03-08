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
            $data['page_title'] = "Best Football Prediction Site Worldwide";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, accurate football prediction website, sure wins, betting tips, free soccer forecast, best football prdiction website in the world';
            $this->description = 'An accurate football prediction website. Get the best soccer betting tips for today, tomorrow and the weekend from our reliable expert forecast site.';
            $this->og['title'] = 'Best football prediction website';
            $this->og['description'] = 'Accurate football prediction and realest source of sure 2 Odds, 3 Odds, 5 Odds and 10 Odds';
            $this->og['imagetype'] = 'image/jpg';
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
            // $bookieslink = HOME.'/bookies?bookie=';
            $bookiesprompt = 'Claim Offer';
            $diamval = [tips_links('5odds')=>'5 ODDS', tips_links('10odds')=>'10 ODDS', tips_links('straight')=>'Straight Win', tips_links('dblchance')=>'Double Chance', tips_links('bts')=>'GG/NGG', tips_links('ovun')=>'Over/Under'];
            $platval = [tips_links('2odds')=>'Sure 2odds', tips_links('3odds')=>'3odds Banker', tips_links('single')=>'Super Single', tips_links('p2s')=>'Players to Score', tips_links('draw')=>'Draws', tips_links('bigodds')=>'High Odds', tips_links('cscore')=>'Correct Score', tips_links('weekend')=>'Weekend Acca'];
            $freeval = ['FREE TIPS', 'Telegram', 'Weekend Soccer Predictions'];
            $data['plansec'] = [
                'header'=>'PLANS',
                'subheaders'=>[
                    'free'=>'FREE PLANS',
                    'diam'=>'DIAMOND PLANS',
                    'plat'=>'PLATINUM PLANS',
                ],
            ];
            $curdetails = currencies(USER_COUNTRY);
            $data['pricingsec'] = [
                'header'=>'BETAGamers Plans',
                'duration'=>'Month',
                'view'=>'View Plan'
                //'prices'=>$prices,
            ];
        } elseif(LANG=='fr') {
            $data['page_title'] = "Site de Pronostic Football Fiable";
            $this->description = 'Meilleur site de foot au monde. Un site de pronostic foot gagnant et meilleure source fiable de cotes sûres 2, 3 cotes et prévisions précises de football.';
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football au monde';
            $this->og['title'] = 'Site de Pronostic Football Fiable';
            $this->og['description'] = 'Site de pronostic football fiable et la meilleure source de 2 cotes sûres, 3 cotes, 5 cotes et 10 cotes';
            $this->og['imagetype'] = 'image/jpg';
            $data['slide_images'] = [
                'epl' => [
                    'alt'=>'Prévisions de Premier League',
                    'text'=>'Pronostics et Résultats de Championnat Angleterre'
                ],
                'laliga' => [
                    'alt'=>'Prévisions de LaLiga',
                    'text'=>'Pronostics et Résultats de Championnat Espagnol'
                ],
                'seriea' => [
                    'alt'=>'Logo de Serie A',
                    'text'=>'Pronostics et Résultats de Championnat Italie'
                ],
                'bundesliga' => [
                    'alt'=>'Prévisions de Bundesliga',
                    'text'=>'Pronostics et Résultats de Championnat Allemand'
                ],
                'ligue1' => [
                    'alt'=>'Ligue 1 de Français',
                    'text'=>'Pronostics et Résultats de Championnat France'
                ],
                'ucl' => [
                    'alt'=>'UEFA Ligue des Champions',
                    'text'=>'Pronostics et Résultats de la Ligue des Champions de l\'UEFA'
                ],
                'europa' => [
                    'alt'=>'Ligue Europa',
                    'text'=>'Pronostics et Résultats de Ligue Europa'
                ],
                'bgslide' => [
                    'alt'=>'La Photo de Betagamers',
                    'text'=>'Meilleur Site de Pronostics Football au Monde'
                ],
            ];
            $data['herolinks'] = [
                'reg'=>['link'=>account_links('register'), 'text'=>'S\'inscrire'],
                'login'=>['link'=>account_links('login'), 'text'=>'Se Connecter'],
                'profile'=>['link'=>account_links('profile'), 'text'=>'Mon Profil'],
                'pricing'=>['link'=>support_links('prices'), 'text'=>'Plans tarifaires'],
                'modus'=>['link'=>support_links('howitworks'), 'text'=>'Comment ça fonctionne'],
                'scores'=>['link'=>HOME.'/livescores.php', 'text'=>'Scores en direct']
            ];
            $data['freegames'] = [
                'header'=>'PRONOSTICS FOOT GRATUIT',
                'tabs'=>tab_names(['yes', '']),
                'free_games_page'=>free_games_link(),
                'viewmore'=>'Plus de pronos gratuits'
            ];
            $data['accurate'] = [
                'header'=>'PRÉDICTIONS RÉCENTES PRÉCISES',
                'theaders'=>set_table_header(),
            ];
            $data['alphasec'] = [
                'header'=>'CHOIX ALPHA',
                'oddstxt'=>'Meilleur Pronostic Football du Jour',
                'oddsdesc'=>'Meilleure cote quotidienne entre 1,65 et 2,50',
                'totalodds'=>$totalodds,
                'get'=>'Avoir accès',
                'marks'=>$marks,
                'accuracytxt'=>"Précision au cours des 20 derniers jours: ".($percent ?? '...'),
                'moreresults'=>'Afficher plus de résultats',
            ];
            $data['popular'] = [
                'header'=>'MEILLEURS PARIS POPULAIRES',
                'populartxt'=>'Découvrez sur quoi de nombreuses personnes parient aujourd\'hui',
                'theaders'=>set_table_header('popular')
            ];
            $data['upcoming'] = [
                'header'=>'PRÉDICTIONS À VENIR',
                'theaders'=>set_table_header('upcoming'),
            ];
            $bookiesheader = 'Dernières offres et offres de paris';
            $bookiesprompt = 'Inscrivez-vous';
            $diamval = ['5 COTES', '10 COTES', 'Victoire directe', 'Chance Double', 'les Deux Équipes Marquent', 'Total de Buts (Plus / Moins buts)'];
            $platval = ['2 Cotes Sûres', '3 Cotes Sûres', 'Super Simple', 'Prono fin de Semaine', 'Buteurs', 'Match nul', 'Grand Cotes', 'Score Exact'];
            $freeval = ['Conseil Gratuit Paris Sportif', 'Telegram', 'Prédictions de football du week-end'];
            $data['plansec'] = [
                'header'=>'DES PLANS',
                'subheaders'=>[
                    'free'=>'PLAN GRATUIT',
                    'diam'=>'PLAN DIAMANT',
                    'plat'=>'PLAN PLATINE',
                ],
            ];
            $curdetails = currencies(USER_COUNTRY);
            $data['pricingsec'] = [
                'header'=>'Plans de BETAGamers',
                'duration'=>'Mois',
                'view'=>'Voir le Plan'
                //'prices'=>$prices,
            ];
        } elseif(LANG=='es') {
            $data['page_title'] = "Sitio Web Fiable Para Predicción De Fútbol Precisa";
            $this->keywords = 'El mejor sitio de pronósticos de fútbol. Obtenga los mejores predicciones de fútbol para hoy, mañana y el fin de semana de nuestro sitio confiable de pronóstico experto.';
            $this->description = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, consejos de apuestas deportivas, sitio web de predicción deportiva precisa, sitio web de predicción precisa de fútbol, pronostico de futbol gratis, mejor sitio web de predicción de fútbol del mundo';
            $this->og['title'] = 'El mejor sitio de pronósticos de fútbol';
            $this->og['description'] = 'Predicción de fútbol precisa y fuente más real de predicciones de expertos';
            $this->og['imagetype'] = 'image/jpg';
            $data['slide_images'] = [
                'epl' => [
                    'alt'=>'Logo de la Premier League inglesa',
                    'text'=>'Predicciones y resultados de la Premier League'
                ],
                'laliga' => [
                    'alt'=>'Logo de La Liga española',
                    'text'=>'Predicciones y resultados de La Liga'
                ],
                'seriea' => [
                    'alt'=>'Logo de la Serie A italiana',
                    'text'=>'Predicciones y resultados de la Serie A'
                ],
                'bundesliga' => [
                    'alt'=>'Logo de la Bundesliga alemana',
                    'text'=>'Predicciones y resultados de la Bundesliga Alemana'
                ],
                'ligue1' => [
                    'alt'=>'Logo de la Ligue 1 francesa',
                    'text'=>'Predicciones y resultados de la Ligue 1 Francesa'
                ],
                'ucl' => [
                    'alt'=>'Logo de la Liga de Campeones de la UEFA',
                    'text'=>'Predicciones y resultados de la Liga de Campeones de la UEFA'
                ],
                'europa' => [
                    'alt'=>'Logo de la liga europea',
                    'text'=>'Predicciones y resultados de la Liga Europea'
                ],
                'bgslide' => [
                    'alt'=>'Logo de Betagamers',
                    'text'=>'El Mejor Sitio de Pronósticos de Fútbol del Mundo'
                ],
            ];
            $data['herolinks'] = [
                'reg'=>['link'=>account_links('register'), 'text'=>'REGISTRARSE'],
                'login'=>['link'=>account_links('login'), 'text'=>'LOGIN'],
                'profile'=>['link'=>account_links('profile'), 'text'=>'Mi Perfil'],
                'pricing'=>['link'=>support_links('prices'), 'text'=>'Precios'],
                'modus'=>['link'=>support_links('howitworks'), 'text'=>'Cómo funciona'],
                'blog'=>['link'=>HOME.'/blog', 'text'=>'Sports News'],
                'scores'=>['link'=>HOME.'/livescores.php', 'text'=>'Resultado en vivo']
            ];
            $data['freegames'] = [
                'header'=>'PREDICCIONES DE FÚTBOL GRATIS',
                'tabs'=>tab_names(['yes', '']),
                'free_games_page'=>free_games_link(),
                'viewmore'=>'Más predicciones gratuitos',
            ];
            $data['accurate'] = [
                'header'=>'CONSEJOS PRECISOS RECIENTES',
                'theaders'=>set_table_header(),
            ];
            $data['alphasec'] = [
                'header'=>'SELECCIONES ALFA',
                'oddstxt'=>'La mejor pronosticos futbol para hoy',
                'oddsdesc'=>'Las mejores apuestas combinadas diarias entre 1,65 - 2,50',
                'totalodds'=>$totalodds,
                'get'=>'Tener Accesso',
                'marks'=>$marks,
                'accuracytxt'=>"Precisión de los últimos 20 días: ".($percent ?? '...'),
                'moreresults'=>'Ver más resultados',
            ];
            $data['popular'] = [
                'header'=>'LAS MEJORES APUESTAS POPULARES',
                'populartxt'=>'Estos son los pronósticos de fútbol por los que mucha gente apuesta hoy',
                'theaders'=>set_table_header('popular')
            ];
            $data['upcoming'] = [
                'header'=>'PRÓXIMAS PRONOSTICOS CALIENTES',
                'theaders'=>set_table_header('upcoming'),
            ];
            $bookiesheader = 'Últimas ofertas de apuestas';
            // $bookieslink = HOME.'/bookies?bookie=';
            $bookiesprompt = 'Obtenga Oferta';
            $diamval = ['5 CUOTAS', '10 CUOTAS', 'Victoria Directa', 'Doble oportunidad', 'Ambos equipos anotarán', 'Más / Menos de Goles'];
            $platval = ['Segura 2 Cuotas', 'Segura 3 Cuotas', 'Apuesta Simple', 'Jugadores a marcar', 'Empates', 'Grandes Cuotas', 'Marcador Correcto', 'Combinadas para fin de semana'];
            $freeval = ['CONSEJOS GRATIS', 'Telegram', 'Pronosticos de fútbol para el fin de semana'];
            $data['plansec'] = [
                'header'=>'PLANES',
                'subheaders'=>[
                    'free'=>'PLAN GRATIS',
                    'diam'=>'PLAN DIAMANTE',
                    'plat'=>'PLAN PLATINO',
                ],
            ];
            $curdetails = currencies(USER_COUNTRY);
            $data['pricingsec'] = [
                'header'=>'Planes BETAGamers',
                'duration'=>'Mes',
                'view'=>'Ver el Plan'
                //'prices'=>$prices,
            ];
        }
        $data['slide_images_count'] = count($data['slide_images']);
		$this->style = '';
        $data['bookies'] = [
            'companies' => $bookies,
            'header' => $bookiesheader,
            'colors' => [
                '1xbet'=>'background-color:#054146; color:white;'
            ],
            'link'=>bookies_link().'?bookie=',
            'prompt'=>$bookiesprompt
        ];
        $freekey = ['./', TELEGRAM_CHANNEL_LINK, ''];
        $diamkey = [tips_links('5odds'), tips_links('10odds'), tips_links('straight'), tips_links('dblchance'), tips_links('bts'), tips_links('ovun')];
        $platkey = [tips_links('2odds'), tips_links('3odds'), tips_links('single'), tips_links('p2s'), tips_links('draw'), tips_links('bigodds'), tips_links('cscore'), tips_links('weekend')];
        $data['plansec']['sections']=>[
            'free'=>array_combine($freekey, $freeval),
            'diam'=>array_combine($diamkey, $diamval),
            'plat'=>array_combine($platkey, $platval),
        ];
        $data['pricingsec']['plans'] = plans(['diamond', 'platinum', 'ultimate']),
        $data['pricingsec']['currency'] = $curdetails['currency'],
        $data['pricingsec']['cursign'] = $curdetails['cur_sign'],
        ksort($data['pricingsec']['plans']);
		$this->view("home",$data);
	}
}