<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title><?=$data['page_title']?> | <?=SITENAME?></title><?php
if($this->metabots) {?>
    <meta name="robots" content="<?=$this->metabots?>" ><?php
}?>
<meta charset="utf-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta name='theme-color' content='#473C6A'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='author' content='<?=SITENAME?>'>
<meta name='keywords' content='<?=$this->keywords?>'>
<meta name='description' content='<?=$this->description?>' ><?php
if(count($this->og)) {?>
    <meta property="og:url" content="<?=$this->og['url']?>" >
    <meta property="og:type" content="article" >
    <meta property="og:title" content="<?=$this->og['title']?>" >
    <meta property="og:description" content="<?=$this->og['description']?>" >
    <meta property="og:image" content="<?=$this->og['image']?>" >
    <meta property="og:image:type" content="<?=$this->og['imagetype']?>" >
    <meta property="og:image:width" content="<?=$this->og['imagew'] ?? 200 ?>" >
    <meta property="og:image:height" content="<?=$this->og['imageh'] ?? 200 ?>" ><?php
}?>
<link rel='icon' href='<?=HOME?>/favicon.ico'>
<link rel='preload' href='<?=HOME?>/assets/css/style.css' as='style'>
<link rel='stylesheet' type='text/css' href='<?=HOME?>/assets/css/style.css' >
<script src="https://kit.fontawesome.com/906d05b5f6.js" crossorigin="anonymous"></script><?php
if($this->style) {?>
    <style><?=$this->style?></style><?php
}
if($this->page=='home') {?>
    <!-- Schema.org -->
    <script type = 'application/ld+json'> 
    {
    "@context": "https://schema.org",
    "@graph": [{
    "@type": "Organization",
    "@id": "https://excelwrite.com/#organization",
    "name": "ExcelWrite Services",
    "alternateName": "ExcelWrite",
    "url": "https://excelwrite.com/",
    "logo": "https://excelwrite.com/assets/images/logo.png",
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "",
        "contactType": "customer service"
    },
    "sameAs": [<?php
        foreach($data['footersocials'] as $val) {
            if(strtolower($val['channel']) == 'facebook' || strtolower($val['channel']) == 'x' || strtolower($val['channel']) == 'instagram' || strtolower($val['channel']) == 'pinterest') {?>
            "<?=$val['link']?>",<?php
            }
        }?>
    ]
    }, {
    "@type": "WebSite",
    "@id": "https://excelwrite.com/#website",
    "url": "https://excelwrite.com/",
    "inLanguage": "en",
    "publisher": {"@id": "https://excelwrite.com/#organization"}
    }]
    }
    </script><?php
}?>
<link rel="canonical" href="https://excelwrite.com"  >
</head>
<body><?php
if($this->displayheadermenu) {
    include "headermenu.php";
}?>