<?php
class Free_Predictions extends Controller {
    public $tags = true;
    public $season = '2024/2025';
    public $year = '2024';
    public $teams = [
        'epl'=>[
            ['AFC Bournemouth', 'Arsenal', 'Aston Villa', 'Brentford', 'Brighton & Hove Albion', 'Chelsea', 'Crystal Palace', 'Everton', 'Fulham', 'Ipswich Town'],
            ['Liverpool', 'Leicester City', 'Manchester City', 'Manchester United', 'Newcastle United', 'Nottingham Forest', 'Southampton', 'Tottenham Hotspur', 'West Ham United', 'Wolverhampton Wanderers']
            ],
        'laliga'=>[
            ['Alaves', 'Athletic Bilbao', 'Atletico Madrid', 'Barcelona', 'Celta Vigo', 'Espanyol', 'Getafe', 'Girona', 'Granada', 'Las Palmas'],
            ['Leganes', 'Mallorca', 'Osasuna', 'Rayo Vallecano', 'Real Betis', 'Real Madrid', 'Real Sociedad', 'Sevilla', 'Valencia', 'Villarreal']
            ],
        'bundesliga'=>[
            ['Augsburg', 'Bayer Leverkusen', 'Bayern Munich', 'Bochum', 'Borussia Dortmund', 'Borussia M\'gladbach', 'Eintracht Frankfurt', 'Freiburg'],
            ['Heidenheim', 'Hoffenheim', 'Mainz', 'RB Leipzig', 'St Pauli', 'Stuttgart', 'Union Berlin', 'Werder Bremen', 'Wolfsburg']
            ],
        'seriea'=>[
            ['AC Milan', 'Atalanta', 'Bologna', 'Cagliari', 'Como', 'Empoli', 'Fiorentina', 'Genoa', 'Inter Milan', 'Juventus'],
            ['Lazio', 'Lecce', 'Monza', 'Napoli', 'Parma', 'Roma', 'Torino', 'Udinese', 'Venezia', 'Verona']
            ],
        'ligue1'=>[
            ['Angers', 'Auxerre', 'Brest', 'Le Havre', 'Lens', 'Lille', 'Lyon', 'Marseille', 'Monaco'],
            ['Montpellier', 'Nantes', 'Nice', 'PSG', 'Reims', 'Rennes', 'St Etienne', 'Strasbourg', 'Toulouse'	]
            ],
        'ucl'=>[
            [],
            []
            ],
        'europa'=>[
            [],
            []
            ],
        'euro'=>[
            [],
            []
            ],
        'afcon'=>[
            [],
            []
            ]
    ];
    public $socials = INCS."/social.php";
    public $iframe = [];
    public $writeuponly = null;
    public $filename;

