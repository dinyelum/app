<?php include "../app/excelwrite/incs/header.php"?>
<div class='centercard logincontainer' style='height:100vh'>
    <div class=center>
        <img src="../assets/images/logo.png" alt="Excelwrite Logo" width=200 height=200>
    </div>
    <div class=loginform>
        <form method=post action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">
            <span class=success><?=$data['formdata'][1]['success'] ?? ''?></span>
            <span class=error><?=$data['formdata'][1]['gen'] ?? ''?></span>
            <p class=center style='margin-bottom: 5px'>
                Are you registering as a writer?
                <span class='radiocontainer'>
                    <span class=radio>
                        <input type=radio id=aswriteryes name=writer value=1 <?=isset($data['formdata'][0]['writer']) && $data['formdata'][0]['writer']==1 ? 'checked' : (isset($_GET['writer']) && $_GET['writer']=='yes' ? 'checked' : '')?>>
                        <label for='aswriteryes'>Yes</label>
                    </span>
                    <span class=radio>
                        <input type=radio id=aswriterno name=writer value=0 <?=isset($data['formdata'][0]['writer']) && $data['formdata'][0]['writer']==0 ? 'checked' : (isset($_GET['writer']) && $_GET['writer']=='no' ? 'checked' : '')?>>
                        <label for='aswriterno'>No</label>
                    </span><br>
                </span>
                <span class=error><?=$data['formdata'][1]['writer'] ?? ''?></span>
            </p>
            <div class=half>
                <input type=text name=firstname value="<?=$data['formdata'][0]['firstname'] ?? ''?>" placeholder='firstname' style='width:100%'>
                <span class=error><?=$data['formdata'][1]['firstname'] ?? ''?></span>
            </div>
            <div class=half>
                <input type=text name=lastname value="<?=$data['formdata'][0]['lastname'] ?? ''?>" placeholder='lastname' style='width:100%'>
                <span class=error><?=$data['formdata'][1]['lastname'] ?? ''?></span>
            </div>
            <input type=email name=email value="<?=$data['formdata'][0]['email'] ?? ''?>" placeholder='email'>
            <span class=error><?=$data['formdata'][1]['email'] ?? ''?></span>
            <input type=password name=password value="" placeholder='password'>
            <span class=error><?=$data['formdata'][1]['password'] ?? ''?></span>
            <input type=submit name=submit value=REGISTER class=rounded>
        </form>
    </div>
    <div class='afterform center'>
        <a href="login">Already have an account? Login</a>
    </div>
    <p class=center style='margin-bottom:auto'>By signing up, you agree to our <a href="<?=HOME?>/support/terms">Terms of Service</a> and <a href="<?=HOME?>/support/privacy">Privacy Policy</a></p>
    <div class=loginfooter>
    <a href="<?=HOME?>">Home</a><a href="<?=HOME?>/support">Contact Us</a>
    </div>
</div>