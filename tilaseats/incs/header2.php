<div class='header container'>
    <div class='headerlogo left'>
        <img src="./images/logo.png" alt="Tilaseats logo" width=70px height=70px>
    </div>
    <div class='headerlist left'>
        <ul>
            <li><a href="#" class=active>Home</a></li>
            <li><a href="#">Categories</a></li>
            <!-- <li onclick="loadModal('loginmodal')"><a href="#">Login</a></li> -->
            <li class=dropdown>
                    <i class="fa fa-user"></i>
                    <i class="fa fa-caret-down"></i>
                    <div class=dropdowncontent>
                        <ul>
                            <li><a href="">My Profile</a></li>
                            <li><a href="">Logout <i class="fa fa-sign-out"></i></a></li>
                        </ul>
                    </div>
            </li>
            <li class=cartmenu>
                <a href="cart.php">
                    Cart 
                    <i class="fa fa-shopping-cart"></i>
                    <span id=cartcount><?=isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0?></span>
                </a>
            </li>
        </ul>
    </div>
</div>