<br>
<div class="w3-container w3-grey w3-text-white">
    <div class="w3-row w3-stretch"><?php
        foreach($data['footer']['sec1'] as $ind=>$val) {?>
            <div class="w3-half"><?php
                foreach($val as $key=>$subval) {?>
                    <div class="w3-col s6 w3-padding-16 foot" style="text-align:left">
                        <ul class="w3-ul">
                            <li class="w3-opacity"><?=$key?></li><?php
                            foreach($subval as $sub2ind=>$sub2val) {?>
                                <li><a href="<?=$sub2val['link']?>" <?=isset($sub2val['target']) ? "target='_blank'" : ''?>><?=isset($sub2val['icon']) ? "<i class='fab ".$sub2val['icon']."' style='font-size:18px;color:white'></i> " : ''?><?=$sub2val['text']?></a></li><?php
                            }?>
                        </ul><?php
                        if($ind==0 && array_key_index($key, $val)===0) {?>
                            <div class="w3-dropdown-hover">
                                <button class="footlang"><?=$data['header']['langs'][LANG]['text']?>
                                <picture>
                                <source srcset="<?=HOME?>/assets/images/<?=strtolower($data['header']['langs'][LANG]['text'])?>1.webp" type="image/webp" width='28' height='28'>
                                <img src="<?=HOME?>/assets/images/<?=strtolower($data['header']['langs'][LANG]['text'])?>1.png" alt="<?=$data['header']['langs'][LANG]['alt']?>" style="padding-left: 5px" width='28' height='28'>
                                </picture>
                                <i class="fa fa-caret-down" style="font-size:18px;"></i></button>
                                <div class="w3-dropdown-content w3-bar-block w3-border" style="left:0;"><?php
                                    foreach($data['header']['langs'] as $key=>$val) {
                                        if($key==LANG) continue?>
                                        <a href="https://<?=$key!='en' ? "$key." : ''?>betagamers.net" class="w3-bar-item w3-button">
                                            <picture>
                                                <source srcset="<?=HOME?>/assets/images/<?=strtolower($val['text'])?>.webp" type="image/webp" width='28' height='28'>
                                                <img src="<?=HOME?>/assets/images/<?=strtolower($val['text'])?>.png" alt="<?=$val['alt']?>" width='28' height='28'>
                                            </picture><?=$val['locale']?>
                                        </a><?php
                                    }?>
                                </div>
                            </div><?php
                        }?>
                    </div><?php
                }?>
            </div><?php
        }?>
    </div>

    <div class="w3-panel w3-center w3-padding-16">
        <picture class="w3-image">
            <source srcset="<?=HOME?>/assets/images/18.webp" type="image/webp" width='137' height='135'>
            <img src="<?=HOME?>/assets/images/18.png" alt="Above 18" width='137' height='135'>
        </picture>
        <p><?php
            foreach($data['footer']['sec2']['account'] as $key=>$val) {?>
                <a href="<?=$key?>" target="_blank" style="text-decoration: none; color:yellow;"><?=$val?></a><?php
                if(array_key_index($key, $data['footer']['sec2']['account'])!==(count($data['footer']['sec2']['account'])-1)) echo ' | ';
            }?>
            </p>
    </div>
    <div class= "w3-center" style="padding-bottom: 16px;">
        <a href= "<?=HOME?>" style="text-decoration: none">&copy; <?=date('Y').' '.$data['footer']['sec2']['bggroup']?></a> <p><?=$data['footer']['sec2']['rights']?></p>
    </div>
</div>