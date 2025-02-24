<div class='header'>
    <div class='headerlogo left'>
        <a href="<?=HOME?>"><img src="<?=HOME?>/images/logo.png" alt="Tilaseats logo" width=70px height=70px></a>
    </div>
    <div class='headerlist left'>
        <ul>
            <li><a href="<?=HOME?>/" class=active>Home</a></li>
            <li><a href="<?=HOME?>/categories.php">Categories</a></li><?php
            if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in']==true) {?>
                <li class=dropdown id=dropdownbtn>
                    <i class="fa fa-user"></i>
                    <i class="fa fa-caret-down"></i>
                    <div class=dropdowncontent id=dropdowncontent>
                        <ul>
                            <li></li>
                            <li><a href="<?=HOME?>/accounts/profile.php">My Profile</a></li>
                            <li><a href="<?=HOME?>/accounts/logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
                        </ul>
                    </div>
                </li><?php
            } else {?>
                <li class='dropdown showloggedin' style='display:none'>
                    <i class="fa fa-user"></i>
                    <i class="fa fa-caret-down"></i>
                    <div class=dropdowncontent id=dropdowncontent>
                        <ul>
                            <li></li>
                            <li><a href="<?=HOME?>/accounts/profile.php">My Profile</a></li>
                            <li><a href="<?=HOME?>/accounts/logout.php">Logout <i class="fa fa-sign-out"></i></a></li>
                        </ul>
                    </div>
                </li>
                <li onclick="loadModal('loginmodal')" class=hideloggedin><a href="#">Login</a></li><?php
            }?>
            <li class=cartmenu>
                <a href="<?=HOME?>/cart.php">
                    Cart 
                    <i class="fa fa-shopping-cart"></i>
                    <span id=cartcount><?=isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0?></span>
                </a>
            </li>
        </ul>
    </div>
</div>