<div class=hidesmall>
    <div class='header'>
        <div class='headerlogo left'>
            <a href="<?=HOME?>"><img src="<?=HOME?>/assets/images/logo.png" alt="Tilaseats logo" width=70px height=70px></a>
        </div>
        <div class='headerlist left'>
            <ul>
                <li><a href="<?=HOME?>/" class=active>Home</a></li>
                <li><a href="<?=HOME?>/categories">Categories</a></li><?php
                if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in']==true) {?>
                    <li class=dropdown id=dropdownbtn>
                        <i class="fa fa-user"></i>
                        <i class="fa fa-caret-down"></i>
                        <div class=dropdowncontent id=dropdowncontent>
                            <ul>
                                <li></li>
                                <li><a href="<?=HOME?>/accounts/profile">My Profile</a></li>
                                <li><a href="<?=HOME?>/accounts/logout">Logout <i class="fa fa-sign-out"></i></a></li>
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
                                <li><a href="<?=HOME?>/accounts/profile">My Profile</a></li>
                                <li><a href="<?=HOME?>/accounts/logout">Logout <i class="fa fa-sign-out"></i></a></li>
                            </ul>
                        </div>
                    </li>
                    <li onclick="loadModal('loginmodal')" class=hideloggedin><a href="#">Login</a></li><?php
                }?>
                <li class=cartmenu>
                    <a href="<?=HOME?>/cart">
                        Cart 
                        <i class="fa fa-shopping-cart"></i>
                        <span id=cartcount><?=isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class=hidebig>
    <!-- <div style='margin:2%'> -->
        <div class='header'>
            <div class='headerlogo'>
                <a href="<?=HOME?>/">
                    <img src="<?=HOME?>/assets/images/logo.png" alt="Excelwrite Logo" width=70 height=70>
                </a>
            </div>
            <div class=headername>Excelwrite.com</div>
            <div class=dropdown>
                <span></span>
                <div class='dropdowncontent'>
                    <ul>
                        <li><a href="<?=HOME?>">Home</a></li>
                        <li><a href="<?=HOME?>/support">Contact Us</a></li>
                        <li><a href="<?=HOME?>#howtoorder">How to Order</a></li><?php
                        if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true) {?>
                            <li><a href="<?=HOME?>/account/profile">My Profile</a></li>
                            <li><a href="<?=HOME?>/account/orders">All Orders</a></li>
                            <li><a href="<?=HOME?>/account/logout">Logout</a></li><?php
                        } else {?>
                            <li><a href="<?=HOME?>/account/signup">Sign Up</a></li>
                            <li><a href="<?=HOME?>/account/login">Login</a></li><?php
                        }?>
                    
                    </ul>
                    <a href="#"  onclick="loadModal('ordermodal')">
                        <button class=rollIn>Submit Assignment</button>
                    </a>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div><?php
include '../app/tilaseats/modals/loginmodal.php';?>