<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="<?=$this->writeupclass ?? 'tips-prof'?>">
        <h2 class='w3-center'><?=$data['h2']?></h2><br>
        <?=$data['instructions'] ?? ''?>
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
        }

        if($this->page == 'prices') {?>
            <div class="w3-center"><?php
            if(USER_LOGGED_IN === true) {?>
                <a href='<?=$data['plan']['paylink']?>'>
                <button class="w3-button w3-green tablink w3-hover-none"><?=$data['prompt'][0]?></button>
                </a><?php 
            } else {?>
              <div class="w3-bar w3-green">
                <a style="text-align: center;" href="<?=account_links('register')?>">
                <button class="w3-bar-item w3-button w3-border w3-hover-none"><?=$data['prompt'][1]?></button>
                </a>
                <a style="text-align: center;" href="<?=$data['plan']['paylink']?>">
                <button class="w3-bar-item w3-button w3-border w3-hover-none"><?=$data['prompt'][2]?></button>
                </a>
              </div><?php 
            } ?>
            </div><?php 
        }?>
    </div>
</div><br><br>
<?php include INCS.'/footer.php';?>
<script>
var test1sec = document.querySelector('<?=$this->writeupclass ? '.m9' : '.tips-prof'?>');
var activeclass = 'w3-green';
var toggleTabDivs = [test1sec];
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>