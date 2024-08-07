<?php include "../app/excelwrite/incs/header.php"?>
<div class='bg-contactus'>
    <h2 class=center>Contact Us</h2>
    <div class='contactus'><?php
    foreach($data['contacts'] as $val) {?>
        <div>
            <div>
                <i class='<?=$val['icon']?>' style='font-size:36px'></i>
            </div>
            <div>
                <p><b><?=$val['channel']?></b></p><?php
                if($val['link']) {?>
                    <p><a href='<?=$val['link']?>'><?=$val['value']?></a></p><?php
                } else {?>
                    <p><?=$val['value']?></p><?php
                }?>
            </div>
        </div><?php
    }?>
    </div>
</div>
<script src='<?=HOME?>/assets/js/gen.js'></script>
<?php include "../app/excelwrite/incs/footer.php"?>