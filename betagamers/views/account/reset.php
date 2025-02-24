<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="tips-no"><?php
if(isset($data['showform']) && $data['showform'] === true) {?>
    <h1><?=$data['h1']?></h1>
    <form method="post" action="<?=htmlspecialchars(URI)?>">
        <span class="success"><?=$data['formsuccess'] ?? ''?></span>
        <span class="error"><?=$data['formerror'] ? $data['formerror'].'<br>' : ''?></span><?php
        foreach($data['formfields'] as $key=>$val) {
            if($key=='') {
                echo "<br><label>$val ".$data['fieldnames'][$key]."</label><br><br>";
            } else {
                echo $data['fieldnames'][$key]."$val".(($key!='password' && $key!='signature') ? '<br><br>' : '');
            }
        }?>
    </form><?php
} else {
    echo "<p style='text-align:center'>".$data['response_err']."</p>";
}
?>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
	// var input = document.querySelector("#phone");
	var pSwitches = document.querySelectorAll('.ptoggler');
	var pElements = document.querySelectorAll('.password');
    var tawkTo = false;
	var cf_country = '<?=CF_COUNTRY?>';
    var domain = '<?=HOME?>';
</script>
<script src="<?=HOME?>/assets/loginsystem/build/js/intlTelInput.js"></script>
<script src="<?=HOME?>/assets/js/login.js"></script>
<script src="<?=HOME?>/assets/js/gen.js"></script>