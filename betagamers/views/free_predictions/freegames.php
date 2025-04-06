<?php
include INCS."/header.php";
include INCS."/advertstop.php";
?>
<div class="w3-row-padding w3-stretch">
    <div class= "w3-col m8 norm">
        <h1><?=$data['h1']?></h1>
        <?=images($data['heroimg'], true)?>
        <i><?=$data['lastmodified']?></i><br><br><?php
        echo $data['socials'];
        if(isset($data['writeup'])) {
            include $data['writeup'];
        } else {
            include ROOT.'/app/betagamers/incs/free_predicts_writeups/'.LANG.'/'.$this->page.'.php';
        }?>
    </div>
    <div class="w3-col m4">
        <h3><?=$data['relatedposts']['h3']?></h3><?php
        foreach($data['relatedposts']['list'] as $key=>$val) {?>
            <div class="w3-card">
                <?=($val['text']) ? images(['name'=>$key, 'image'=>"$key.jpg", 'alt'=>$val['alt'], 'text'=>$val['text']], true) : ''?>
                <h2><a href="<?=$val['filename'] ?? $key?>"><?=$val['text']?></a></h2>
            </div><?php
        }?>
        </div>
    </div><br><br>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
var test1sec = document.querySelector('.norm');
var activeclass = 'w3-green';
var toggleTabDivs = [test1sec];
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>
<?php include INCS."/advertsbottom.php"?>