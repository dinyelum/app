
<div class='footer'>
    <div class=container>
        <div class='headerlogo left hidesmall'>
            <a href="<?=HOME?>"><img src="<?=HOME?>/assets/images/logo.png" alt="Tilaseats logo" width=70px height=70px></a>
        </div>
        <div class=mobile>
            <div class='footerlist left'>
                <ul><?php
                if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in']==true) {?>
                    <li><a href="<?=HOME?>/accounts/profile.php">My Profile</a></li>
                    <li><a href="<?=HOME?>/accounts/logout.php">Logout <i class="fa fa-sign-out"></i></a></li><?php
                } else {?>
                    <div class=showloggedin style='display: none'>
                        <li><a href="<?=HOME?>/accounts/profile.php">My Profile</a></li>
                        <li><a href="<?=HOME?>/accounts/logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
                    </div>
                    <div class=hideloggedin>
                        <li onclick="loadModal('loginmodal')"><span class=clickable>Register</span></li>
                        <li onclick="loadModal('loginmodal')"><span class=clickable>Login</span></li>
                    </div><?php
                }?>
                </ul>
            </div>
            <div class='footerlist left'>
                <ul><?php
                    $prev = '';
                    foreach ($_SESSION['catfooter'] as $val) {
                        if($val['category'] != $prev) {
                            echo "<li><a href='".HOME.'/categories.php?catid='.$val['id']."'><span class=clickable>".$val['category']."</span></a></li>";
                        }
                        $prev = $val['category'];
                    }?>
                </ul>
            </div>
        </div>
        <div class=mobile>
            <div class='footerlist right'>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class='headerlogo left hidebig'>
                <a href="<?=HOME?>"><img src="<?=HOME?>/assets/images/logo.png" alt="Tilaseats logo" width=70px height=70px></a>
            </div>
        </div>
    </div>
    <hr>
    <p class=center>
        <span class="fa-stack">
            <i class="fa fa-circle-thin fa-stack-2x"></i>
            <i class="fa fa-facebook fa-stack-1x"></i>
        </span>

        <span class="fa-stack">
            <i class="fa fa-circle-thin fa-stack-2x"></i>
            <i class="fa fa-instagram fa-stack-1x"></i>
        </span>

        <span class="fa-stack">
            <i class="fa fa-circle-thin fa-stack-2x"></i>
            <i class="fa fa-whatsapp fa-stack-1x"></i>
        </span>
    </p>
    <p class=center>&copy; <?=date('Y')?>. TilasEats.</p>
    <p class=center>All Rights Reserved</p>
    <p class=center>Designed By:</p>
</div>