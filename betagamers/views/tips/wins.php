<?php include ROOT."/app/betagamers/incs/header.php"?>
<h1 style='text-align: center'><?=$data['h1']?></h1><?php
foreach($data['screenshots'] as $key=>$val) {?>
    <div class='w3-row-padding w3-section'>
        <h3 style = 'margin-top: 5%'><?=setlocaledate(strtotime($key))?></h3><hr><?php
        foreach($val as $subkey=>$subval) {?>
            <div class= 'w3-col m4 w3-margin-top'>
                <img  class='w3-image' src='<?=HOME."/recs/".$subval['date'].'/'.$subval['img_src']?>'  alt='<?=$data['alt']?>'>
            </div><?php
        }?>

    </div><?php
}
include ROOT.'/app/betagamers/incs/footer.php'?>