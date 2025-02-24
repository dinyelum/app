<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="<?=$this->writeupclass?>">
        <?=writeup_format($data['writeup'])?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script src="<?=HOME?>/assets/js/gen.js"></script>