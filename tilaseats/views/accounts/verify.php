<?php
session_start();
$refreshlogin = true;
include '../core/init.php';
if(isset($_GET['email']) && isset($_GET['hash'])) {
    $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
    $userclass = new User;
    $hash = $userclass->validate_alphanumeric($_GET['hash'], true, 'hash');
    if(!isset($userclass->err)) {
        $check = $userclass->exists(['email'=>$email, 'hash'=>$hash], 'and');
        if($check===true) {
            $updatedata = $userclass->update(['emailactive'=>1, 'hash'=>sha1(mt_rand(0,1000))])->where('email=:email AND hash=:hashwh', [':email'=>$email, ':hashwh'=>$hash]);
            if($updatedata===true) {
                $response = 'Email successfully verified.';
            }
        }
    }
}
$message = $response ?? 'An error occured. Please try again later or contact admin.';
include '../modals/loginmodal.php';
include '../core/checklogin.php';
include '../modals/message.php';
?>
<!DOCTYPE html>
<html lang=en dir=ltr>
    <head>
        <meta name=robots content="index, follow">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="">
        <title>Verify Email | Tilas Eats</title>
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body><?php
include '../includes/header.php'?>
<body onload="loadModal('message')">
    <script src="../js/gen.js"></script>
</body>