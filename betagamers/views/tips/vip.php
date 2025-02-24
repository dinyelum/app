<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9"><?php
    if(isset($data['nosub'])) {
        echo '<div class=tips-noprof>'.tag_format($data['nosub'], [['href'=>pay_links(currencies($_SESSION['users']['country'])['link']), 'style'=>'color:green; text-decoration:underline']]).'</div>';
    } else {?>
        <h2><?=$data['h2']?></h2>
        <div class=sec1><?php
            display_games($data['tabs'], $data['odds'], $data['totalodds'], $data['putall'])?>
        </div><?php
        if($data['odds']=='ap') {?>
            <br><br>
            <h2><?=$data['apeheader']?></h2>
            <div class=sec2><?php
                display_games($data['tabs'], 'ape')?>
            </div><?php
        }
    }?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php';?>
<script>
var sec1 = document.querySelector('.sec1');
var sec2 = document.querySelector('.sec2');
var tawkTo = false;
var activeclass = 'w3-green';
if(sec1 && sec2) {
    var toggleTabDivs = [sec1, sec2];
} else if(sec1 || sec2) {
    var sec = sec1 ?? sec2;
    var toggleTabDivs = [sec];
}
</script>
<script src="<?=HOME?>/assets/js/gen.js"></script>