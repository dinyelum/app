<?php
$errorlevel = $errorlevel ?? 'view';
if($errorlevel=='controller') {?>
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
    <title>Error | ExcelWrite</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='<?=HOME?>/assets/css/style.css' >
    </head>
    <body><?php
} else {
    $this->displayheadermenu = true; 
    $data['page_title'] = "Error"; 
    include "../app/excelwrite/incs/header.php";
}?>
<style>
    .errpage {
        display: grid;
        grid-template-columns: auto auto;
        text-align: center;
        row-gap: 20px;
    }
    .errpage div:first-child, .errpage div:nth-child(2) {
        grid-column: 1 / span 2;
    }
    .perfectcenter {
        width: 70%;
    }
</style>
<!--<div class='centercard errpage'>
    <div><h1>Page Not Found</h1></div>
    <div>Here's what you can do:</div>
    <div><a href='https://excelwrite.com'>Go to the HomePage</a></div>
    <div><a href='https://excelwrite.com/account/login'>Login</a></div>
</div>-->
<div class='perfectcenter errpage'>
    <div><h1>Page Not Found</h1></div>
    <div>Here's what you can do:</div>
    <div><a href='https://excelwrite.com'>Go to the HomePage</a></div>
    <div><a href='https://excelwrite.com/account/login'>Login</a></div>
</div><?php
if($errorlevel!='controller') {
    include "../app/excelwrite/incs/footer.php";
}?>