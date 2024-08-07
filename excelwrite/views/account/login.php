<?php include "../app/excelwrite/incs/header.php"?>
<div class='centercard logincontainer'>
    <div class=center>
        <img src="../assets/images/logo.png" alt="Excelwrite Logo" width=200 height=200>
    </div>
    <div class=loginform>
        <form method=post action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">
            <span class=success><?=$data['formdata'][1]['success'] ?? ''?></span>
            <span class=error><?=$data['formdata'][1]['gen'] ?? ''?></span>
            <span class=error><?=$data['formdata'][1]['emailactive'] ?? ''?></span>
            <input type=email name=email value="<?=$data['formdata'][0]['email'] ?? ''?>" placeholder='email'>
            <input type=password name=password value="" placeholder='password'>
            <input type=submit name=submit value=LOGIN class=rounded>
        </form>
    </div>
    <div class=afterform>
        <a class=left href="forgot">Forgot Password?</a> <a class=right href="signup">New? Sign Up</a>
    </div>
    <div class=loginfooter>
        <a href="<?=HOME?>">Home</a><a href="<?=HOME?>/support">Contact Us</a>
    </div>
</div>
<script>
/*if there's a network error or activity was cancelled, onload is not called, onerror is called instead.
If there's a server error, onload is still called, you just have to use this.status to check for success*/
var i = <?=$_SESSION['resendcontrol'] ?? 1?>;
var customerid = <?=$_SESSION['user']['id'] ?? 0?>;
var resendid = document.getElementById('resend');
var spinner = "<i class='fa-solid fa-circle-notch fa-spin'></i>";
var x;
var xhttp = new XMLHttpRequest;

function reverse() {
    resendid.innerText = 'Resend';
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
            //console.log(this.responseText);return;
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
    xhttp.open('GET', 'https://excelwrite.com/requests/mailer.php?id='+customerid);
    xhttp.send();
}

function counter(timer=30) {
    var countDownDate = new Date().getTime() + (timer * i * 1000);
    i++;
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
      resendid.innerText = 'Resend available in : '+(minutes > 0 ? minutes+"m " : '' )+seconds + "s ";
        
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