<?php
$sidelistarr = side_list_top();
$support_list = $en_support_list = [
    'CONTACT US'=>['link'=>support_links(), 'id'=>'contact'],
    'FAQs'=>['link'=>support_links('faqs'), 'id'=>'faqs'],
    'PRICING PLANS'=>['link'=>support_links('prices'), 'id'=>'prices'],
    'HOW IT WORKS'=>['link'=>support_links('howitworks'), 'id'=>'howitworks'],
    'JOBS'=>['link'=>support_links('jobs'), 'id'=>'jobs'],
    'T & Cs'=>['link'=>support_links('terms'), 'id'=>'terms'],
    'PRIVACY POLICY'=>['link'=>support_links('privacy'), 'id'=>'privacy'],
    'ABOUT US'=>['link'=>support_links('aboutus'), 'id'=>'aboutus']
    ];

if(LANG != 'en') {
    $ol_support_list = [
        ['en'=>'CONTACT US', 'fr'=>'NOUS CONTACTER', 'es'=>'CONTÁCTENOS', 'pt'=>'CONTATE-NOS', 'de'=>'KONTAKTIERE UNS'],
        ['en'=>'FAQs', 'fr'=>'FAQs', 'es'=>'PREGUNTAS FRECUENTES', 'pt'=>'PERGUNTAS FREQUENTES', 'de'=>'HÄUFIG GESTELLTE FRAGEN'],
        ['en'=>'PRICING PLANS', 'fr'=>'PLANS TARIFAIRES', 'es'=>'PRECIOS', 'pt'=>'PREÇOS', 'de'=>'PREISPLÄNE'],
        ['en'=>'HOW IT WORKS', 'fr'=>'COMMENT ÇA FONCTIONNE', 'es'=>'CÓMO FUNCIONA', 'pt'=>'COMO FUNCIONA', 'de'=>'WIE ES FUNKTIONIERT'],
        ['en'=>'JOBS', 'fr'=>'EMPLOI', 'es'=>'EMPLEOS', 'pt'=>'EMPREGOS', 'de'=>'ARBEITSPLÄTZE'],
        ['en'=>'T & Cs', 'fr'=>'TERMES', 'es'=>'TÉRMINOS Y CONDICIONES', 'pt'=>'TERMOS E CONDIÇÕES', 'de'=>'GESCHÄFTSBEDINGUNGEN'],
        ['en'=>'PRIVACY POLICY', 'fr'=>'POLITIQUE DE CONFIDENTIALITÉ', 'es'=>'PRIVACIDAD', 'pt'=>'POLÍTICA DE PRIVACIDADE', 'de'=>'DATENSCHUTZ-BESTIMMUNGEN'],
        ['en'=>'ABOUT US', 'fr'=>'À PROPOS DE NOUS', 'es'=>'SOBRE NOSOTROS', 'pt'=>'SOBRE NÓS', 'de'=>'ÜBER UNS'],
        ];
    
    $support_list = array_combine(array_column($ol_support_list, LANG), array_values($en_support_list));
}
$sidelistarr += $support_list;
// show($sidelistarr);
$sidelist = [];
foreach($sidelistarr as $key=>$val) {
    if($val['id']=='on' || $val['id']=='off') {
        if($val['id']=='on' && (isset($_SESSION['users']["logged_in"]) && $_SESSION['users']["logged_in"] === true)) {
            $sidelist[] = "<a ".(($this->page == $val['id'] || $this->page == $val['country']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        } elseif($val['id']=='off' && (!isset($_SESSION['users']["logged_in"]) || $_SESSION['users']["logged_in"] !== true)) {
            $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        } else {}
    } else {
        $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')."href=".$val['link'].">$key</a>";
    }
}
