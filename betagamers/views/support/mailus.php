<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="tips-no">
<h1 style="color: green;"><?=$data['h1']?></h1>
<span class="error"><?php echo $data['formerr']['gen'] ?? ''?></span>
<span class="success"><?php echo $data['formsuccess']?></span>
<form method="post" action="<?php echo htmlspecialchars(URI);?>"><?php
foreach($data['formfields'] as $key=>$val) {?>
    <div class='w3-margin'><?php
    if(is_array($val)) {
        echo implode("<span style='margin-right: 10px'></span>", $val)."<span class=error>".$data['formerrors'][$key]."</span>";
    } else {
        echo $data['fieldnames'][$key]."$val<span class=error>".$data['formerrors'][$key]."</span>";
    }
        ?>
    </div><?php
}?>
</form>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>