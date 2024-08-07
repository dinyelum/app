<?php include "../app/excelwrite/incs/header.php"?>
<div class=adminhome>
    <div class=adminhomecardcontainer><?php
    foreach($data['counts'] as $val) {
        foreach ($val as $subkey=>$subval) {?>
        <a href="<?=($subkey=='users' ? "#" : HOME."/admin/display?section=$subkey")?>" class='admincard center'>
            <p><?=$subval?></p>
            <p><?=$subkey?></p>
        </a><?php
        }
    }?>
    </div>
</div>
<script src='<?=HOME?>/assets/js/gen.js'></script>
<?php include "../app/excelwrite/incs/footer.php"?>