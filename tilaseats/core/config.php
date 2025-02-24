<?php 
define('SITENAME', "Tilaseats");
define('URI', $_SERVER['REQUEST_URI']);
if($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_NAME', 'tilaseats');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_HOST', 'localhost');
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
	define('UPLOAD_ROOT', ROOT.'/app/tilaseats/uploads');
	define('HOME', 'http://localhost/tilaseats.com');
	define('DEBUG', true);
} else {
    define('ENV', parse_ini_file('file.env'));
    define('DB_NAME', ENV['DB_NAME']);
    define('DB_USER', ENV['DB_USER']);
	define('DB_PASS', ENV['DB_PASS']);
	define('DB_HOST', ENV['DB_HOST']);
	define('ROOT', ENV['ROOT']);
	define('UPLOAD_ROOT', ROOT.'/app/tilaseats/uploads');
	define('HOME', 'https://tilaseats.com');
	define('DEBUG', false);
}
define('DB_TYPE','mysql');
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