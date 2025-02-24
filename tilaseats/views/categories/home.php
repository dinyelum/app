<?php
foreach ($data['fooddata'] as $key=>$val) {
    echo "<div class=container><h2>$key</h2>";
    foreach($val as $subval) {
        food_card($subval);
    }
    echo '</div>';
}