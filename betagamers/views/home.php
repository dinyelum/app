<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="slideshow-container" style='width:100%; height:400px; background:#dfe3e6'><?php
    foreach($data['slide_images'] as $key=>$val) {?>
<div class="mySlides fade">
<div class="numbertext"><?=($number=$number ?? 1).' / '.$data['slide_images_count']?></div>
<?=images(['name'=>$key, 'alt'=>$val['alt']], true)?>
<div class="text"><a href="<?=($key == 'bgslide') ? HOME : free_games_link($key)?>" style="text-decoration:none; color: white;"><?=$val['text']?></a></div>
</div><?php
        $number++;
    }?>
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div><br>
<div class='w3-center'><?php
for($number = 1; $number <= $data['slide_images_count']; $number++){?>
<span class="dot" onclick="currentSlide(<?=$number?>)"></span><?php
}?>
</div><br><br>

<div class="w3-row-padding" style='width:100%; height:auto'><?php
if(USER_LOGGED_IN) {?>
<div class='w3-quarter'>
<a href="<?=$data['herolinks']['profile']['link']?>" class='w3-button w3-round-xlarge w3-green w3-margin-top' style='width:100%'><?=$data['herolinks']['profile']['text']?></a>
</div><?php
} else {?>
<div class='w3-quarter w3-margin-top'>
<a href="<?=$data['herolinks']['reg']['link']?>" class='w3-button w3-col s6 w3-green' style='border-top-left-radius: 16px;
  border-bottom-left-radius: 16px;'><?=$data['herolinks']['reg']['text']?></a>
<a href="<?=$data['herolinks']['login']['link']?>" class='w3-button w3-col s6 w3-green w3-border-left' style='border-top-right-radius: 16px;
  border-bottom-right-radius: 16px;'><?=$data['herolinks']['login']['text']?></a>
</div><?php
}?>

<div class='w3-quarter'>
<a href="<?=$data['herolinks']['pricing']['link']?>" class='w3-button w3-round-xlarge w3-green w3-margin-top' style='width:100%'><?=$data['herolinks']['pricing']['text']?></a>
</div>

<div class='w3-quarter'>
<a href="<?=$data['herolinks']['modus']['link']?>" class='w3-button w3-round-xlarge w3-green w3-margin-top' style='width:100%'><?=$data['herolinks']['modus']['text']?></a>
</div><?php
if(LANG == 'en') {?>
<div class='w3-quarter w3-margin-top'>
<a href="<?=$data['herolinks']['blog']['link']?>" class='w3-button w3-col s6 w3-green' style='border-top-left-radius: 16px;
  border-bottom-left-radius: 16px;'><?=$data['herolinks']['blog']['text']?></a>
<a href="<?=$data['herolinks']['scores']['link']?>" class='w3-button w3-col s6 w3-green w3-border-left' style='border-top-right-radius: 16px;
  border-bottom-right-radius: 16px;'><?=$data['herolinks']['scores']['text']?></a>
</div><?php
} else {?>
<div class='w3-quarter'>
<a href="<?=$data['herolinks']['scores']['link']?>" class='w3-button w3-round-xlarge w3-green w3-margin-top' style='width:100%'><?=$data['herolinks']['scores']['text']?></a>
</div>
<?php } ?>
</div><br><br><?php
if(DISCOUNT) {?>
<div class="timer">
<div class="w3-mobile">
<span><?=$this->discount_banner[LANG]['text1']?>!<br> <?=$this->discount_banner[LANG]['text2']?>:</span>
<p id="demo"></p>
</div></div><br><?php
}?>
<h3 style="color:green"><?=$data['freegames']['header']?></h3>
<div id=freetable>
  <?=display_games($data['freegames']['tabs'], 'free')?>
</div>
<a href='<?=$data['freegames']['free_games_page']?>' class='w3-button w3-round-large w3-light-grey'><?=$data['freegames']['viewmore']?> <i class="fas fa-forward"></i></a>
<br><br>
<h3 style="color:green"><?=$data['accurate']['header']?></h3>
<div class="tabscroll">
<table>
<tr>
  <th><?=implode('</th><th>', $data['accurate']['theaders'])?></th>
</tr>
<?php include ROOT.'/app/betagamers/incs/table/'.LANG.'/others/recent.php';?>
</table>
</div>
<br><br>
<h3 style="color:white; background-color: #003300; padding: 16px; border-radius: 10px;"><?=$data['alphasec']['header']?></h3>
<div class="w3-container w3-row-padding">
<div class="w3-half">
<div class="w3-center w3-card">
<p style="font-size: 20px;" class='w3-padding-24'><?=$data['alphasec']['oddstxt']?>: </p><p class="w3-xlarge"><i class="fa fa w3-spin" style="background: green; color: white; padding: 10px"><b>
    <?=$data['alphasec']['totalodds']?></b></i></p>
<p class='w3-padding'><i>(<?=$data['alphasec']['oddsdesc']?>)</i></p>
<p><a href="<?=tips_links('ap')?>" class="w3-btn w3-green w3-round-xlarge"><?=$data['alphasec']['get']?> <i class="fa fa-eye" style="color:white; margin-left: 5px;"></i></a></p><br><br>
</div>
</div>

