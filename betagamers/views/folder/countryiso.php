<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9">
    <div class='tips-no w3-margin-top' style='border:none; width: 100%'>
        <h1><?=$data['h1']?></h1>
        <?=(count($data['selected']) ? implode(', ', $data['selected']).'<br>Count: '.count($data['selected']) : '')?>
        <form method="post" action="<?=htmlspecialchars(URI)?>">
            <div class='w3-row-padding w3-stretch w3-border' style='height: 300px; overflow-y: scroll'><?php
                foreach($data['allcountries'] as $ind=>$val) {
                    echo "<div class='w3-col m4'>";
                    foreach($val as $subkey=>$subval) {
                        echo "<p><input type='checkbox' name=$subkey value='$subkey' id=$subkey ".(array_key_exists($subkey, $_POST) ? 'checked' : '')."><label for=$subkey>$subval</label><span class=error></span></p>";
                    }
                    echo "</div>";
                }?>
            </div><br>
            <input type="submit" name='submit' value=Generate>
        </form>
    </div>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script>var tawkTo=false</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>