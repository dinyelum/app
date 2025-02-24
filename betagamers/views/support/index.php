<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="tips-prof">
        <h1 style="color:green; text-align: center;"><?=$data['h1']?></h1>
        <h3><?=$data['call']['header']?></h3>
        <b><?=$data['call']['prompt']?></b><br><br>
        <?=$data['call']['phone']?><br><br>

        <b><?=$data['email']['prompt']?></b><br><br>
        <?=$data['email']['text']?>
        <br><br>

        <b><?=$data['chat']['prompt']?></b><br><br>
        <?=$data['chat']['text']?><br><br>

        <h3><?=$data['work']['header']?></h3>
        <?=$data['work']['text']?><br><br>

        <h3><?=$data['social']['header']?></h3>
        <div class="w3-row-padding-stretch"><?php
        foreach($data['socials'] as $ind=>$val) {?>
            <div class="w3-col m6">
                <ul class="w3-ul"><?php
                    foreach($val as $subkey=>$subval) {?>
                        <li><i class="<?=$subval['icon']?>" style="font-size:24px;<?=isset($subval['color']) ? 'color:'.$subval['color'] : ''?><?=($subkey=='ig') ? 'background:radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%); border-radius:10px' : ''?>"></i>
                        <b><?=$subval['text']?></b><br><br>
                        <a href="<?=$subval['link']?>" target="_blank"><?=$subval['name']?></a></li><br><?php
                    }?>
                </ul>
            </div><?php
        }?>
    </div>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script src="<?=HOME?>/assets/js/gen.js"></script>