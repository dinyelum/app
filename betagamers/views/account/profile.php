<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="tips-prof">
        <table style="width:100%">
            <caption><h3><?=$data['table']['h1']?></h3></caption><?php
            foreach($data['table']['user'] as $key=>$val) {?>
                <tr>
                    <td><?=$val?></td>
                    <td colspan="2"><?=$_SESSION["users"][$key]?></td>
                </tr><?php
            }?>
            
            <tr>
                <td rowspan="<?=count($data['substatus'])?>"><?=$data['table']['substatus']?></td>
                <td><?=ucwords($data['plannames']['ultimate'])?></td>
                <td><span style='color:<?=$data['table']['color']['ultimate'] ?? 'red'?>'><?=$data['substatus']['ultimate']?></span></td>
            </tr><?php
            foreach($data['substatus'] as $key=>$val) {
                if($key=='ultimate') continue?>
                <tr>
                    <td><?=ucwords($data['plannames'][$key])?></td>
                    <td><span style='color:<?=$data['table']['color'][$key] ?? 'red'?>'><?=$val?></span></td>
                </tr><?php
            }?>
        </table><br><br>
        <h3 class='w3-center'><?=$data['table']['h2']?></h3><br><?php
        //$this->tabs($tabs, $sports, all_plans: $all_plans, cur: $cur_details['link'], cur_sign: $cur_details['cur_sign']) ?>
        
        <div class="w3-center">
            <div class="w3-bar w3-white"><?php
            foreach($data['tabs'] as $key=>$val) { ?>
                <span class="w3-bar-item w3-btn tablinks <?=$key==$this->sports ? 'w3-green' : ''?> w3-hover-none" ><?=$val?></span><?php
            }?>
            </div>
        </div><?php
        foreach($data['tabs'] as $key=>$val) {?>
            <div id="<?=$key ?>" class="unit w3-margin tabcontent" <?=($key != $this->sports) ? 'style="display:none"' : '' ?> ><?php 
                include ROOT."/app/betagamers/incs/pricingtable.php" ?>
            </div> <?php
        }?>
    </div>
</div><br><br>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
var test1sec = document.querySelector('.tips-prof');
var activeclass = 'w3-green';
var toggleTabDivs = [test1sec];
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>