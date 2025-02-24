<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class='tips-noprof'><?php
if($this->authmode=='email') {?>
    <?=$data['email']['message']?> <br><br>
    <p>
    <?=$data['email']['prompt1'][0]?>? <span id=resend onclick='resendMail()' style='text-decoration: underline; cursor:pointer'><?=$data['email']['prompt1'][1]?></span>
    </p>
    <?=$data['email']['prompt2']?>
<?php
} elseif($this->authmode=='phone') {
    if($this->maxauth) {
        echo $data['phone']['confirmreg'][0]." <b style='color:green'>".$data['phone']['confirmreg'][1]."</b> ".$data['phone']['confirmreg'][2]." <br><br>".$data['phone']['confirmreg'][3];
    } else {?>
    <div id='otp' class='otp container'>
        <p class=w3-center id=prompt><?=$data['phone']['message']?></p>
        <span class='w3-center error' id=error></span>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <input class='input' type='text' inputmode='numeric' maxlength='1'>
        <button id=verifyotp class='w3-green w3-round-large w3-disabled'><?=$data['phone']['verifybtn']?></button>
        <button id=resendotp class='w3-blue w3-round-large w3-disabled'><?=$data['phone']['resendbtn']?> <i id=resend></i></button>
    </div>
    <p class=w3-container id=extras>
        <span class=w3-right onclick="toggle('otp', 'confirmregtext', 'extras')"><?=$data['phone']['prompt']?>?</span>
    </p><?php
    }?>
    <div id=confirmregtext style='display:none'>
        <?=$data['phone']['confirmreg']?>
    </div><?php
} else {
    echo $data['autherr'];
}?>
</div><?php
include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var customerid = <?=$_SESSION['users']['id']?>;
    var resendid = document.getElementById('resend');
    var spinner = "<i class='fa fa-spinner w3-spin' style='margin-left: 5px'></i>";
    var x;
    var xhttp = new XMLHttpRequest;
    var tawkTo=false;<?php
    if($this->authmode=='phone') {?>
        var i = 1;
        const otpdiv = document.getElementById("otp");
        var otpval = ''; var otpvalcount = 0; var btnmode;
        var allinputs = document.querySelectorAll(".otp .input");
        var verifyotpbtn = document.getElementById("verifyotp");
        var resendotpbtn = document.getElementById("resendotp");
        var errorid = document.getElementById("error");

        function toggle(idoff, idon, toggleself=null) {
            document.getElementById(idoff).style.display = 'none';
            document.getElementById(idon).style.display = '';
            if(typeof toggleself == 'boolean') {
                document.addEventListener('click', function(e) {
                    document.getElementById(e.target.id).style.display = 'none';
                });
            } else if(typeof toggleself == 'string') {
                document.getElementById(toggleself).style.display = 'none';
            } else {}
        }

        otpdiv.addEventListener("input", function (e) {
            const target = e.target;
            const val = target.value;
            if (isNaN(val)) {
                target.value = "";
                return;
            }
            if (val != "") {
                otpvalcount += 1;
                /*if(otpvalcount == 6) {
                    verifyOtp();
                }*/
                displayVerifyBtn();
                const next = target.nextElementSibling;
                if (next) {
                    next.focus();
                }
            }
        });
        otpdiv.addEventListener("keydown", function (e) {
            const target = e.target;
            const key = e.key.toLowerCase();
            if(target.value != '') {
                if (key == "backspace" || key == "delete") {
                    if(target.tagName != 'BUTTON') {
                        target.value = "";
                    }
                    otpvalcount -= 1;
                    displayVerifyBtn();
                    /*const prev = target.previousElementSibling;
                    if (prev) {
                        prev.focus();
                    } if enabled, only delete comes into this if(backspace||delete) block successfully, backspace doesn't, I don't know why*/
                    return;
                } else if(key == 'enter') {
                    verifyOtp();
                }
            }
        });
        document.addEventListener('keydown', function(e) {
            if((e.ctrlKey || e.metaKey) && e.key=='z' || ((e.ctrlKey || e.metaKey) && e.key=='y') || ((e.ctrlKey || e.metaKey) && e.shiftkey && e.key=='z')) {
                e.preventDefault();
                return false;
            }
        });
        for(let i=0; i<allinputs.length; i++) {
            allinputs[i].addEventListener('click', function(e) {
                errorid.innerText = '';
            });
        }

        function displayVerifyBtn() {
            if(otpvalcount == 6) {
                verifyotpbtn.classList.remove('w3-disabled');
                verifyotpbtn.setAttribute('onclick', 'onclick=verifyOtp()')
            } else {
                verifyotpbtn.className += ' w3-disabled';
                verifyotpbtn.removeAttribute('onclick');
            }
        }

        function displayResendBtn(toggleswitch=true) {
            if(toggleswitch) {
                resendotpbtn.classList.remove('w3-disabled');
                resendotpbtn.seAttribute('onclick', 'verifyOtp(1)');
            } else {
                resendotpbtn.className += ' w3-disabled';
                resendotpbtn.removeAttribute('onclick');
            }
        }

        function reverse(btn=resendotpbtn) {
            if(btn==resendotpbtn) {
                btn.classList.remove('w3-disabled');
                btn.setAttribute('onclick', 'verifyOtp(1)');
            } else {
                btn.innerText = "<?=$data['phone']['verifybtn']?>";
                btn.setAttribute('onclick', 'verifyOtp(2)');
            }
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            verifyOtp(1);
        });
        function verifyOtp(mode=2) {
            if(mode !== 1) {
                for(let i=0; i<allinputs.length; i++) {
                    otpval += allinputs[i].value;
                }
                if(otpval.length !== 6) {
                    return;
                }
                btnmode = verifyotpbtn;
                verifyotpbtn.removeAttribute('onclick');
                verifyotpbtn.innerHTML = spinner;
            } else {
                otpval = '';
                btnmode = resendotpbtn;
                resendid.removeAttribute('onclick');
                resendid.innerHTML = spinner;
            }

            xhttp.onerror = function() {
                reverse(btnmode);
            }
            xhttp.onload = function() {
                //console.log(xhttp.responseText);
                const resp = JSON.parse(xhttp.responseText);
                otpval = '';
                reverse(btnmode);
                //reverse(btnmode);
                if(typeof resp.timer != 'undefined') {
                    resetTimer(x); //incase of any previously running countdown function
                    counter(resp.timer);
                    displayResendBtn(false);
                    
                }
                if(typeof resp.response == 'string') {
                    if(resp.response == 'approved') {
                        location.reload();
                    } else {
                        errorid.innerText = resp.response;
                        toggle('prompt', 'error');
                    }
                }
                if(typeof resp.response == 'boolean' && resp.response === false) {
                    toggle('otpdiv', 'confirmregtext', 'extras');
                }
                if(typeof resp.response == 'boolean' && resp.response === true) {
                    toggle('error', 'prompt');
                }
            }
            xhttp.open('GET', '<?=HOME?>/requests/phoneotp.php?mode='+mode+'&code='+otpval);
            xhttp.send();
        }<?php
    } elseif($this->authmode=='email') {?>
        var i = <?=$_SESSION['resendcontrol'] ?? 1?>;
        function reverse() {
            resendid.innerText = "<?=$data['script']['resend']?>";
            resendid.setAttribute('onclick', 'resendMail()');
        }
        function resendMail() {
            resendid.removeAttribute('onclick');
            resendid.innerHTML = spinner;
            xhttp.onerror = function() {
                reverse();
            }
            xhttp.onload = function() {
                if (this.status == 200) {
                    console.log(this.responseText);return;
                    const resp = JSON.parse(this.responseText);
                    if(resp.response === true) {
                        counter();
                    } else {
                        reverse();
                    }
                } else {
                    reverse();
                }
            }
            xhttp.open('GET', '<?=HOME?>/requests/mailer.php?id='+customerid);
            xhttp.send();
        }<?php
    } else {}
    ?>

    function counter(timer=30) {
        var countDownDate = new Date().getTime() + (timer * i * 1000);
        <?php
        if($this->authmode == 'email') {
            echo 'i++;';
        }?>
        // Update the count down every 1 second
        x = setInterval(countDown, 1000);
        function countDown() {
        
        // Get today's date and time
        var now = new Date().getTime();
            
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
        // Output the result in an element with id="demo"
        <?php
        if($this->authmode == 'email') {?>
            resendid.innerText = '<?=$data['script']['emailsent']?> : '+(minutes > 0 ? minutes+"m " : '' )+seconds + "s ";<?php
        } else {?>
            resendid.innerText = '('+(minutes > 0 ? minutes+"m " : '' )+seconds + "s) ";<?php
        }?>
            
        // If the count down is over, write some text 
        if (distance < 0) {
            resetTimer(x);
            resendid.innerText = '';
            reverse();
        }
        }
    }

    function resetTimer(value) {
        clearInterval(value);
    }
</script>