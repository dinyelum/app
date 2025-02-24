<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-card-2 form">
<div class="w3-container formhead">
<h1><?=$data['h1']?></h1>
</div>
<span class="error"><?=$data['formerrors']['gen'] ?? '' ?></span>
<form class="w3-container w3-margin-top" method="post" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]);?>">

<div class="w3-row-padding w3-section"><?php
	foreach($data['formfields'] as $ind=>$val) {?>
		<div class='w3-half <?=$ind==1 ? 'form2' : ''?>'><?php
			foreach($val as $key=>$subval) {
				if($key=='noemail' || $key=='') {
					echo "<br><label>$subval ".$data['fieldnames'][$key]."</label><br><br>";
				} else {
					echo $data['fieldnames'][$key]."$subval<span class=error>".$data['formerrors'][$key]."</span>".(($key!='email' && $key!='password' && $key!='signature') ? '<br><br>' : '');
				}
			}
			if($ind==1) echo $data['terms'];
		
		
			?>
		</div><?php
	}?>
</div>
<input type="submit" name="submit" value="<?=$data['prompts']['submit']?>">  
<a style="float:right;" href="<?=account_links('login')?>"><?=$data['prompts']['login']?></a>
</form>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
	// var input = document.querySelector("#phone");
	var pSwitches = document.querySelectorAll('.ptoggler');
	var pElements = document.querySelectorAll('.password');
	var dSwitch = document.getElementById('noemail');
	var dElement = document.getElementById('email');
    var tawkTo = false;
	var cf_country = '<?=CF_COUNTRY?>';
	var domain = '<?=HOME?>';
</script>
<script src="<?=HOME?>/assets/loginsystem/build/js/intlTelInput.js"></script>
<script src="<?=HOME?>/assets/js/login.js"></script>