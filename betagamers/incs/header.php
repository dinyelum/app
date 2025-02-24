<!DOCTYPE html>
<html lang="<?=LANG?>" dir="ltr">
<head>
<title><?=$data['page_title']?> | <?=SITENAME?></title>
<?php if(LANG == 'en' && $this->activepage == 'home') {?>
<meta name="msvalidate.01" content="507C05474B51ECBDAD4513E20E2C73A7" >
<meta name="p:domain_verify" content="0817cef115616347cd6280d68ae7c48b">
<?php } if($this->metabots != false) {?>
<meta name="robots" content="<?=$this->metabots?>" >
<?php } ?>
<meta charset="utf-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta name='theme-color' content='green'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='author' content='BETAGamers'>
<meta name='keywords' content='<?=$this->keywords?>'>
<meta name='description' content='<?=$this->description ?>' >
<?php if(is_array($this->og) && count($this->og) > 0) {?>
<meta property="og:url" content="<?=$this->og['url']?>" >
<meta property="og:type" content="article" >
<meta property="og:title" content="<?=$this->og['title']?>" >
<meta property="og:description" content="<?=$this->og['description']?>" >
<meta property="og:image" content="<?=$this->og['image']?>" >
<meta property="og:image:type" content="image/png" >
<meta property="og:image:width" content="200" >
<meta property="og:image:height" content="200" ><?php } ?>
<link rel='icon' href='favicon.ico'>
<!--<link rel="preload" href="./webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>-->
<!--<link rel="preload" href="./webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>-->
<link rel='preload' href='<?=HOME?>/assets/css/w3.css' as='style'>
<link rel='preload' href='<?=HOME?>/assets/css/style.css' as='style'>
<link rel='preload' href='<?=HOME?>/assets/css/all.min.css' as='style'><?php
if($this->adminmode === true || $this->activepage == 'login') {?>
<link rel="preload" href="<?=HOME?>/assets/loginsystem/build/css/intlTelInput.min.css" as='style'>
<link rel="stylesheet" href="<?=HOME?>/assets/loginsystem/build/css/intlTelInput.min.css">
<?php } ?>
<link rel='stylesheet' type='text/css' href='<?=HOME?>/assets/css/w3.css' >
<link rel='stylesheet' type='text/css' href='<?=HOME?>/assets/css/style.css' >
<link rel='stylesheet' type='text/css' href='<?=HOME?>/assets/css/all.min.css' >
<script src="https://kit.fontawesome.com/906d05b5f6.js" crossorigin="anonymous"></script>
<?php if($this->tags === true) {?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MRP6848');</script>
<!-- End Google Tag Manager -->
<?php } if($this->style) {?>
<style>
    <?=$this->style?>
</style>
<?php } if($this->activepage == 'home') {?>
<script type = 'application/ld+json'> 
{
 "@context": "https://schema.org",
 "@graph": [{
  "@type": "Organization",
  "@id": "https://betagamers.net/#organization",
  "name": "Betagamers Services",
  "alternateName": "Betagamers",
  "url": "https://betagamers.net/",
  "logo": "https://betagamers.net/bglogo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+2348157437268",
    "contactType": "customer service"
  },
  "sameAs": [
    "https://www.facebook.com/betagamerpage",
    "https://twitter.com/betagamersnet",
    "https://instagram.com/betagamersnet",
    "https://pinterest.com/betagamersnet"
  ]
}, {
  "@type": "WebSite",
  "@id": "https://<?=(LANG != 'en' ? LANG.'.' : '')?>betagamers.net/#website",
  "url": "https://<?=(LANG != 'en' ? LANG.'.' : '')?>betagamers.net/",
  "inLanguage": "<?=LANG?>",
  "publisher": {"@id": "https://betagamers.net/#organization"}
}]
}
</script>
<?php } if(count($this->urls) > 0) {
    foreach($this->urls as $key => $val) { ?>
<link rel="<?=(LANG == $key) ? 'canonical' : 'alternate'?>" href="<?=$val?>" <?=(LANG != $key) ? "hreflang='$key'" : ''?> ><?php
    }
} ?>

</head>
<body>
<?php if($this->tags === true) {?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRP6848"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><?php }

//$activepage = $activetop; //quick fix cos sidenav already uses $activepay
include INCS.'/headermenu.php';