    function index() {
        $this->page = $this->activepage = 'freegames';
        $this->urls = free_games_link('', true);
        if(LANG=='en') {
            // $data['page_title'] = $data['h1'] = "All League, Competition Free Tips";
            $data['page_title'] = $data['h1'] = "Free League / Cup Tips";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, free sports tips, free european league tips';
            $this->description = 'Best free football league predictions and tips site, view the latest bet tips for today and for the weekend for all the leagues.';
            $this->og['description'] = 'The leading free soccer predictions site. View our all league free predictions today, tomorrow and every weekend.';
        } elseif(LANG=='fr') {
            // $data['page_title'] = $data['h1'] = "All League, Competition Free Tips";
            $data['page_title'] = $data['h1'] = "Conseils gratuits de ligue/coupe";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, nouvelles des betagamers, blog des betagamers, pronostics ligue anglaise, pronostics liga espagnole, pronostics série italienne a, pronostics ligue 1 française, pronostics Bundesliga allemande, Conseils de Paris sur le Football';
            $this->description = 'Meilleurs conseils de paris gratuits sur le football, consultez les dernières prévisions de football gratuites sur notre site maintenant.';
            $this->og['description'] = 'site de prédiction de football gagnant. Consultez nos prévisions gratuites aujourd\'hui et chaque week-end.';
        } elseif(LANG=='es') {
            // $data['page_title'] = $data['h1'] = "All League, Competition Free Tips";
            $data['page_title'] = $data['h1'] = "Consejos gratuitos de liga y copa";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, Consejos de apuestas de fútbol para el fin de semana, El mejor pronóstico para los favorito para hoy en la grandes Ligas';
            $this->description = 'Vea los últimos pronósticos de apuestas de fútbol para hoy y el fin de semana de diferentes ligas.';
            $this->og['description'] = 'Vea los últimos pronósticos de apuestas de fútbol para el fin de semana.';
        } elseif(LANG=='pt') {
            // $data['page_title'] = $data['h1'] = "All League, Competition Free Tips";
            $data['page_title'] = $data['h1'] = "Dicas grátis da Liga / Copa";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, prognósticos gratuitos das principais ligas europeias';
            $this->description = 'Obtenha as melhores previsões gratuitas para as principais ligas europeias e outros grandes torneios.';
            $this->og['description'] = 'Obtenha as melhores previsões gratuitas para as principais ligas europeias e outros grandes torneios.';
        } elseif(LANG=='de') {
            // $data['page_title'] = $data['h1'] = "All League, Competition Free Tips";
            $data['page_title'] = $data['h1'] = "Kostenlose Liga / Pokal Tipps";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, kostenlose Wochenendvorhersagen';
            $this->description = 'Die besten kostenlosen europäischen Fußballvorhersagen für heute und für das Wochenende.';
            $this->og['description'] = 'Die besten kostenlosen europäischen Fußballvorhersagen für heute und für das Wochenende.';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/soccerfield.jpg';
        $this->og['title'] = $data['page_title'];
        $data['socials'] = file_get_contents ($this->socials);
        $posts = ['epl', 'seriea', 'bundesliga', 'laliga', 'ligue1', 'ucl', 'europa', 'predict', 'afcon', 'euro', 'teams', 'guide'];
        $data['posts']['list'] = array_chunk(related_posts($posts), 3, true);
        $this->view("free_predictions/index",$data);
    }

    function iframe_teams($width, $height, $tabletype='big', $stage=null) {
        $frame = $this->iframe;
        $sections = $tabletype=='big' ? 'po=1&ma=1&wi=1&dr=1&los=1&gf=1&ga=1&gd=1&pts=1&ng=1&form=1' : 'po=1&ma=1&wi=1&dr=1&los=1&gf=0&ga=0&gd=1&pts=1&ng=0&form=0'?>
        <iframe width="<?=$width?>" height="<?=$height?>" src="https://www.fctables.com/<?=$frame['league']?>/iframe/?type=table&lang_id=<?=$frame['langid']?>&country=<?=$frame['country'].(isset($stage) ? "&stage=".$stage : '')?>&template=<?=$frame['template']?>&timezone=Africa/Lagos&time=24&<?=$sections?>&width=<?=$width?>&height=<?=$height?>&font=Verdana&fs=12&lh=22&bg=FFFFFF&fc=333333&logo=0&tlink=0&scfs=22&scfc=333333&scb=1&sclg=1&teamls=80&ths=1&thb=1&thba=FFFFFF&thc=000000&bc=dddddd&hob=f5f5f5&hobc=ebe7e7&lc=333333&sh=1&hfb=1&hbc=008000&hfc=FFFFFF"></iframe><?php
    }

    function iframe_scorers($width, $height) {
        $frame = $this->iframe?>
        <iframe width="<?=$width?>" height="<?=$height?>" src="https://www.fctables.com/<?=$frame['league']?>/iframe=/?type=top-scorers&lang_id=<?=$frame['langid']?>&country=<?=$frame['country']?>&template=<?=$frame['template']?>&team=&timezone=Africa/Lagos&time=24&limit=10&ppo=1&pte=1&pgo=1&pma=1&pas=1&ppe=1&width=320&height=300&font=Verdana&fs=12&lh=22&bg=FFFFFF&fc=333333&logo=0&tlink=0&ths=1&thb=1&thba=FFFFFF&thc=000000&bc=dddddd&hob=f5f5f5&hobc=ebe7e7&lc=333333&sh=1&hfb=1&hbc=008000&hfc=FFFFFF"></iframe><?php
    }
    
    function default_iframe_values() {
        $this->iframe = match(LANG) {
            'fr'=>['langid'=>'3','courtesy'=>'Avec l\'aimable autorisation de','playersh'=>'10 meilleurs buteurs'],
            'es'=>['langid'=>'4','courtesy'=>'Cortesía de','playersh'=>'Los 10 mejores goleadores'],
            'pt'=>['langid'=>'12','courtesy'=>'Cortesia de','playersh'=>'Os 10 maiores marcadores'],
            'de'=>['langid'=>'6','courtesy'=>'Mit freundlicher Genehmigung von','playersh'=>'Die 10 besten Torschützen'],
            default=>['langid'=>'2','courtesy'=>'Courtesy','playersh'=>'Top 10 Highest Goal Scorers'],
        };
    }

    function display_iframes() {
        if(!count($this->iframe)) return;?>
        <div id="<?=$this->iframe['id']?>">
            <h2><?=$this->iframe['teamsh']?></h2>
            <div class="bigtable"><?php
                if(isset($this->iframe['stage'])) {
                    foreach($this->iframe['stage'] as $val) {
                        $this->iframe_teams($this->iframe['btwidth'], $this->iframe['btheight'], $val);
                    }
                } else {
                    $this->iframe_teams($this->iframe['btwidth'], $this->iframe['btheight']);
                }?>
            </div>
            <div class="smalltable"><?php
                if(isset($this->iframe['stage'])) {
                    foreach($this->iframe['stage'] as $val) {
                        echo $val;
                        $this->iframe_teams($this->iframe['stwidth'], $this->iframe['stheight'], $val);
                    }
                } else {
                    $this->iframe_teams($this->iframe['stwidth'], $this->iframe['stheight']);
                }?>
            </div>
            <?=$this->iframe['courtesy']?>: <a href="https://www.fctables.com/<?=$this->iframe['league']?>/" target="_blank" rel="nofollow">FcTables.com</a>

            <h2><?=$this->iframe['playersh']?></h2>
            <div class="scorers">
                <?=$this->iframe_scorers($this->iframe['pwidth'], $this->iframe['pheight'])?>
            </div>
            <a href="https://www.fctables.com/<?=$this->iframe['league']?>/" target="_blank" rel="nofollow">FcTables.com</a>
        </div><?php
    }

    function list_league_teams() {
        if(!count(array_merge([], ...$this->teams[$this->page]))) return;?>
        <div class='w3-panel'><?php
            foreach($this->teams[$this->page] as $ind=>$val) {?>
                <div class='w3-half'>
                    <?='<ul><li>'.implode('</li><li>', $val).'</li></ul>'?>
                </div><?php
            }?>
        </div><?php
    }

    private function league(array $data) {
        $league = $this->page;
        $this->style = 'h2, p a {color: green;}';
        $this->urls = free_games_link($this->page, true);
        $filename = $this->filename ?? ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG."/$league.php";
        $data['heroimg']['name'] = $this->page;
        $data['heroimg']['image'] = $this->page.'2x.jpg';
        if(array_key_exists($this->page, $this->teams)) {
            $freegamesclass = new Freegames;
            $getmtime = $freegamesclass->select('regdate')->where("league='epl' order by regdate desc limit 1");
            // show($getmtime);
            // $data['leaguearr'] = glob(INCS."/free_predicts/".LANG."/*$league.php");
            $data['tabs'] = free_tab_names(['yes', '']);
        } else {
            if (file_exists($filename)) {
                $getfilemtime = filemtime($filename);
            }
        }
        $mtime = isset($getmtime[0]['regdate']) ? strtotime($getmtime[0]['regdate']) : $getfilemtime;
        $data['lastmodified'] = filemodify($mtime);
        $data['socials'] = file_get_contents ($this->socials);
        if(count($this->iframe)) {
            // $this->showiframe = true;
            $this->iframe['id'] = $this->page.'table';
            $this->iframe['btwidth']  = '520';
            $this->iframe['btheight'] = $this->iframe['btheight'] ?? '650';
            $this->iframe['stwidth']  = '320';
            $this->iframe['stheight'] = $this->iframe['stheight'] ?? '550';
            $this->iframe['pwidth']   = '320';
            $this->iframe['pheight']  = '300';
            //$this->iframe['stage']    = [37521, 37519, 37522, 37523, 37520, 37525, 37526]; // or use $this->iframe['stages'] and do foreach directly
            // $grpstageids = $this->iframe['stage'] ?? [];
            // if(count($grpstageids)) {
            //     foreach($grpstageids as $val) {
            //         $this->iframe['stage'] = $val;
            //         $leaguetable[] = $this->iframe;
            //     }
            // }
            // $data['leaguetable'] = $leaguetable ?? [$this->iframe];
            //foreach group stage, echo iframe_teams inside display_iframe
        }
        $data['relatedposts']['list'] = related_posts($this->relposts);
        $this->view("free_predictions/freegames",$data);
    }

    function epl() {
        $this->page = $this->activepage = 'epl';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "English Premier League Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, epl tips, accurate epl prediction website, accurate premier league predictions, best epl prediction website, English Premier League, English Premier League predictions, English Premier League predictions and results';
            $this->description = 'Free soccer forecasts for English Premier League. Get the best EPL betting tips today from our experts, always available for both mid week and weekend fixtures.';
            $this->og['title'] = $data['page_title'];
            $this->og['description'] = 'Best Premier League Prediction Site. View the EPL Predictions for today, tomorrow and the weekend';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Free Football Predictions and Tips for England Premier League';
            $h2b = 'Which teams are currently in the Premier League?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'EPL Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de Championnat Angleterre";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, Championnat Angleterre, Prédictions de la Premier League anglaise, Pronostics et Résultats de Championnat Angleterre';
            $this->description = 'Site de Pronostic Foot Professionnel, voir notre Pronostics et Résultats de Championnat Angleterre maintenant.';
            $this->og['title'] = $data['page_title'];
            $this->og['description'] = 'Meilleurs pronostics de football gratuits pour la Barclays Premier League anglaise.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement de la Premier League Anglaise';
            $data['heroimg']['alt'] = 'Logo de la Premier League anglaise';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronósticos y resultados de la Premier League de Inglaterra";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos epl, predicciones epl, pronósticos y resultados de la Premier League de Inglaterra';
            $this->description = 'Pronósticos gratis para la Premier League inglesa. Obtenga hoy los mejores consejos de apuestas de EPL de nuestros expertos para los juegos de mitad de semana y de fin de semana.';
            $this->og['title'] = $data['page_title'];
            $this->og['description'] = 'Predicción de fútbol precisa y fuente más real de predicciones de expertos';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Predicciones y consejos de fútbol gratuitos para la Premier League de Inglaterra';
            $h2b = '¿Qué equipos están actualmente en la Premier League?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación de la Premier League inglesa';
            $data['heroimg']['alt'] = 'Logo de la Premier League inglesa';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Inglaterra Premier League";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da premier league, site de previsão precisa do EPL, melhor site de prognosticos da premier league, liga inglesa, prognósticos da premier league inglesa, dicas e resultados da liga Inglaterra, palpites Inglaterra premier league';
            $this->description = 'Palpites gratuitos da premier league. Receba as melhores dicas de apostas do Campeonato Inglês para hoje, amanhã, meio da semana e fim de semana.';
            $this->og['title'] = $data['page_title'];
            $this->og['description'] = 'Obtenha boas dicas gratuitas e vip todos os dias';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Palpites Inglaterra Premier League';
            $h2b = 'Quais times estão atualmente na Premier League?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela da Premier League inglesa';
            $data['heroimg']['alt'] = 'Logo do EPL';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse der englischen Premier League";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, epl tipps, beste EPL-Vorhersage-Website, Die englische Premier League, Vorhersagen für die englische Premier League, Vorhersagen und Ergebnisse der englischen Premier League';
            $this->description = 'Prognosen für die englische Liga. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für die englische Premier League für heute, morgen und das Wochenende an.';
            $this->og['title'] = $data['page_title'];
            $this->og['description'] = 'Holen Sie sich die besten fußball tipps vorhersage für heute';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Englische Liga (EPL) Wett Tipps von Experten';
            $h2b = 'Welche Teams spielen derzeit in der Premier League?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabelle der englischen Premier League';
            $data['heroimg']['alt'] = 'EPL-Logo';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'england/premier-league';
        $this->iframe['country']  = '67';
        $this->iframe['template'] = '10';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['laliga', 'bundesliga', 'seriea', 'ligue1', 'ucl', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function laliga() {
        $this->page = $this->activepage = 'laliga';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Spanish LaLiga Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, la liga tips, accurate la liga prediction site, best la liga prediction website, spanish laliga, spanish league predictions, primera division forecasts, spanish laliga predictions and results';
            $this->description = 'Best free LaLiga predictions for today, tomorrow and for the weekend.';
            $this->og['title'] = 'Free Spanish La Liga Predictions and Results';
            $this->og['description'] = 'Best La Liga Prediction Site. View the LaLiga Predictions for today, tomorrow and the weekend';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Free Expert Football Predictions and Tips for Spanish La Liga';
            $h2b = 'Which teams are currently in the Spanish League?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Spanish LaLiga Table';
            $data['heroimg']['alt'] = 'LaLiga Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de Championnat Espagnol";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, liga espagnol, Pronostics et Résultats de Championnat Espagnol';
            $this->description = 'Meilleur site de pronostics football de l\'année, consultez nos meilleures prévisions de la Liga espagnole pour les matchs en milieu de semaine et le week-end.';
            $this->og['title'] = 'Pronostics de La Liga espagnole';
            $this->og['description'] = 'Voir les prédictions et les résultats de la Liga espagnole pour aujourd\'hui sur ce vrai site de prédiction de football';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement de la Liga espagnole';
            $data['heroimg']['alt'] = 'Logo de la Liga espagnole';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronósticos y resultados de la Liga Española";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos la Liga, predicciones la Liga, predicciones y resultados de la Liga Española';
            $this->description = 'Los mejores pronósticos gratuitos de LaLiga para hoy, mañana y el fin de semana.';
            $this->og['title'] = 'Predicciones LaLiga Gratis';
            $this->og['description'] = 'Consulta los pronósticos de LaLiga para hoy, mañana y el fin de semana';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Predicciones y consejos de fútbol de expertos gratuitos para la Liga española';
            $h2b = '¿Qué equipos están actualmente en la liga español?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación de LaLiga española';
            $data['heroimg']['alt'] = 'Logo de La Liga española';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Espanha La Liga";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da la liga, site de previsão precisa da la liga, melhor site de prognosticos da la liga, la liga espanhola, prognósticos da espanha primeira liga, dicas e resultados da liga espanhola, palpites espanha la liga';
            $this->description = 'Palpites gratuitos da liga espanhola. Receba as melhores dicas de apostas do campeonatos espanhol para hoje, amanhã, meio da semana e fim de semana.';
            $this->og['title'] = 'Dicas gratuitas da la liga';
            $this->og['description'] = 'Veja os prognosticos da espanha primeira liga para hoje e para o fim de semana';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da liga espanhola';
            $h2b = 'Quais equipes estão atualmente na Liga Espanhola?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela da Liga Espanhola';
            $data['heroimg']['alt'] = 'Logo da Laliga Espanhola';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Spanische La Liga Vorhersagen und Ergebnisse";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, la liga tipps, best la liga prediction website, spanische La Liga, Vorhersagen für die spanische Liga, Primera Division Prognosen, Spanische La Liga Vorhersagen und Ergebnisse';
            $this->description = 'Prognosen für die spanische Liga. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für die spanische La Liga für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose Prognosen für La Liga';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die spanische La Liga für die Wochenmitte und das Wochenende an';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Spanische Liga Wett Tipps von Experten';
            $h2b = 'Welche Teams spielen derzeit in der Spanische Liga?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabelle der spanischen La Liga';
            $data['heroimg']['alt'] = 'Logo der spanischen LaLiga';
            $h3 = 'Zusammenhängende Posts';
        } 
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'spain/liga-bbva';
        $this->iframe['country']  = '201';
        $this->iframe['template'] = '43';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['epl', 'bundesliga', 'seriea', 'ligue1', 'ucl', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function bundesliga() {
        $this->page = $this->activepage = 'bundesliga';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "German Bundesliga Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, bundesliga betting tips, accurate bundesliga prediction website, best bundesliga prediction site, german bundesliga, german bundesliga predictions, german bundesliga predictions and results, german league predictions and results';
            $this->description = 'German league predictions from the best prediction site. View free German Bundesliga predictions, betting tips and results for today, tomorrow and the weekend.';
            $this->og['title'] = 'Free Bundesliga Predictions';
            $this->og['description'] = 'View the best free German Bundesliga predictions for the mid week and the weekend.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Free expert German League Predictions and tips';
            $h2b = 'Which teams are currently in the German Bundesliga?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'German Bundesliga Table/Standings';
            $data['heroimg']['alt'] = 'Bundesliga Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de Championnat Allemand";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, german bundesliga, german bundesliga predictions, Pronostics et Résultats de Championnat Allemand, Prédictions et résultats de la ligue allemande';
            $this->description = 'Prédictions de la ligue allemande de betagamers. Consultez nos pronostics, conseils et résultats de la ligue allemande gratuits pour aujourd\'hui et le week-end.';
            $this->og['title'] = 'Pronostics de Bundesliga Allemande';
            $this->og['description'] = 'Consultez nos prévisions gratuites pour la Bundesliga Allemande pour aujourd\'hui et chaque week-end.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement Bundesliga Allemande';
            $data['heroimg']['alt'] = 'Logo de la Bundesliga';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronósticos y resultados de la Bundesliga alemana";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos bundesliga, predicciones bundesliga, predicciones y resultados de la Bundesliga alemana';
            $this->description = 'Vea pronósticos gratuitos de la Bundesliga alemana, consejos de apuestas de expertos y resultados para hoy, mañana y el fin de semana.';
            $this->og['title'] = 'Pronosticos Bundesliga Gratis';
            $this->og['description'] = 'Vea los mejores Pronosticos Bundesliga alemanes gratis para la mitad de la semana y el fin de semana.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Predicciones gratuitas expertos de la liga alemana';
            $h2b = '¿Qué equipos están actualmente en la Bundesliga alemana?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación de la Bundesliga alemana';
            $data['heroimg']['alt'] = 'Logo de la Bundesliga alemana';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Alemanha Bundesliga";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da Bundesliga, site de previsão precisa da Bundesliga, melhor site de prognosticos da Bundesliga, Bundesliga Alemã, prognósticos da Bundesliga Alemã, palpites alemanha bundesliga, dicas e resultados da liga alemã';
            $this->description = 'Palpites gratuitos da Bundesliga. Receba as melhores dicas de apostas do Campeonato Alemão para hoje, amanhã, meio da semana e fim de semana.';
            $this->og['title'] = 'Dicas gratuitas da Bundesliga';
            $this->og['description'] = 'Veja os prognosticos da Bundesliga alemã para hoje e para o fim de semana.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da liga alemã';
            $h2b = 'Quais equipes estão atualmente na Bundesliga alemã?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela / classificações da Bundesliga alemã';
            $data['heroimg']['alt'] = 'Logo da Bundesliga';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse der deutschen Bundesliga";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, bundesliga Wetttipps, beste bundesliga-vorhersageseite, deutsche bundesliga, deutsche bundesliga prognosen, deutsche bundesliga prognosen und ergebnisse';
            $this->description = 'Prognosen für die deutsche Liga. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für die deutsche Bundesliga für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose Bundesliga Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die deutsche Bundesliga für die Wochenmitte und das Wochenende an.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Deutsche Liga Wett Tipps von Experten';
            $h2b = 'Welche Mannschaften spielen aktuell in der deutschen Bundesliga?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Deutsche Bundesliga Tabelle / Stand';
            $data['heroimg']['alt'] = 'Bundesliga-Logo';
            $h3 = 'Zusammenhängende Posts';
        } 
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'germany/1-bundesliga';
        $this->iframe['country']  = '83';
        $this->iframe['template'] = '16';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['laliga', 'epl', 'seriea', 'ligue1', 'ucl', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function ligue1() {
        $this->page = $this->activepage = 'ligue1';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "French Ligue1 Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, France ligue 1 tips, accurate ligue 1 prediction website, best ligue 1 prediction site, french ligue 1, french ligue 1 forecasts, french ligue 1 predictions and results';
            $this->description = 'Expert free predictions for the France Ligue 1, check out the French Ligue 1 predictions and results from Betagamers today.';
            $this->og['title'] = 'Free France Ligue 1 Predictions and Results';
            $this->og['description'] = 'View the French Ligue 1 Predictions from the best Football Prediction Website.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Free France Ligue 1 Predictions';
            $h2b = 'Which teams are currently in the France Ligue 1?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Ligue 1 Table';
            $data['heroimg']['alt'] = 'French Ligue 1 Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de Championnat France";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, Ligue 1 française, Pronostics et Résultats de Championnat France';
            $this->description = 'Pronostics gratuits et conseils de paris pour la Ligue 1 française, voir les pronostics et résultats de la Ligue 1 française pour aujourd\'hui et le week-end.';
            $this->og['title'] = 'Prédictions de Ligue 1 gratuites';
            $this->og['description'] = 'Voir les pronostics de Ligue 1 française sur le meilleur site de pronostics de football aujourd\'hui';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classements de Ligue 1';
            $data['heroimg']['alt'] = 'Logo de Ligue 1 française';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronósticos y resultados de la Ligue 1 francesa";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos ligue 1, predicciones ligue 1, pronósticos y resultados de la ligue 1 francesa';
            $this->description = 'Predicciones gratuitas de expertos para la Ligue 1 francesa, consulta los pronósticos de la Ligue 1 para hoy, mañana y el fin de semana.';
            $this->og['title'] = 'Pronosticos y resultados de la Ligue 1 gratis';
            $this->og['description'] = 'Consulta los predicciones de la Ligue 1 para hoy.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Predicciones Ligue 1 Gratis';
            $h2b = '¿Qué equipos están actualmente en la Ligue 1 francesa?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación Ligue 1';
            $data['heroimg']['alt'] = 'Logo de la Ligue 1 francesa';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Palpites França Liga 1";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da liga 1, site de previsão precisa da ligue 1, melhor site de prognosticos da ligue 1, primeira liga frança, prognósticos da frança ligue 1, palpites frança liga 1, dicas e resultados da 1 liga francesa';
            $this->description = 'Palpites gratuitos da Ligue 1. Receba as melhores dicas de apostas da liga 1 frança para hoje, amanhã, meio da semana e fim de semana.';
            $this->og['title'] = 'Dicas gratuitas da Ligue 1';
            $this->og['description'] = 'Veja os prognosticos da liga 1 frança para hoje e para o fim de semana.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da liga francesa';
            $h2b = 'Quais equipes estão atualmente na França Ligue 1?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela da Liga 1';
            $data['heroimg']['alt'] = 'Logo da Ligue 1 Francesa';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Französische Ligue 1 Vorhersagen und Ergebnisse";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Frankreich ligue 1 tipps, Beste Vorhersageseite für die Liga 1, Französische Liga 1, Vorhersagen für die französische Ligue 1, Französische Ligue 1 Vorhersagen und Ergebnisse';
            $this->description = 'Prognosen für die französische Liga. Sehen Sie sich Vorhersagen, Wetttipps und Ergebnisse für die französische Ligue 1 für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose Ligue 1 Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die französische Ligue 1 für die Wochenmitte und das Wochenende an.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Französische Liga Wett-Tipps von Experten';
            $h2b = 'Welche Mannschaften spielen aktuell in der französischen Ligue 1?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Liga 1 Tabelle';
            $data['heroimg']['alt'] = 'Logo der französischen Ligue 1';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'france/ligue-1';
        $this->iframe['country']  = '77';
        $this->iframe['template'] = '15';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['laliga', 'bundesliga', 'seriea', 'epl', 'ucl', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function seriea() {
        $this->page = $this->activepage = 'seriea';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Italian Serie A Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, serie a tips, accurate serie a prediction website, best serie a prediction site, italian serie a, italian serie a predictions, italian serie a predictions and results';
            $this->description = 'High quality football predictions for the Italian Serie A, view our free Serie A predictions today for tomorrow, mid week and the weekend.';
            $this->og['title'] = 'Free Predictions for Italian Serie A';
            $this->og['description'] = 'Free football predictions for the Italian Serie A. View the Italian League forecasts today for tomorrow and the weekend';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Italy Serie A Predictions Free';
            $h2b = 'Which teams are currently in the Serie A?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Italian Serie A Table';
            $data['heroimg']['alt'] = 'Italian Serie A Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de Championnat Italie";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, Serie A italienne, Pronostics et Résultats de Championnat Italie';
            $this->description = 'Site de prévisions de football de haute qualité avec de vrais conseils de prédiction, consultez gratuitement nos prévisions de Serie A italienne.';
            $this->og['title'] = 'Meilleures prédictions pour la Serie A italienne';
            $this->og['description'] = 'Voir les pronostics et les résultats de la Serie A italienne pour aujourd\'hui maintenant.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement Serie A italienne';
            $data['heroimg']['alt'] = 'Logo Serie A italienne';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronósticos y resultados de la Serie A italiana";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos gratis de la Serie A, predicciones Serie A, pronósticos y resultados de la Serie A italiana';
            $this->description = 'Vea nuestras pronosticos gratuitas de la Serie A hoy para mañana, a mitad de semana y el fin de semana.';
            $this->og['title'] = 'Predicciones Gratis para la Serie A Italiana';
            $this->og['description'] = 'Vea nuestras pronosticos de la Serie A hoy para mañana, a mitad de semana y el fin de semana';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Pronosticos Gratis Serie A';
            $h2b = '¿Qué equipos están actualmente en la Serie A?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación de la Serie A Italiana';
            $data['heroimg']['alt'] = 'Logo de la Serie A italiana';
            $h3 = 'Artículos Relacionados';
        }  elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Itália Série A";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da série a, site de previsão precisa da primeira liga italia, melhor site de prognosticos da série a, série a italiana, prognósticos da série a italiana, palpites itália série a, dicas e resultados da liga italiana';
            $this->description = 'Palpites gratuitos da série a. Receba as melhores dicas de apostas do Campeonato Italiano para hoje, amanhã, meio da semana e fim de semana.';
            $this->og['title'] = 'Dicas gratuitas da série a';
            $this->og['description'] = 'Veja os prognosticos da liga itália para hoje e para o fim de semana';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da liga italiana';
            $h2b = 'Quais equipes estão atualmente na Série A?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela / classificações da Série A Italia';
            $data['heroimg']['alt'] = 'Logo da Série A italiana';
            $h3 = 'Postagens relacionadas';
        }  elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Italienische Serie A Vorhersagen und Ergebnisse";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, serie a tipps, beste Serie A Vorhersageseite, Italienische Serie A, Prognosen der italienischen Liga, Italienische Serie A Vorhersagen und Ergebnisse';
            $this->description = 'Prognosen für die italienische Liga. Sehen Sie sich Vorhersagen, Wetttipps und Ergebnisse für die italienische Serie A für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose Serie A Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die Italienische Serie A für die Wochenmitte und das Wochenende an.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Italienische Liga Wett Tipps von Experten';
            $h2b = 'Welche Teams spielen derzeit in der Serie A?';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabelle der italienischen Serie A';
            $data['heroimg']['alt'] = 'Logo der italienischen Serie A';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'italy/serie-a';
        $this->iframe['country']  = '108';
        $this->iframe['template'] = '17';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['laliga', 'bundesliga', 'epl', 'ligue1', 'ucl', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function ucl() {
        $this->page = $this->activepage = 'ucl';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "UEFA Champions League Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, UEFA Champions League, UEFA Champions League predictions, UEFA Champions League predictions and results';
            $this->description = 'The best among the top soccer prediction sites with real football predictions, view our UEFA Champions League predictions now.';
            $this->og['title'] ='Free UCL Predictions';
            $this->og['description'] = 'Best free UCL prediction site in the world. View the UEFA Champions League Predictions and Results for free';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Best Free UCL Predictions and tips';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'UCL Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostics et Résultats de la Ligue des Champions de l\'UEFA";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, la Ligue des Champions de l\'UEFA, Pronostics et Résultats de la Ligue des Champions de l\'UEFA';
            $this->description = 'Le meilleur site de prédiction de football avec de vraies prédictions de football, voir nos UEFA Champions League predictions maintenant.';
            $this->og['title'] ='Site de Pronostic UCL';
            $this->og['description'] = 'Voir gratuitement nos Pronostics et Résultats de la Ligue des Champions de l\'UEFA';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo de la Ligue des champions de l\'UEFA';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronosticos y resultados de la Liga de Campeones de la UEFA";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos ucl, predicciones ucl, pronosticos Champions League, pronosticos y resultados de la Liga de Campeones de la UEFA';
            $this->description = 'Obtenga acceso a las mejores predicciones de la Liga de Campeones ahora.';
            $this->og['title'] ='Predicciones gratis de UCL';
            $this->og['description'] = 'Vea los pronosticos gratis de la Liga de Campeones de la UEFA';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo de la Liga de Campeones de la UEFA';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Champions League";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da champions league, site de previsão precisa da UCL, melhor site de prognosticos da UCL, Liga dos Campeões UEFA, prognósticos da Liga dos Campeões UEFA, palpites champions league, dicas e resultados da champions league UEFA';
            $this->description = 'Palpites gratuitos da champions league. Receba as melhores dicas de apostas da Liga dos Campeões para hoje e para amanhã.';
            $this->og['title'] ='Dicas gratuitas da Champions League';
            $this->og['description'] = 'Veja os prognosticos da liga dos campeões para hoje e para amanhã';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo da Série A italiana';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse der UEFA Champions League";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, sports tips, UEFA Champions League, Prognosen zur UCL, Vorhersagen und Ergebnisse der UEFA Champions League';
            $this->description = 'Prognosen für UCL. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für der UEFA Champions League für heute, morgen und das Wochenende an.';
            $this->og['title'] ='Kostenlose UCL Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für der UEFA Champions League für die Wochenmitte und das Wochenende an.';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo do UCL';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        // $this->iframe['league']   = 'england/premier-league';
        // $this->iframe['country']  = '67';
        // $this->iframe['template'] = '10';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['epl', 'laliga', 'bundesliga', 'seriea', 'ligue1', 'europa', 'teams', 'predict'];
        return $this->league($data);
    }

    function europa() {
        $this->page = $this->activepage = 'europa';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Europa League Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, Europa League, Europa League predictions, Europa League predictions and results';
            $this->description = 'Best football predictions and tips site, view our Europa League predictions now.';
            $this->og['title'] ='Europa League Betting Tips';
            $this->og['description'] = 'Best Europa League prediction site. View our Europa League Predictions now';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Best Free Europa League Predictions and tips';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Europa League Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Pronostic et Résultats de Ligue Europa";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, Ligue Europa, Pronostic et Résultats de Ligue Europa';
            $this->description = 'Site de pronostics football expert, consultez nos prévisions gratuites de la Ligue Europa maintenant.';
            $this->og['title'] ='Prévisions de la Ligue Europa';
            $this->og['description'] = 'Le meilleur site pour les pronostics de la Ligue Europa. Consultez nos prévisions de Ligue Europa maintenant';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Classement des groupes de l\'UEFA Europa League';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronosticos y resultados de la Liga Europea";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos europa league, predicciones europa league, Pronosticos y resultados de la Liga Europea';
            $this->description = 'Obtenga acceso a las mejores predicciones gratis de la Liga Europea.';
            $this->og['title'] ='Pronósticos de la Europa League';
            $this->og['description'] = 'Vea los pronosticos gratis de la Liga Europea ahora';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Pronosticos Gratis de la Liga Europea';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo de la liga europea';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Liga Europa";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da europa league, site de previsão precisa da liga europa, melhor site de prognosticos da liga europa, liga europa, prognósticos da europa league, palpites liga europa, dicas e resultados da europa league';
            $this->description = 'Palpites gratuitos da europa league. Receba as melhores dicas de apostas da liga europa para hoje, quinta-feira.';
            $this->og['title'] ='Dicas gratuitas da Europa League';
            $this->og['description'] = 'Veja os prognosticos da liga europa para quinta-feira';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da Europa League';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo da Liga Europa';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse der Europa League";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Europa Liga, Prognosen zur Europa League, Vorhersagen und Ergebnisse der Europa League';
            $this->description = 'Prognosen für die Europa Liga. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für der UEFA Europa League für heute, morgen und das Wochenende an.';
            $this->og['title'] ='Kostenlose Europa League Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für der UEFA Europa League für die Wochenmitte und das Wochenende an';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'UEFA Europa Liga Wett Tipps von Experten';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            // $this->default_iframe_values();
            // $this->iframe['teamsh'] = 'English Premier League Table';
            $data['heroimg']['alt'] = 'Logo der Europa League';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        // $this->iframe['league']   = 'england/premier-league';
        // $this->iframe['country']  = '67';
        // $this->iframe['template'] = '10';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['ucl', 'epl', 'laliga', 'bundesliga', 'seriea', 'ligue1', 'teams', 'predict'];
        return $this->league($data);
    }

    function euro() {
        $this->page = $this->activepage = 'euro';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "UEFA Euro 2024 Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, UEFA European Championship tips, euro predictions, UEFA euro forecast, euro tournament predictions and results';
            $this->description = 'Get access to UEFA European Championship (EURO 2024) predictions and the results for free from the best Euro forecast site.';
            $this->og['title'] = 'EURO Betting Tips';
            $this->og['description'] = 'View the EURO predictions and results at Betagamers';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Best Free European Championship (EURO) Predictions and Tips';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'UEFA European Championship (EURO 2024) Group Table/Standings';
            $data['heroimg']['alt'] = 'UEFA European Championship  Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Prédictions et résultats de l\'UEFA Euro 2024";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, euro UEFA, meilleurs conseils de paris gratuits pour le Championnat d\'Europe de l\'UEFA';
            $this->description = 'Verifiez maintenant pour voir les meilleures pronos gratuits pour le Compétition du Championnat d\'Europe de l\'UEFA.';
            $this->og['title'] = 'Prédictions EURO';
            $this->og['description'] = 'Voir les prévisions et les résultats du Championnat d\'Europe à Betagamers';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Meilleurs pronostics gratuits pour le championnat d\'Europe (EURO)';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement des groupes du Championnat d\'Europe de l\'UEFA (EURO 2024)';
            $data['heroimg']['alt'] = 'Logo de l\'UEFA Euro';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronosticos del EURO 2024";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos euro, predicciones euro, pronósticos y resultados del Campeonato de Europa';
            $this->description = 'Obtenga acceso a las predicciones y los resultados del Campeonato de Europa de la UEFA de forma gratuita.';
            $this->og['title'] = 'Pronosticos EURO';
            $this->og['description'] = 'Vea las predicciones para la EURO 2024';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Pronosticos gratis del Campeonato de Europa (EURO 2024)';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación / Tabla del EURO 2024';
            $data['heroimg']['alt'] = 'Logo del Campeonato de Europa de la UEFA';
            $h3 = 'Artículos Relacionados';
        } if(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites UEFA Euro 2024";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da UEFA Euro, site de previsão precisa da UEFA Euro, melhor site de prognosticos da UEFA Euro, Campeonato Europeu, prognósticos da Campeonato Europeu, palpites UEFA Euro, dicas e resultados do Campeonato Europeu';
            $this->description = 'Palpites gratuitos da UEFA Euro 2024. Obtenha as melhores dicas de apostas do Campeonato Europeu para hoje, amanhã e para esta semana.';
            $this->og['title'] = 'Dicas gratuitas da EURO 2024';
            $this->og['description'] = 'Dê uma olhada nos prognosticos do Campeonato Europeu para hoje e para amanhã';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Prognósticos e resultados gratuitos da UEFA Euro 2024';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela / Classificação do Grupo do Campeonato da Europa da UEFA (EURO 2024)';
            $data['heroimg']['alt'] = 'Logo da UEFA Euro';
            $h3 = 'Postagens relacionadas';
        } if(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse der UEFA Euro 2024";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Tipps zur UEFA Europameisterschaft, Euro Prognosen, UEFA-Euro-Prognose, Vorhersagen und Ergebnisse des Euro-Turniers';
            $this->description = 'Prognosen für die deutsche Liga. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für die deutsche Bundesliga für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose Euro Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die UEFA-Europameisterschaft für die Wochenmitte und das Wochenende an';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'EURO 2024 Wett Tipps von Experten';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Gruppentabelle der Europameisterschaft (EURO 2024)';
            $data['heroimg']['alt'] = 'Logo der UEFA-Europameisterschaft';
            $h3 = 'Zusammenhängende Posts';
        } 
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'europeanchampionship';
        $this->iframe['country']  = '12';
        $this->iframe['template'] = '';
        $this->iframe['stage'] = [38814, 38812, 38815, 38817, 38813, 38816];
        $this->iframe['btheight'] = $this->iframe['stheight'] = '165';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['afcon', 'ucl', 'europa', 'epl', 'laliga', 'bundesliga', 'ligue1', 'seriea', 'teams', 'predict'];
        return $this->league($data);
    }

    function afcon() {
        $this->page = $this->activepage = 'afcon';
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "African Cup of Nations Predictions and Results";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, afcon, african nations cup predictions, african nations cup tournament predictions and results';
            $this->description = 'Accurate football predictions and tips site, view the predictions and the results from the African Cup of Nations Tournament here on Betagamers.';
            $this->og['title'] = 'AFCON Betting Tips';
            $this->og['description'] = 'View the African Cup of Nations predictions and results at Betagamers';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = 'Free Football Predictions and Tips for England Premier League';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'African Nations Cup Group Table/Standings';
            $data['heroimg']['alt'] = 'African Nations Cup Logo';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Prédictions et résultats de la Coupe d\'Afrique des Nations";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web du betagamers, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, afcon, african nations cup predictions, african nations cup tournament predictions and results';
            $this->description = 'Consultez les pronostics et les résultats du tournoi de la Coupe d\'Afrique des Nations ici sur Betagamers.';
            $this->og['title'] = 'Prédictions AFCON';
            $this->og['description'] = 'Voir les prévisions et les résultats de la Coupe d\'Afrique des Nations à Betagamers';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Classement des groupes de la Coupe d\'Afrique des nations';
            $data['heroimg']['alt'] = 'Logo de la Coupe d\'Afrique des Nations';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Pronosticos y resultados de la Copa Africana de Naciones";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, consejos afcon, predicciones afcon, pronosticos y resultados de la Copa Africana de Naciones';
            $this->description = 'Consulta los pronósticos gratis y los resultados del Torneo de AFCON.';
            $this->og['title'] = 'Consejos de apuestas para la Copa Africana de Naciones';
            $this->og['description'] = 'Vea los pronosticos y resultados de la Copa Africana de Naciones';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Clasificación / Tabla de AFCON';
            $data['heroimg']['alt'] = 'Logo de AFCON';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Palpites Copa Africana de Nações";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, dicas de apostas da Copa Africana de Nações, site de previsão precisa da AFCON, melhor site de prognosticos da AFCON, Copa das Nações Africanas, prognósticos da Copa Africana de Nações, palpites Copa Africana de Nações, dicas e resultados da Copa Africana de Nações';
            $this->description = 'Palpites gratuitos da AFCON. Obtenha as melhores dicas de apostas do Copa Africana de Nações para hoje, amanhã e para esta semana.';
            $this->og['title'] = 'Dicas gratuitas da AFCON';
            $this->og['description'] = 'Dê uma olhada nos prognosticos da Copa Africana de Nações para hoje e para amanhã';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Tabela / Classificação do Grupo da Copa das Nações Africanas';
            $data['heroimg']['alt'] = 'Logo da Copa das Nações Africanas';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Vorhersagen und Ergebnisse des Afrikanischen Nationen-Pokals";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, afcon, Prognosen zum Afrikanischen Nationenpokal, Vorhersagen und Ergebnisse des African Nations Cup-Turniers';
            $this->description = 'Prognosen für die AFCON. Sehen Sie sich Vorhersagen, Wett tipps und Ergebnisse für die Afrikanischer Nationen-Pokal für heute, morgen und das Wochenende an.';
            $this->og['title'] = 'Kostenlose AFCON Vorhersagen';
            $this->og['description'] = 'Sehen Sie sich die Prognosen für die Afrikanischer Nationen-Pokal für die Wochenmitte und das Wochenende an';
            //$hero_image = ['name'=>$this->page, 'alt'=>'EPL Logo'];
            $h2a = '';
            $h2b = '';
            //$data['nogames'] = ['No games here for the selected period', 'No games here yet. Please check back later.'];
            //$filename = ROOT.'/free_predicts/epl.php';
            $this->default_iframe_values();
            $this->iframe['teamsh'] = 'Gruppentabelle des Afrikanischer Nationen-Pokal';
            $data['heroimg']['alt'] = 'Logo des Afrikanischen Nationen-Pokals';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $data['h2a'] = $h2a;
        $data['h2b'] = $h2b;
        $this->iframe['league']   = 'africacupofnations';
        $this->iframe['country']  = '202';
        $this->iframe['template'] = '';
        $this->iframe['stage'] = [28216, 28221];
        $this->iframe['btheight'] = $this->iframe['stheight'] = '165';
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['euro', 'ucl', 'europa', 'epl', 'laliga', 'bundesliga', 'ligue1', 'seriea', 'teams', 'predict'];
        return $this->league($data);
    }

    // function jackpots() {} //list all bookies / use accordions / use toggle tabs

    function all() {
        //classic, over_25
        $dateperiods = new DatePeriod(
            new DateTime('today'),
            new DateInterval('P1D'),
            new DateTime('tomorrow +2days')
       );

       foreach($dateperiods as $dateval) {
        echo  $dateval->format('Y-m-d');
       }exit;

       foreach(['classic', 'over_25'] as $market) {
           foreach(['UEFA', 'CAF', 'OFC', 'CONMEBOL', 'CONCACAF', 'AFC'] as $federations) {
               foreach($dateperiods as $dateval) {
                $date = $dateval->format('Y-m-d');
                   $curl = curl_init();
                   curl_setopt_array($curl, [
                       CURLOPT_URL => "https://football-prediction-api.p.rapidapi.com/api/v2/predictions?market=$market&iso_date=$date&federation=$federations",
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_ENCODING => "",
                       CURLOPT_MAXREDIRS => 10,
                       CURLOPT_TIMEOUT => 30,
                       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                       CURLOPT_CUSTOMREQUEST => "GET",
                       CURLOPT_HTTPHEADER => [
                           "x-rapidapi-host: football-prediction-api.p.rapidapi.com",
                           "x-rapidapi-key: 90ad353c96msh32fba7e1fd20e5dp1ce5c9jsn11db66ea4b79"
                       ],
                   ]);
                   $response = curl_exec($curl);
                   $err = curl_error($curl);
                   
                   curl_close($curl);
                   
                   $alldata[$market][$federations][$date] = $err ?? json_decode($response);
                   
                //    if ($err) {
                //        echo "cURL Error #:" . $err;
                //    } else {
                //        $print = json_encode(json_decode($response), JSON_PRETTY_PRINT);
                //        show($print);
                //        // echo $response;
                //    }
               }
           }
       }
       show($alldata);exit;
        $classics = json_decode($response);
        $ovun = json_decode($response);
        foreach($classics as $ind=>$val) {
            if($val['prediction'] = 'X') {
                /*if($ovun[$ind]['prediction'] == 'Over 2.5') {
                    
                }*/
                $prediction = $ovun[$ind]['prediction'];
                if($ovun[$ind]['odds'][$prediction] >= 1.70) $val['prediction'] = str_replace('2.5', '3.5', $prediction);
            }
            $leagues[$val['competition_cluster']][][substr($val['start_date'], 0, 10)] = $val;
        }
    }

    function teams() {
        $this->page = $this->activepage = 'teams';
        $this->writeuponly = true;
        $htm = ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG.'/teams/'.$this->page.'.htm';
        $html = ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG.'/teams/'.$this->page.'.html';
        $strtohtm = file_exists($htm) ? filemtime($htm) : 0;
        $strtohtml = file_exists($html) ? filemtime($html) : 0;
        // var_dump($strtohtml<=>$strtohtm);
        $this->filename = match($strtohtml<=>$strtohtm) {
            -1=>$htm,
            1=>$html,
            default=>$strtohtm ? $htm : exit('Error selecting which page to show. Please contact admin about this.')
        };
        
        // $this->filename = $ROOT.'/app/betagamers/incs/free_games/'.LANG.'/'.$this->page.'.htm';
        $this->urls = [
            'en'=>'https://betagamers.net/free_predictions/teams.php'
        ];
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Good Teams to Bet on this Weekend";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, top ten most in form teams, top ten teams to bet on, good teams to bet on this weekend';
            $this->description = 'The best straight wins for the weekend, check out the top most in form good teams that you can bet on this weekend that hopefully will win.';
            $this->og['description'] = 'Straight wins for the weekend. View the top ten most in-form teams to bet on this weekend.';
            $data['heroimg']['alt'] = 'Top Teams to bet on';
            $h3 = 'Related Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $this->og['title'] = 'Best Teams for the Weekend';
        $data['writeup'] = file_get_contents($this->filename);
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['epl', 'laliga', 'bundesliga', 'ligue1', 'seriea', 'ucl', 'europa', 'guide', 'predict'];
        return $this->league($data);
    }

    function howtopredict() {
        $this->page = $this->activepage = 'howtopredict';
        $this->writeuponly = true;
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "How to Predict Football Matches Correctly";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, best football prediction website, how to predict football matches correctly, how to predict football matches';
            $this->description = 'Real football predictions and tips site. Betagamers is a good prediction site hence provides real tips on how to predict football matches correctly';
            $this->og['description'] = 'Learn how to predict football matches correctly';
            $data['heroimg']['alt'] = 'Predicting Football Matches Correctly';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Comment pronostiquer les matchs de football avec précision";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, comment prédire correctement les matchs de football, comment prédire les matchs de football';
            $this->description = 'Véritable site de pronostics et de conseils sur le football. Obtenez de vrais conseils pour prédire correctement les matchs de football';
            $this->og['description'] = 'Apprenez à prédire avec précision les matchs de football';
            $data['heroimg']['alt'] = 'Prédire correctement les matchs de football';
            $h3 = 'Articles Similaires';
        } elseif(LANG=='es') {
            $data['page_title'] = $data['h1'] = "Cómo predecir correctamente los partidos de fútbol";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, sitio preciso de predicción de deportes, mejor sitio web de predicción de fútbol, Cómo predecir correctamente los partidos de fútbol, como predecir partidos de futbol';
            $this->description = 'Aprende los consejos sobre cómo predecir correctamente los partidos de fútbol';
            $this->og['description'] = 'Aprende cómo predecir correctamente los partidos de fútbol';
            $data['heroimg']['alt'] = 'imagen de una pelota';
            $h3 = 'Artículos Relacionados';
        } elseif(LANG=='pt') {
            $data['page_title'] = $data['h1'] = "Como prever partidas de futebol corretamente";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, como prever partidas de futebol, como prever partidas de futebol corretamente, melhores maneiras de prever partidas de futebol';
            $this->description = 'Aprenda a prever partidas de futebol corretamente como um profissional e ganhe sempre.';
            $this->og['description'] = 'Aprenda a prever partidas de futebol corretamente como um profissional.';
            $data['heroimg']['alt'] = 'Prevendo partidas de futebol corretamente';
            $h3 = 'Postagens relacionadas';
        } elseif(LANG=='de') {
            $data['page_title'] = $data['h1'] = "Wie man Fußballspiele richtig vorhersagt";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, wie man Fußballspiele vorhersagt, Wie man Fußballspiele richtig vorhersagt';
            $this->description = 'Erfahren Sie noch heute, wie Sie Fußballspiele richtig vorhersagen';
            $this->og['description'] = 'Erfahren Sie noch heute, wie Sie Fußballspiele richtig vorhersagen';
            $data['heroimg']['alt'] = 'Fußballspiele richtig vorhersagen';
            $h3 = 'Zusammenhängende Posts';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $this->og['title'] = $data['page_title'];
        $data['writeup'] = file_get_contents(ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG.'/howtopredict.php');
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['epl', 'laliga', 'bundesliga', 'ligue1', 'seriea', 'ucl', 'europa', 'teams', 'guide'];
        return $this->league($data);
    }

    function guide() {
        $this->page = $this->activepage = 'guide';
        $this->writeuponly = true;
        if(LANG=='en') {
            $data['page_title'] = $data['h1'] = "Betting Guide for Beginners";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, best complete betting guide';
            $this->description = 'Best football predictions and tips website in the world, learn about the common terms used in football betting in this complete betting guide for beginners.';
            $this->og['description'] = 'The complete betting guide by BetaGamers.';
            $data['heroimg']['alt'] = 'Common Terms used in FootBall Betting';
            $h3 = 'Related Posts';
        } elseif(LANG=='fr') {
            $data['page_title'] = $data['h1'] = "Guide de paris pour les débutants";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, meilleur guide de paris complet';
            $this->description = 'Meilleur site de pronostics et de conseils sur le football dans le monde, trouvez les termes courants utilisés dans les paris sur le football dans ce guide de paris complet pour les débutants.';
            $this->og['description'] = 'Le guide de paris complet par BetaGamers.';
            $data['heroimg']['alt'] = 'Termes courants utilisés dans les paris FootBall';
            $h3 = 'Articles Similaires';
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/'.$this->page.'1x.jpg';
        $this->og['title'] = 'Best football prediction website';
        $data['writeup'] = file_get_contents(ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG.'/guide.php');
        $data['relatedposts']['h3'] = $h3;
        $this->relposts = ['epl', 'laliga', 'bundesliga', 'ligue1', 'seriea', 'ucl', 'europa', 'teams', 'predict', 'tennisguide'];
        return $this->league($data);
    }
}