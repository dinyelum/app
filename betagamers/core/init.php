<?php 
if($_SERVER['SERVER_NAME'] == 'localhost') {
    require $_SERVER['DOCUMENT_ROOT']."/app/betagamers/core/config.php";
} else {
    $getenv = parse_ini_file('file.env');
    require $getenv['ROOT']."/app/betagamers/core/config.php";
}
require ROOT."/app/functions.php"; //general functions
require ROOT."/app/betagamers/core/functions.php"; //app specific functions
// require ROOT."/app/core/database.php";
require ROOT."/app/betagamers/core/controller.php";
require ROOT."/app/betagamers/core/app.php";

//spl autoload classes folder and app specific classes folder
spl_autoload_register(function($classname) {
    $file = strtolower(ROOT."/app/classes/$classname.php");
    $appspecific = strtolower(ROOT."/app/betagamers/classes/$classname.php");
    $model = strtolower(ROOT."/app/betagamers/models/$classname.php");
    if(file_exists($file)) {
        include $file;
    } elseif(file_exists($appspecific)) {
        include $appspecific;
    } elseif(file_exists($model)) {
        include $model;
    } else {
        echo $classname;
        exit('An important module is missing. Please contact admin about this.');
    }
});