<?php include "../app/excelwrite/incs/header.php"?>
<div class='centercard logincontainer'><?php
    if(isset($_SESSION['user']['emailhash']) && $_SESSION['user']['emailhash'] ===1) {?>
        <div class=center>
            <img src="../assets/images/logo.png" alt="Excelwrite Logo" width=200 height=200>
        </div>
        <div class=loginform>
            <form method=post action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">
                <span class=success><?=$data['formdata'][1]['success'] ?? ''?></span>
                <span class=error><?=$data['formdata'][1]['gen'] ?? ''?></span>
                <input type=password name=password value="" placeholder='password'>
                <input type=password name=confirmpassword value="" placeholder='confirmpassword'>
                <input type=submit name=forgot value='RESET PASSWORD' class=rounded>
            </form>
        </div>
        <div class='afterform'>
        </div>
        <div class=loginfooter>
            <a href="<?=HOME?>">Home</a><a href="<?=HOME?>/support">Contact Us</a>
        </div><?php
    } else {?>
        <div class=center>You have entered an invalid URL for password reset!</div><?php
    }?>
</div>