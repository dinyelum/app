<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="tips-prof"><?php
        foreach($data['faqs'] as $val) {
            foreach($val as $subkey=>$subval) {
                echo "<$subkey>$subval</$subkey>";
            }
        }?>
    </div>
</div>