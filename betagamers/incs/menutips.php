<?php
$sidelistarr = side_list_top();
$tips_list = tips_list();
$sidelistarr += $tips_list;
// show($sidelistarr);
$sidelist = [];
foreach ($sidelistarr as $key=>$val) {
    if(array_key_exists('link', $val)) {
        if($val['id']=='on' || $val['id']=='off') {
            if($val['id']=='on' && (isset($_SESSION['users']["logged_in"]) && $_SESSION['users']["logged_in"] === true)) {
                $sidelist[] = "<a ".(($this->page == $val['id'] || $this->page == $val['country']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
            } elseif($val['id']=='off' && (!isset($_SESSION['users']["logged_in"]) || $_SESSION['users']["logged_in"] !== true)) {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
            } else {}
        } else {
            $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        }
    } else {
        $sidelist[] = "<button class='w3-btn w3-block w3-left-align w3-green accobtn'>$key<i class='fa fa-plus w3-right'></i></button>
        <div class='w3-hide accocontent'>";
        foreach($val as $subkey=>$subval) {
            $sidelist[] = "<a ".(($this->page == $subval['id']) ? "class='active'" : '')." href=".$subval['link'].">$subkey</a>";
        }
        $sidelist[] = "</div>";
    }
}
//show($sidelist);