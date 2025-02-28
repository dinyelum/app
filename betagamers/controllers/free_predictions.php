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
        }
        $this->og['url'] = URI;
        $this->og['image'] = HOME.'/assets/images/soccerfield.jpg';
        $this->og['title'] = $data['page_title'];
        $data['socials'] = file_get_contents ($this->socials);
        $posts = ['epl', 'seriea', 'bundesliga', 'laliga', 'ligue1', 'ucl', 'europa', 'predict', 'afcon', 'euro', 'teams', 'guide'];
        $data['posts']['list'] = array_chunk(related_posts($posts), 3, true);
        $this->view("free_predictions/index",$data);
    }

    function iframe_teams($width, $height, $stage=null) {
        $frame = $this->iframe?>
        <iframe width="<?=$width?>" height="<?=$height?>" src="https://www.fctables.com/<?=$frame['league']?>/iframe/?type=table&lang_id=<?=$frame['langid']?>&country=<?=$frame['country'].(isset($stage) ? "&stage=".$stage : '')?>&template=<?=$frame['template']?>&timezone=Africa/Lagos&time=24&po=1&ma=1&wi=1&dr=1&los=1&gf=1&ga=1&gd=1&pts=1&ng=1&form=1&width=<?=$width?>&height=<?=$height?>&font=Verdana&fs=12&lh=22&bg=FFFFFF&fc=333333&logo=0&tlink=0&scfs=22&scfc=333333&scb=1&sclg=1&teamls=80&ths=1&thb=1&thba=FFFFFF&thc=000000&bc=dddddd&hob=f5f5f5&hobc=ebe7e7&lc=333333&sh=1&hfb=1&hbc=008000&hfc=FFFFFF"></iframe><?php
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
        } ellseif(LANG=='fr') {
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