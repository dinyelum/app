<?php include ROOT."/app/betagamers/incs/header.php"?>
<h1 class=w3-center><?=$data['h1']?></h1>
<?=$data['socials'].'<br><br>'?>
<div class="w3-row-padding"><?php
foreach($data['posts']['list'] as $val) {
  foreach($val as $subkey=>$subval) {?>
    <div class= "w3-col m4">
      <div class="w3-card">
        <?=($subval['text']) ? images(['name'=>$subkey, 'image'=>"$subkey.jpg", 'alt'=>$subval['alt'], 'text'=>$subval['text']], true) : ''?>
        <h2><a href="<?=free_games_link($val['filename'] ?? $subkey)?>"><?=$subval['text']?></a></h2>
      </div>
    </div><?php
  }
}?>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
