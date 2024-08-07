<div class=footer id=footer>
    <div class=footerlist>
        <div>
            <h3>Account</h3>
            <ul><?php
                if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true) {?>
                    <li><a href="<?=HOME?>/account/profile">My Profile</a></li>
                    <li><a href="<?=HOME?>/account/orders">All Orders</a></li>
                    <li><a href="<?=HOME?>/account/logout">Logout</a></li><?php
                } else {?>
                    <li><a href="<?=HOME?>/account/signup">Sign Up</a></li>
                    <li><a href="<?=HOME?>/account/login">Login</a></li><?php
                }?>
            </ul>
        </div>
        <div>
            <h3>Support</h3>
            <ul>
                <li><a href="<?=HOME?>/support/">Contact Us</a></li>
                <li><a href="<?=HOME?>/support/terms">Terms of Use</a></li>
                <li><a href="https://www.freeprivacypolicy.com/live/88275dc7-e9d0-40a2-9031-ba6bda41d487" target='_blank'>Privacy Policy</a></li>
                <!-- <li><a href="<?=HOME?>/support/faqs">FAQs</a></li> -->
                <li><a href="#footer" onclick="loadModal('ordermodal')">Pricing</a></li>
            </ul>
        </div>
        <div>
            <h3>Free Tools</h3>
            <ul>
                <li><a href="<?=HOME?>/tools/counter">Word Counter</a></li>
                <li><a href="<?=HOME?>/tools/converter">Letter Case Converter</a></li>
            </ul>
        </div>
        <div>
            <h3>Socials</h3>
            <ul><?php
            foreach($data['footersocials'] as $val) {
                if($val['channel'] == 'Phone' || $val['channel'] == 'Email') {
                    continue;
                }?>
                <li><a href="<?=$val['link']?>"><i class='<?=$val['icon']?>'></i> <?=$val['channel']?></a></li><?php
            }?>
            </ul>
        </div>
        <div>
            <a href="<?=HOME?>">
                <img src="<?=HOME?>/assets/images/logo.png" alt="Excelwrite Logo" width=120 height=120>
            </a>
        </div>
    </div>
    <hr>
    <div class=center>
        <p>&#169; <?=date('Y')?> <a href="<?=HOME?>">ExcelWrite.com</a></p>
        <p>All Rights Reserved</p>
    </div>
</div>
<!-- <script src='../assets/js/gen.js'></script> -->
</body>