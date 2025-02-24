<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="<?=$this->writeupclass?>">
        <h1 class="w3-center"><?=$data['h1']?></h1><?php
        include INCS.'/support/'.LANG.'/writeups/'.$this->page.'.php'?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script src="<?=HOME?>/assets/js/gen.js"></script>