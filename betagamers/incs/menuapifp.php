<?php
// [
//     'CUURENT'=>[
//         'ALPHA PICKS'=>['link'=>tips_links('ap'), 'id'=>'ap'],
//     ],
//     'OTHERS'=>[
//         '5 ODDS'=>['link'=>tips_links('5odds'), 'id'=>'5odds'],
//         '10 ODDS'=>['link'=>tips_links('10odds'), 'id'=>'10odds'],
//         'DOUBLE CHANCE'=>['link'=>tips_links('dblchance'), 'id'=>'dblchance'],
//         'OVER/UNDER'=>['link'=>tips_links('ovun'), 'id'=>'ovun'],
//         'BTS'=>['link'=>tips_links('bts'), 'id'=>'bts'],
//         'STRAIGHT WIN'=>['link'=>tips_links('straight'), 'id'=>'straight']
//     ],
// ];
include INCS."/glossary.php";
$lang = match (LANG) {
    'fr' => $fr,
    'es' => $es,
    'pt' => $pt,
    'de' => $de,
    default => $en
};
$allfootballprediction = match (LANG) {
    'fr' => 'TOUS LES PRONOSTICS DE FOOTBALL',
    'es' => 'TODAS LAS PREDICCIONES DE FÚTBOL',
    'pt' => 'TODAS AS PREVISÕES DE FUTEBOL',
    'de' => 'ALLE FUSSBALLVORHERSAGEN',
    default => 'ALL FOOTBALL PREDICTION'
};
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(INCS."/free_predicts_apis/football-prediction/".LANG),
    RecursiveIteratorIterator::LEAVES_ONLY
);
$exceptions = ['england-premier_league'];
foreach($files as $file) {
    if($file->getExtension() == 'php') {
        $filename = $file->getBasename('.php');
        $fullfilename = $file->getFilename();
        $filemtime = $file->getMTime();
        if(in_array($filename, $exceptions)) continue;
        list($country, $league) = explode('-', $filename);
        $country = str_ireplace($en, $lang, str_replace('_', ' ', $country));
        $league = ucwords(str_replace('_', ' ', $league));
        $this->country = $this->country ?? ($this->page==$filename ? $country : null);
        $this->league = $this->league ?? ($this->page==$filename ? $league : null);
        if($filemtime >= strtotime('yesterday -1day')) {
            $current_tips_list[strtoupper($country)][$league] = ['link'=>free_games_link($filename), 'id'=>$filename];
        } else {
            $others_tips_list[strtoupper($country)][$league] = ['link'=>free_games_link($filename), 'id'=>$filename];
        }
    }
}
$others_tips_list = $others_tips_list ?? [];
ksort($current_tips_list);
ksort($others_tips_list);
$sidelistarr = side_list_top();
$sidelistarr += [$allfootballprediction=>['link'=>free_games_link(), 'id'=>null]] + $current_tips_list + $others_tips_list;
// show($sidelistarr);
$sidelist = [];
foreach ($sidelistarr as $key=>$val) {
    if(array_key_exists('link', $val)) {
        if($val['id']=='on' || $val['id']=='off') {
            if($val['id']=='on' && (USER_LOGGED_IN)) {
                $sidelist[] = "<a ".(($this->page == $val['id'] || $this->page == $val['country']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
            } elseif($val['id']=='off' && (!USER_LOGGED_IN)) {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
            } else {}
        } else {
            $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        }
    } else {
        $sidelist[] = "<button class='w3-btn w3-block w3-left-align w3-green accobtn'>$key<i class='fa fa-plus w3-right'></i></button>
        <div class='w3-hide accocontent'>";
        foreach($val as $subkey=>$subval) {
            $sidelist[] = "<a ".(($this->page == $subval['id']) ? "class='active'" : '')." href=".$subval['link'].">$subkey</a>";
        }
        $sidelist[] = "</div>";
    }
}
//show($sidelist);