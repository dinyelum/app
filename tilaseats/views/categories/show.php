<h2><?=$data['fooddata'][0]['category']?></h2>
<div class=container><?php
    foreach ($data['fooddata'] as $key=>$val) {
        food_card($val);
    }?>
</div>