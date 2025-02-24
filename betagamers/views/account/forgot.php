<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="tips-noforg tabdiv">
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
                <span class="success"><?=$data['formsuccess'][$key]?></span>
                <span class="error"><?=$data['formerror'][$key] ?? ''?></span><?php
                foreach($val as $subkey=>$subval) {
                    echo $data['fieldnames'][$key][$subkey]."$subval".($subkey=='email' || $subkey=='fullphone' ? '<br><br>' : '');
                }?>
            </form>
        </div><?php
        }?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var input = document.querySelector("#fullphone");
    var test1sec = document.querySelector('.tabdiv');
    var activeclass = 'w3-green';
    var toggleTabDivs = [test1sec];
    var tawkTo = false;
    var cf_country = '<?=CF_COUNTRY?>';
    var domain = '<?=HOME?>';
</script>
<script src="<?=HOME?>/assets/loginsystem/build/js/intlTelInput.js"></script>
<script src="<?=HOME?>/assets/js/login.js"></script>
<script src="<?=HOME?>/assets/js/gen.js"></script>