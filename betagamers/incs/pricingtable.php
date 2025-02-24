<?php
//$this->plan_features();
$plans = plan_features($key);
// show($plans);
if($this->page == 'profile') {?>
    <br><table style="width:100%"><?php
    foreach ($plans as $subkey => $subval) {
        $price = single_price($subval['id'], 1, $data['plan']['currency']);
        ?>
        <tr>
            <td><?=ucwords(strtolower(str_ireplace(['plano', 'plan', 'tarif'], '', $subkey)));?><br><?=$data['plan']['cur_sign'].(DISCOUNT ? '<s>'.$price['price'].'</s> '.$price['discount'] : $price['price'])?></td>
            <td style="text-align: left"><h3><?=$data['plan']['features']?></h3>
                <ul class="w3-ul">
                    <li><?=implode('</li><li>', $subval['features'])?></li>
                    <li><a href='<?=$subval['id']=='free' ? HOME : $data['plan']['paylink']?>'><button><?=$data['plan']['choose']?></button></a></li>
                </ul>
            </td>
        </tr><?php
    }?>

</table><br><?php
} else {
    if($this->page == 'pricings') {
        //include FREE PLAN section
        $pricing = plan_pricing('free', $data['plan']['cur_lower']);?>
        <h3><?=$this->free_features[0]?></h3>
        <?=($show_free === true) ? '<div class="w3-card-4">' : ''?>
        <ul class="w3-ul">
        <?php
        foreach($this->free_features as $key=>$features) {
            if($key == 0){
                continue;
            } ?>
            <li><?=$features?></li><?php
        } ?>
        </ul>
        <?=($show_free === true) ? '</div>' : ''?>
        <br><?php
    }
    foreach($plans as $subkey=>$subval) {
        // if($subval['id']=='free' && $this->page != 'pricing') continue;
        if($this->page != 'prices' && $subval['id']=='free') continue;
        $pricing = plan_pricing($subval['id'], $data['plan']['cur_lower']);
        //show($pricing);
        $checkcombo = $subval['id'] == 'combosil' || $subval['id'] == 'combogol' || $subval['id'] == 'combopro';
        if($checkcombo && count($data['table']['headers'])>2) {
            array_shift($data['table']['headers']);
        }?>
        <h3><?=$subkey?></h3>
        <?=$this->page == 'prices' ? '<div class="w3-card-4">' : ''?>
        <ul class="w3-ul">
            <li><?=implode('</li><li>', $subval['features'])?></li>
        </ul><br><?php
        if($subval['id']=='free') echo '</div>';
        if($subval['id']!='free') {?>
            <table style="width:100%; "><?php
                if($this->viewonly && $checkcombo) {
                    foreach($pricing as $sub2key=>$sub2val) {?>
                        <tr>
                            <th><?=$data['table']['headers'][1]?></th>
                            <th><?=$data['plan']['cur_sign'].(DISCOUNT ? '<s>'.$sub2val['price'].'</s> '.$sub2val['discount'] : $sub2val['price'])?></th>
                        <tr><?php
                    }
                } else {?>
                    <tr><th><?=implode('</th><th>', $data['table']['headers'])?></th></tr><?php
                    foreach($pricing as $sub2key=>$sub2val) {?>
                        <tr>
                            <?=!$checkcombo ? "<td>$sub2key</td>" : ''?>
                            <td><?=$data['plan']['cur_sign'].(DISCOUNT ? '<s>'.$sub2val['price'].'</s> '.$sub2val['discount'] : $sub2val['price'])?></td><?php
                            if(!$this->viewonly) {?>
                                <td>
                                    <a href=<?='system?planid='.$data['plan']['pre'].'_'.$data['plan']['cur_lower'].'_'.strtolower(str_replace(' ', '_', $sub2val['description']))?> >
                                        <button><?=$data['table']['action'].(DISCOUNT ? $sub2val['discount'] : $sub2val['price']).' '.$data['plan']['cur_upper']?></button>
                                    </a>
                                </td><?php
                            }?>
                        </tr><?php
                    }
                }?>
            </table><?php
            if($this->page == 'prices') echo '</div>';
        }?><br><?php
    }
}