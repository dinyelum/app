<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
            <h1><?=$data['h1']?></h1>
            <form action="<?=htmlspecialchars(URI)?>"><?php
                echo "<span class=success>".$data['formsuccess']."</span>";
                echo "<span class=error>".$data['formerrors']['gen']."</span>";
                
                foreach($data['formfields'] as $key=>$val) {?>
                    <div class='w3-margin'><?php
                    if(is_array($val)) {
                        echo implode("<span style='margin-right: 10px'></span>", $val)."<span class=error>".$data['formerrors'][$key]."</span>";
                    } else {
                        echo "$val<span class=error>".$data['formerrors'][$key]."</span>";
                    }
                        ?>
                    </div><?php
                }?>
            </form>
        </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var tawkTo = false;
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>