<div class=hidesmall>
    <div class='header container'>
        <div class='headerlogo left'>
            <a href="<?=HOME?>/">
                <img src="<?=HOME?>/assets/images/logo.png" alt="Excelwrite Logo" width=70 height=70>
            </a>
        </div><?php
        if($this->displayheadermenu=='profile') {?>
                <div class='headerlist right'>
                    <ul>
                        <li><a href="<?=HOME?>/account/orders">All Orders</a></li>
                        <li><a href="#"  onclick="loadModal('ordermodal')">New Assignment</a></li>
                        <li><a href="<?=HOME?>/account/profile">My Profile</a></li>
                        <li><a href="<?=HOME?>/account/logout">Logout</a></li>
                    </ul>
                </div>
            <?php
        } else {?>
                <div class='headerlistcentral'>
                    <ul>
                        <li><a href="<?=HOME?>">Home</a></li>
                        <li><a href="<?=HOME?>/support">Contact Us</a></li>
                        <li><a href="<?=HOME?>#howtoorder">How to Order</a></li><?php
                        if(isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true) {?>
                            <li><a href="<?=HOME?>/account/profile">My Profile</a></li>
                            <li><a href="<?=HOME?>/account/logout">Logout</a></li><?php
                        } else {?>
                            <li><a href="<?=HOME?>/account/signup">Sign Up</a></li>
                            <li><a href="<?=HOME?>/account/login">Login</a></li><?php
                        }?>
                    
                    </ul>
                </div>
                <div class='headerlist' style='width:30%'>
                    <a href="#"  onclick="loadModal('ordermodal')">
                        <button class=rollIn>Submit Assignment</button>
                    </a>
                </div>
            <?php
        }
        // show($_SERVER);?>
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
</div>

<div id=ordermodal class=modal>
    <div class='formcard  modal-content'>
        <span class=close id=close onclick = "closeModal()">&times;</span>
        <h1 class=center>Place Order</h1>
        <span class=success id=success></span>
        <span class=error id=gen></span>
        <form  id=orderform class=altformrow onsubmit="event.preventDefault(); submitAssignment()" action="" method="post" enctype='multipart/form-data'>
            
                <div>
                    <input type="hidden" name=name value="<?=bin2hex(random_bytes(4))?>">
                    <input type=text name=clientname value="<?=$_SESSION['user']['lastname'] ?? ''?>" placeholder='Name' style='width:100%'>
                    <span class=error id=clientname style='width:100%'></span>
                </div>
                <div>
                    <input type=email name=clientemail value="<?=$_SESSION['user']['email'] ?? ''?>" placeholder='Email' style='width:100%'>
                    <span class=error id=clientemail></span>
                </div>
            
                <div>
                    <input type=text name=clientphone value="<?=$_SESSION['user']['phone'] ?? ''?>" placeholder='Phone Number (+123 format)' style='width:100%'>
                    <span class=error id=clientphone></span>
                </div>
                <div>
                    <input type=text name=subject value="" placeholder='Subject' style='width:100%'>
                    <span class=error id=subject></span>
                </div>
            
                <div>
                    <select name="mode" id="" style='width:100%'>
                        <option value="">--- Select Mode ---</option>
                        <option value="writing">Writing</option>
                        <option value="rewriting">Rewriting</option>
                        <option value="editing">Editing</option>
                    </select>
                    <span class=error id=mode></span>
                </div>
                <div>
                    <input type=number name=pages style='width:100%' placeholder='Pages'>
                    <span class=error id=pages></span>
                </div>
            
                <div>
                    <input type=text name=expdate style='width:100%' placeholder='Deadline' onfocus="(this.type='date')">
                    <span class=error id=expdate></span>
                </div>
                <div>
                    <input type=file name=file style='width:100%'>
                    <span class=error id=file></span>
                </div>
            
            <div class=forminputsubmit>
                <!-- <input type="submit" name=submit value='Get a Quote' style='width:100%; margin-top: 10px' id=submitbtn> -->
                <button type="submit" name=submit value='create' style='width:100%; margin-top: 10px' id=submitbtn>Get a Quote</button>
            </div>
        </form>
    </div>
</div>