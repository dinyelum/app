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
        ['en'=>'CONTACT US', 'fr'=>'NOUS CONTACTER'],
        ['en'=>'FAQs', 'fr'=>'FAQs'],
        ['en'=>'PRICING PLANS', 'fr'=>'COMMENT ÇA FONCTIONNE'],
        ['en'=>'HOW IT WORKS', 'fr'=>'PLANS TARIFAIRES'],
        ['en'=>'JOBS', 'fr'=>'EMPLOI'],
        ['en'=>'T & Cs', 'fr'=>'TERMES'],
        ['en'=>'PRIVACY POLICY', 'fr'=>'POLITIQUE DE CONFIDENTIALITÉ'],
        ['en'=>'ABOUT US', 'fr'=>'À PROPOS DE NOUS'],
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
