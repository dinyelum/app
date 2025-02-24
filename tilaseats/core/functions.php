<?php 
//app specific functions i.e functions for particular project different from general functions
function fa_fa_stars($rating) {
    $rem = 5-$rating;
    list($whole, $decimal) = sscanf($rating, '%d.%d');
    for($i=0; $i<$whole; $i++) {
        echo "<i class='fa fa-star primary'></i>";
    }
    if(isset($decimal) && $decimal > 0) {
        echo "<i class='fa fa-star-half-o primary'></i>";
        for($i=0; $i<$rem-1; $i++) {
            echo "<i class='fa fa-star-o primary'></i>";
        }
    } else {
        for($i=0; $i<$rem; $i++) {
            echo "<i class='fa fa-star-o primary'></i>";
        }
    }
}

function food_card(array $values) {?>
    <div class='foodcard left'>
        <div class=foodcardimg>
            <img src='<?=HOME?>/assets/images/<?=$values['image']?>' alt='<?=$values['imagealt']?>'>
        </div>
        <div class=foodcardtxt>
            <p><?=$values['name']?></p>
            <p><?=$values['short_desc']?></p>
            <p class=container>
                <span class=left>&#8358;<?=isset($values['discount']) ? '<s>'.$values['amount'].'</s> '.$values['discount'] : $values['amount']?></b></span>
                <span class=addcartbtn<?=$values['id']?>><?php
                    if(in_array($values['id'], $_SESSION['cart'])) {?>
                        <button class='right disabled'><i class='fa fa-shopping-cart'></i> <i class='fa fa-check'></i></button><?php
                    } else {?>
                        <button class=right onclick="addToCart(<?=$values['id']?>)">Add to Cart</button><?php
                    }?>
                </span>
            </p>
        </div>
    </div><?php
}

function cat_card(array $values) {?>
    <a href="categories/show?catid=<?=$values['id']?>">
        <div class='catcard left'>
            <div class=catcardimg>
                <img src='./assets/images/<?=$values['image']?>' alt='<?=$values['imagealt']?>'>
            </div>
            <div class='catcardtxt center'>
                <?=$values['name']?>
            </div>
        </div>
    </a><?php
}

function sales_card(array $values) {?>
    <div class='foodcard left'>
        <div class=foodcardimg>
            <img src='./assets/images/<?=$values['image']?>' alt='<?=$values['imagealt']?>'>
        </div>
        <div class=foodcardtxt>
            <p class=center><?=$values['name']?></p>
            <p class=center>
                <?=fa_fa_stars($values['ratingaverage'])?>
                <!--<i>(15)</i>-->
            </p>
            <p class=center><?=$values['salescount']?> sales in the last 20 days</p>
            <p class=container>
                <span class=left>&#8358;<?=isset($values['discount']) ? '<s>'.$values['amount'].'</s> '.$values['discount'] : $values['amount']?></b></span>
                <span class=addcartbtn<?=$values['id']?>><?php
                    if(in_array($values['id'], $_SESSION['cart'])) {?>
                        <button class='right disabled'><i class='fa fa-shopping-cart'></i> <i class='fa fa-check'></i></button><?php
                    } else {?>
                        <button class=right onclick="addToCart(<?=$values['id']?>)">Add to Cart</button><?php
                    }?>
                </span>
            </p>
        </div>
    </div><?php
}

function cart_items(array $data) {?>
    <div class='cartitemscard container' id=card<?=$data['id']?>>
        <div class='cartimg left'>
            <img src="./assets/images/<?=$data['image']?>">
        </div>
        <div class='cartdesc left'>
            <span class='right clickable' onclick="remove(<?=$data['id']?>)"><i class='fa fa-times'></i></span>
            <p class='cartdesctitle primary'><?=$data['name']?></p>
            <p><?=$data['short_desc']?></p>
            <p>&#8358;<?=isset($data['discount']) ? '<s>'.$data['amount'].'</s>'.$data['discount'] : $data['amount']?></p>
            <input type=hidden id=amt<?=$data['id']?> value="<?=$data['discount'] ?? $data['amount']?>">
            <div class='cartitemsqty'>
                <span class=left>
                    <b>Quantity</b>
                    <button class=subbtn onclick="decrease(<?=$data['id']?>)">-</button>
                    <input type="text"  name='<?=$data['id']?>' value=1 style='text-align:center' id=qty<?=$data['id']?> class=qty oninput="multiply(<?=$data['id']?>)">
                    <button class=addbtn onclick="increase(<?=$data['id']?>)">+</button>
                </span>
                <span class=right style='text-align:right'>
                    <b>&#8358;<span class=qtytotal id=qtytotal<?=$data['id']?>><?=$data['discount'] ?? $data['amount']?></span></b>
                </span>
            </div>
        </div>
    </div><?php
}

function display_acct_details($acctsdata) {
    foreach ($acctsdata as $key => $val) {?>
        <table>
        <tr>
            <td>Account Name</td>
            <td><?=$val['acctname']?></td>
        </tr>
        <tr>
            <td>Account Number</td>
            <td><?=$val['acctnumber']?></td>
        </tr>
        <tr>
            <td>Bank</td>
            <td><?=$val['bank']?></td>
        </tr>
    </table><?php
        if($key > 0 && $key < count($acctsdata)) {
            echo '<h3>OR</h3>';
        }
    }
}
//checkloggedin
