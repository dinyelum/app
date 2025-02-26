<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
        <h1><?=$data['h1']?></h1>
        <form method="post" action="<?=htmlspecialchars(URI)?>"><?php
            echo "<span class=error>".$data['formerrors']['gen']."</span>";
            foreach($data['formfields'] as $val) {?>
                <div class="w3-row-padding w3-stretch"><?php
                    foreach($val as $subkey=>$subval) {
                        echo "<div class='w3-col m4'>$subval<span class=error>".$data['formerrors'][$subkey]."</span></div>";
                    }?>
                </div><?php
            }?>
        </form>
        <div class=tabscroll><?php
        if(is_array($data['clientdata'])) {
            if(count($data['clientdata'])) {?>
                <h2><?=$data['h2']?></h2>
                <table class=w3-table><?php
                echo "<tr><th>".implode("</th><th>", array_keys($data['clientdata'][0]))."</th></tr>";
                foreach($data['clientdata'] as $val) {?>
                    <tr><?php
                    foreach($val as $subkey=>$subval) {
                        echo "<td>$subval</td>";
                    }?>
                    </tr><?php
                }?>
                </table><?php
            } else {
                echo "<i>No result</i>";
            }
        }?>
        </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
    var tawkTo = false;
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>