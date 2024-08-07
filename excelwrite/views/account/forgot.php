<?php include "../app/excelwrite/incs/header.php"?>
<div class='centercard logincontainer'>
    <div class=center>
        <img src="../assets/images/logo.png" alt="Excelwrite Logo" width=200 height=200>
    </div>
    <div class=loginform>
        <form method=post action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">
            <span class=success><?=$data['formdata'][1]['success'] ?? ''?></span>
            <span class=error><?=$data['formdata'][1]['gen'] ?? ''?></span>
            <input type=email name=email value="<?=$data['formdata'][0]['email'] ?? ''?>" placeholder='email'>
            <input type=submit name=forgot value='SEND PASSWORD RESET LINK' class=rounded>
        </form>
    </div>
    <div class='afterform'>
        <a class=dynleft href="signup">New? Sign Up</a> <a class=dynright href="login">Already have an account? Login</a>
    </div>
    <div class=loginfooter>
        <a href="<?=HOME?>">Home</a><a href="<?=HOME?>/support">Contact Us</a>
    </div>
</div>