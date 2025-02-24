<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class= "w3-col m9 justify">
        <h1><?=$data['h1']?></h1>
        <img src="<?=HOME?>/assets/images/bgjob.webp" style="width: 100%"><br>
        <a href="https://freerangestock.com/photographer/mohamedhassan/4291" target="_blank"><?=$data['imgcaption']?></a>
        <h2><?=$data['h2']?></h2><?php
        foreach($data['jobs'] as $val) {
            if(is_array($val)) {
                foreach($val as $subkey=>$subval) {
                    if($subkey=='title') {
                        echo "<h3>$subval</h3>";
                    } else {
                        if(is_array($subval)) {
                            echo  "<p>".implode('</p><p>', $subval)."</p>";
                        } else {
                            echo "<p>$subval</p>";
                        }
                    }
                }
            } else {
                echo "<p>$val</p>";
            }
        }?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script src="<?=HOME?>/assets/js/gen.js"></script>