<div class="w3-half w3-margin-top">
<div class="w3-center w3-card">
<?=$data['alphasec']['marks']?>
<div class=' w3-row'>
<p class="w3-text-green" style="font-family:arial; font-size:20px"><?=$data['alphasec']['accuracytxt']?></p>
</div>
<a href="<?=tips_links()?>" class='w3-button w3-round-xlarge w3-green w3-margin'><?=$data['alphasec']['moreresults']?></a>
</div></div>
</div>

<h3 style="color:green" class='w3-margin-top'><?=$data['popular']['header']?></h3>
<p><?=$data['popular']['populartxt']?>:</p>
<table>
<tr>
  <th><?=implode('</th><th>', $data['popular']['theaders'])?></th>
</tr>
<?php include ROOT.'/app/betagamers/incs/table/'.LANG.'/others/popular.php';?>
</table><br><br>

<h3 style="color:green"><?=$data['upcoming']['header']?></h3>
<table>
<tr>
  <th><?=implode('</th><th>', $data['upcoming']['theaders'])?></th>
</tr>
<?php include ROOT.'/app/betagamers/incs/table/'.LANG.'/others/tompopular.php';?>
</table><br><br><?php
if(count($data['bookies'])) {?>
  <div class='w3-center'>
    <div class='w3-panel'>
      <h3><?=$data['bookies']['header']?></h3>
      <hr><?php
      foreach($data['bookies']['companies'] as $val) {
        list($subheader, $description) = explode('###', $val['description_'.LANG]);?>
        <div class='w3-row-padding'>
          <div class='w3-third'>
            <p><span style='<?=$data['bookies']['colors'][strtolower($val['bookie'])]?>' class='w3-padding w3-xlarge'><?=$val['bookie']?></span></p>
          </div>
          <div class='w3-third'>
            <p class='w3-xlarge'><?=$subheader?></p>
          <p><?=$description?></p>
          </div>
          <div class='w3-third'>
            <p><a href='<?=$data['bookies']['link'].$val['bookie']?>' target='_blank' class='w3-button w3-round w3-green w3-mobile'><?=$data['bookies']['prompt']?></a></p>
          </div>
        </div><hr><?php
      }?>
    </div>
  </div><?php
}?>
<h2 style="color:green; padding: 16px; text-align: center;"><?=$data['plansec']['header']?></h2><?php
foreach($data['plansec']['subheaders'] as $key=>$val) {?>
  <div class= "coltext"><h3><?=$val?></h3></div>
  <div class="store"><?php
  foreach($data['plansec']['sections'][$key] as $subkey=>$subval) {?>
    <div class="<?=$subkey=='' ? 'freecol' : 'othercol'?>">
      <b><a href="<?=$subkey ?: free_games_link()?>"><?=$subval?></a></b>
    </div><?php
  }?>
  </div><br><br><?php
}?>

<div class= "coltext"><h3><?=$data['pricingsec']['header']?></h3></div>
<div class="plan"><?php
foreach($data['pricingsec']['plans'] as $key=>$val) {
  $price = single_price($key, 1, $data['pricingsec']['currency'])?>
  <div class="plancol">
    <div class="w3-card-4">
      <b><?=strtoupper($val)?></b><br><br>
      <?=$data['pricingsec']['cursign'].(DISCOUNT ? '<s>'.$price['price'].'</s> '.$price['discount'] : $price['price']).' / '.$data['pricingsec']['duration'] ?><br><br>
      <a href="<?=support_links('prices')?>" style="color:green; text-decoration: none;"><?=$data['pricingsec']['view']?><i class="fas fa-eye" style="color:green; margin-left: 5px;"></i></a><br><br>
    </div>
  </div><?php            
      }?>
</div>
<?php include ROOT.'/app/betagamers/incs/homepage/'.LANG.'.php'; include ROOT.'/app/betagamers/incs/footer.php'?>
<script>
  var showSlides = true;
  var t = document.querySelector('#freetable');
  var activeclass = '<?=$this->themeclass?>';
  var toggleTabDivs = [t];
  <?php
      if(DISCOUNT) {?>
  //Countdown code
  var countDownDate=new Date("Jan 5, 2024 23:59:59").getTime();var x=setInterval(function(){var now=new Date().getTime();var distance=countDownDate-now;var days=Math.floor(distance/(1000*60*60*24));var hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60));var minutes=Math.floor((distance%(1000*60*60))/(1000*60));var seconds=Math.floor((distance%(1000*60))/1000);document.getElementById("demo").innerHTML=days+"<?=$this->discount_banner[LANG]['d']?> "+hours+"h "+minutes+"m "+seconds+"s ";if(distance<0){clearInterval(x);document.getElementById("demo").innerHTML="Expired"}},1000);<?php
  }?>
</script><?php
?>
<script src="<?=HOME.'/assets/js/gen.js'?>"></script>