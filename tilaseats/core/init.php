<?php 
if($_SERVER['SERVER_NAME'] == 'localhost') {
    require $_SERVER['DOCUMENT_ROOT']."/app/tilaseats/core/config.php";
} else {
    $getenv = parse_ini_file('file.env');
    require $getenv['ROOT']."/app/tilaseats/core/config.php";
}
require ROOT."/app/functions.php"; //general functions
require ROOT."/app/tilaseats/core/functions.php"; //app specific functions
// require ROOT."/app/core/database.php";
require ROOT."/app/tilaseats/core/controller.php";
require ROOT."/app/tilaseats/core/app.php";

//spl autoload classes folder and app specific classes folder
spl_autoload_register(function($classname) {
    $file = strtolower(ROOT."/app/classes/$classname.php");
    $model = strtolower(ROOT."/app/tilaseats/models/$classname.php");
    if(file_exists($file)) {
        include $file;
    } elseif(file_exists($model)) {
        include $model;
    } else {
        echo $classname;
        exit('An important module is missing. Please contact admin about this.');
    }
});