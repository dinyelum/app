<?php
session_start();
include '../core/init.php';
$genclass = new General;
if(!isset($_GET['email']) || !isset($_GET['hash'])) {
    exit('Invalid fields');
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fieldsarr = array_merge($_GET, $_POST);
    $reset = $genclass->verifyhash($fieldsarr, 'user', 'reset');
    if($reset === true) {
        $success = 'Password reset successful';
    } elseif(is_array($reset) && count($reset)) {
        $error = $reset[1]['password'] ?? $reset[1]['confirmpassword'] ?? $reset[1]['gen'] ?? 'An error occurred';
    } else {
        $error = 'An unknown error has occurred';
    }
}
?>
<!DOCTYPE html>
<html lang=en dir=ltr>
    <head>
        <meta name=robots content="index, follow">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="">
        <title>Reset Password | Tilas Eats</title>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body><?php
include '../includes/header.php'?>
<div id=modal  class='formcard'>
    <form action='<?=htmlspecialchars(URI)?>' method=post>
        <h1>Enter new Password</h1>
        <div>
            <span class=success><?=$success ?? ''?></span>
            <span class=error><?=$error ?? ''?></span>
        </div>
        <div class=logincontent>
            <div class='formrow container'>
                <div class='forminput'>
                    <input type=password name=password value='' placeholder='New Password'>
                    <span class=error></span>
                </div>
                <div class='forminput'>
                    <input type=password name=confirmpassword value='' placeholder='Confirm Password'>
                    <span class=error></span>
                </div>
            </div>
            <div class='formrow container'>
                <div class='forminput forminputsubmit'>
                    <input type=submit name=submit value='Reset'>
                </div>
            </div>
        </div>
    </form>
</div>