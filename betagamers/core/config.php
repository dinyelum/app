<?php 
define('SITENAME', "Betagamers");
define('URI', $_SERVER['REQUEST_URI']);
define('ALLSPORTS', ['football', 'tennis']);
define('LANGUAGES', ['en'=>'English', 'fr'=>'French', 'es'=>'Spanish', 'pt'=>'Portuguese', 'de'=>'German']);
define('LANGUAGES_LOCALE', ['en'=>'English', 'fr'=>'Français', 'es'=>'Español', 'pt'=>'Português', 'de'=>'Deutsch']);
define('ENV', parse_ini_file('file.env'));
if($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_NAME', 'betagamers');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_HOST', 'localhost');
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	$lang = ltrim(explode('.', str_replace('/betagamers/', '', $_SERVER['PHP_SELF']))[0], '/');
	define('HOME', 'http://localhost/betagamers/'.(strlen($lang)==2 ? "$lang.betagamers.net" : 'public_html'));
	define('UPLOAD_SCREENSHOTS_ROOT', ROOT.'/betagamers');
	define('DEBUG', true);
} else {
    define('DB_NAME', ENV['DB_NAME']);
    define('DB_USER', ENV['DB_USER']);
	define('DB_PASS', ENV['DB_PASS']);
	define('DB_HOST', ENV['DB_HOST']);
	define('DB_RECS_NAME', ENV['DB_RECS_NAME']);
	define('ROOT', ENV['ROOT']);
	$lang = explode('.', $_SERVER['SERVER_NAME'])[0];
	define('HOME', 'https://'.$_SERVER['SERVER_NAME']);
	define('UPLOAD_SCREENSHOTS_ROOT', ROOT);
	define('DEBUG', false);
}
define('FORM_SIGNATURE_KEY', ENV['FORM_SIGNATURE_KEY']);
define('DB_TYPE','mysql');
define('INCS', ROOT.'/app/betagamers/incs');
define('UPLOAD_ADMIN_ROOT', ROOT.'/files/betagamers/work');
define('UPLOAD_TEAMS_ROOT', INCS.'/free_predicts_writeups/en/teams');
$exception = ['XX', 'T1'];
define('CF_COUNTRY', isset($_SERVER['HTTP_CF_IPCOUNTRY']) && !in_array($_SERVER['HTTP_CF_IPCOUNTRY'], $exception) ? $_SERVER['HTTP_CF_IPCOUNTRY'] : 'GB');
define('USER_COUNTRY', $_SESSION['users']['country'] ?? CF_COUNTRY);
define('USER_LOGGED_IN', $_SESSION['users']["logged_in"] ?? null);
define('SUPER_ADMIN', isset($_SESSION['users']["email"]) && $_SESSION['users']["email"]==ENV['SUPER_ADMIN']);
define('LANG', (strlen($lang)==2) ? $lang : 'en');
define('DISCOUNT', null);
define('EMAIL', 'services@betagamers.net');
define('HR', 'hr@betagamers.net');
define('LINKS', 'links@betagamers.net');
define('PAYMENTS', 'payments@betagamers.net');
define('PHONE', '+2348157437268');
define('PHONE_LOCALE', '08157437268');
if(LANG=='en') {
	define('FB', 'betagamerpage');
	define('X', 'betagamersnet');
	define('TELEGRAM_CHANNEL', 'betagamers_en');
} elseif(LANG=='fr') {
	define('FB', 'betagamersfr');
	define('X', 'betagamers_fr');
	define('TELEGRAM_CHANNEL', 'betagamers_fr');
} elseif(LANG=='es') {
	define('FB', 'betagamerses');
	define('X', 'betagamers_es');
	define('TELEGRAM_CHANNEL', 'betagamers_esp');
} elseif(LANG=='pt') {
	define('FB', 'betagamerspt');
	define('X', 'betagamers_pt');
	define('TELEGRAM_CHANNEL', 'betagamers_pt');
} elseif(LANG=='de') {
	define('FB', 'betagamersde');
	define('X', 'betagamers_de');
	define('TELEGRAM_CHANNEL', 'betagamers_de');
}
define('IG', 'betagamersnet');
define('PINTEREST', 'betagamersnet');
define('TELEGRAM', 'betagamersnet');
define('FBLINK', 'https://facebook.com/'.FB);
define('FBGROUPLINK', 'https://web.facebook.com/groups/542368292921814/');
define('FBGROUPNAME', 'Sure Games Daily');
define('XLINK', 'https://twitter.com/'.X);
define('IGLINK', 'https://instagram.com/'.IG);
define('PINTERESTLINK', 'https://pinterest.com/betagamersnet');
define('TELEGRAM_LINK', 'https://t.me/'.TELEGRAM);
define('TELEGRAM_CHANNEL_LINK', 'https://t.me/'.TELEGRAM_CHANNEL);
define('WHATSAPP_LINK', 'https://api.whatsapp.com/send?phone='.ltrim(PHONE, '+'));
define('ACCTNAME', 'BETAGAMERS SERVICES');
define('ACCTNUMBER', '0107018097');
define('BANK', 'ACCESS BANK, NIGERIA');
define('SWIFTCODE', 'ABNGNGLAXXX');
define('BN', 'BN 2674390');
if(DEBUG) {
    ini_set("display_errors",1);
} else{
	ini_set("display_errors",0);
}

/*protocal type http or https*/
define('PROTOCAL','http');

/*root and asset paths*/

// $path = str_replace("\\", "/",PROTOCAL ."://" . $_SERVER['SERVER_NAME'] . __DIR__  . "/");
// $path = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path);

// define('ROOT', str_replace("app/core", "public", $path));
// define('ASSETS', str_replace("app/core", "public/assets", $path));

/*set to true to allow error reporting
set to false when you upload online to stop error reporting*/