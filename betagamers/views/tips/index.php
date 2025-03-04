<?php include ROOT."/app/betagamers/incs/header.php"?>
<div class="w3-row-padding w3-stretch">
    <?php include ROOT."/app/betagamers/incs/sidenav.php"?>
    <div class="w3-col m9"><?php
        foreach($data['marks'] as $key=>$val){?>
            <h3 style="color:white; background-color: #003300; padding: 16px; border-radius: 10px;"><?=$data['games'][$key]?></h3>
            <div class="w3-container">
                <div class="w3-panel w3-center w3-card">
                    <?=$val?>
                </div>
            </div><?php
        }?>
        <div class='w3-center'><?php
            if(!USER_LOGGED_IN) {?>
                <a href='<?=account_links('register')?>' class='w3-button w3-green' style='border-radius: 15px 50px 30px;'><?=$data['prompts']['reg']?></a><?php 
            }?>
            <a href='<?=support_links('prices')?>' class='w3-button w3-green w3-round-xlarge'><?=$data['prompts']['price']?></a>
            <a href= '<?=pay_links(currencies(USER_COUNTRY)['link'])?>' class='w3-button w3-green' style='border-radius: 15px 50px 30px;'><?=$data['prompts']['sub']?></a>
        </div>
    </div>
</div>
<div class="w3-row-padding w3-section">
    <div class='w3-half'>
        <h3 style="color:white; background-color: #003300; padding: 16px; border-radius: 10px;"><?=$data['bigodds']['header']?></h3>
        <div class="w3-card">
            <div class="w3-center">
                <p style="font-size: 20px;"><?=$data['bigodds']['text']?>: </p><p class="w3-large"><i class="fa fa w3-spin" style="background: green; color: white; padding: 10px"><b><?=$data['bigodds']['odds']?></b></i></p><br>
                <p><a href="<?=tips_links('bigodds')?>" class="w3-btn w3-green w3-round-xlarge"><?=$data['bigodds']['prompt']?> <i class="fa fa-eye" style="color:white; margin-left: 5px;"></i></a></p><br><br>
            </div>
        </div>
    </div>
    <div class='w3-half'>
        <h3 style="color:white; background-color: #003300; padding: 16px; border-radius: 10px;"><?=$data['wins']['header']?></h3>
        <div class="slideshow-container" style='width:100%; height:400px'><?php
            foreach ($data['screenshots'] as $val) {?>
                <div class="mySlides fade w3-center">
                    <img class='w3-image' src='<?=HOME."/recs/".$val['date'].'/'.$val['img_src']?>' alt="<?=$data['wins']['alt']?>" />
                </div><?php 
            }?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div><br>
        <div class='w3-center'><?php
            vprintf(str_repeat("<span class='dot' onclick='currentSlide(%u)'></span>", 10), range(0,9));
            // for ($x = 0; $x < 10; $x++) {
            //     echo '<span class="dot" onclick="currentSlide('.$x.')"></span>';
            // }?>
        </div>
        <div class='w3-center w3-section'><a href='<?=tips_links('wins')?>' class='w3-btn w3-green'><?=$data['wins']['prompt']?> <i class="fas fa-forward"></i></a></div>
    </div>
</div><?php
if (implode($data['bestmarks'])) {?>
    <div class=''>
        <h3 style="color:white; background-color: #003300; padding: 16px; border-radius: 10px;"><?=$data['bestmarks']['header']?></h3>
        <div class="w3-container">
            <div class="w3-panel w3-center w3-card w3-padding-16">
                <h3><?=ucwords(strtolower($data['bestmarks']['text']))?></h3>
                <?=$data['bestmarks']['marks']?>
            </div>
        </div>
    </div><?php
}?>
<div class="w3-panel">
    <h3><?=$data['tracker']['header']?></h3>
    <table class="w3-table">
        <tr style="color:green"><th><?=implode('</th><th>', $data['tracker']['th'])?></th></tr><?php
        foreach($data['tracker']['percent'] as $key=>$val) {?>
            <tr>
                <td><?=ucwords(strtolower($data['games'][$key]))?></td>
                <td><?=$val?></td>
            </tr><?php
            }?>
    </table>
</div>
<div class="w3-panel content">
    <?php include ROOT."/app/betagamers/incs/tipsindex/".LANG.".php"?>
</div>
<?php include ROOT.'/app/betagamers/incs/footer.php'?>
<script>var showSlides=true;</script>
<script src="<?=HOME.'/assets/js/gen.js'?>"></script>