<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-card-4 form">
  <div class="w3-container formhead">
    <h1><?=$data['h1']?></h1>
  </div>
  <div class="w3-center w3-margin-top">
    <div class="w3-bar w3-white"><?php
      foreach($data['tab'] as $ind=>$val) {?>
        <button class="w3-bar-item w3-btn tablinks w3-hover-none <?=$ind==0 ? 'w3-green' : ''?>"><?=$val?></button><?php
      }?>
    </div>
  </div>

  <div class="w3-panel w3-margin-top"><?php
    foreach($data['formfields'] as $key=>$val) {?>
      <div class='unit w3-margin tabcontent' <?=$key!='email' ? " style='display:none'" : ''?>>
        <form method="post" action="<?=htmlspecialchars(URI)?>">
          <span class="error w3-section"><?=$data['formerror'][$key]?></span>
          <span class="error w3-section"><?=$data['logincount'] ?? ''?></span><?php
          foreach($val as $subkey=>$subval) {
            if($subkey=='') {
              echo "<label>$subval ".$data['fieldnames'][$key][$subkey]."</label><br><br>";
            } else {
              echo $data['fieldnames'][$key][$subkey]."$subval".($subkey=='email' || $subkey=='fullphone' ? '<br><br>' : '');
            }
          }?>
        </form>
      </div><?php
    }
    foreach($data['prompts'] as $key=>$val) {?>
      <a href="<?=account_links($key)?>" <?=$key=='forgot' ? "style='float:right'" : ''?>><?=$val?></a><?php
    }?>
  </div>
</div>


<!-- </div> -->

<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
var input = document.querySelector("#fullphone");
var pSwitches = document.querySelectorAll('.ptoggler');
var pElements = document.querySelectorAll('.password');

var test1sec = document.querySelector('.form');
//var test2sec = document.getElementById('test2');
//console.log(test1sec);
var activeclass = 'w3-green';
var toggleTabDivs = [test1sec];
var tawkTo = false;
var cf_country = '<?=CF_COUNTRY?>';
var domain = '<?=HOME?>';
</script>
<script src="<?=HOME?>/assets/loginsystem/build/js/intlTelInput.js"></script>
<script src="<?=HOME?>/assets/js/login.js"></script>
<script src="<?=HOME?>/assets/js/gen.js"></script>