<?php
$sidelistarr = side_list_top();
$pay_list = $en_pay_list = [
    'Bank/Mobile/ATM Transfers'=>['link'=>'./', 'id'=>'bank', 'country'=>'all'],
    'Mobile Money (CFA)'=>['link'=>'rave?id=xof', 'id'=>'ravecfa', 'country'=>['bf', 'bj', 'cg', 'ci', 'ml', 'ne', 'sn']],
    'Mobile Money (Ghana)'=>['link'=>'rave?id=ghs', 'id'=>'ravegh', 'country'=>'gh'],
    'MPESA (Kenya)'=>['link'=>'rave?id=kes', 'id'=>'raveke', 'country'=>'ke'],
    'Flutterwave'=>['link'=>'rave?id=ngn', 'id'=>'raveng', 'country'=>'ng'],
    'PayStack'=>['link'=>'paystack', 'id'=>'paystack', 'country'=>'ng'],
    'Mobile Money (Uganda)'=>['link'=>'rave?id=ugx', 'id'=>'raveug', 'country'=>'ug'],
    'Mobile Money (Rwanda)'=>['link'=>'rave?id=rwf', 'id'=>'raverw', 'country'=>'rw'],
    'Mobile Money (Malawi)'=>['link'=>'rave?id=mwk', 'id'=>'ravemw', 'country'=>'mw'],
    'Mobile Money (Tanzania)'=>['link'=>'rave?id=tzs', 'id'=>'ravetz', 'country'=>'tz'],
    'Mobile Money (Zambia)'=>['link'=>'rave?id=zmw', 'id'=>'ravezm', 'country'=>'zm'],
    'Mobile Money (DR Congo)'=>['link'=>'view_prices?id=cdf', 'id'=>'viewcdf', 'country'=>'cd'],
    'Mukuru (MWK)'=>['link'=>'mukuru?id=mwk', 'id'=>'viewmwk_muk', 'country'=>'mw'],
    //'Mukuru (ZAR)'=>['link'=>'mukuru?id=zar', 'id'=>'viewzar_muk', 'country'=>['ls', 'za']], put mukuru as ins on pages instead
    'Mukuru (ZMW)'=>['link'=>'mukuru?id=zmw', 'id'=>'viewzmw_muk', 'country'=>'zm'],
    'Mukuru'=>['link'=>'mukuru?id=usd', 'id'=>'viewusd_muk', 'country'=>['zw']],
    'Chipper Cash'=>['link'=>'chipper', 'id'=>'chippercash', 'country'=>['bf', 'bw', 'cd', 'cg', 'ci', 'et', 'gh', 'gw', 'lr', 'ml', 'mw', 'ne', 'rw', 'sn', 'sl', 'tz', 'ug', 'zm', 'zw']],
    'ZAR'=>['link'=>'rave?id=zar', 'id'=>'ravezar', 'country'=>['ls', 'za']],
    'USD'=>['link'=>'rave?id=usd', 'id'=>'raveusd', 'country'=>'all_ng'],
    'EUR'=>['link'=>'rave?id=eur', 'id'=>'raveeur', 'country'=>'all_ng'],
    'GBP'=>['link'=>'rave?id=gbp', 'id'=>'ravegbp', 'country'=>'all_ng'],
    'PayPal'=>['link'=>'paypal', 'id'=>'paypal', 'country'=>'all'],
    'Skrill / Neteller'=>['link'=>'skrill', 'id'=>'skrill', 'country'=>'all'],
    'SticPay'=>['link'=>'sticpay', 'id'=>'sticpay', 'country'=>'all'],
    'AstroPay'=>['link'=>'astropay', 'id'=>'astropay', 'country'=>'all_ng'],
    'Crypto'=>['link'=>'coinbase', 'id'=>'coinbase', 'country'=>'all']
    ];

if(LANG != 'en') {
    $ol_pay_list = [
        ['en'=>'Bank/Mobile/ATM Transfers', 'fr'=>'Transferts directs'],
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mobile Money (CFA)'),
        ['en'=>'Mobile Money (Ghana)', 'fr'=>'Mobile Money (Ghana)'],
        ['en'=>'MPESA (Kenya)', 'fr'=>'MPESA (Kenya)'],
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Flutterwave'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'PayStack'),
        ['en'=>'Mobile Money (Uganda)', 'fr'=>'Mobile Money (Ouganda)'],
        ['en'=>'Mobile Money (Rwanda)', 'fr'=>'Mobile Money (Rwanda)'],
        ['en'=>'Mobile Money (Malawi)', 'fr'=>'Mobile Money (Malawi)'],
        ['en'=>'Mobile Money (Tanzania)', 'fr'=>'Mobile Money (Tanzanie)'],
        ['en'=>'Mobile Money (Zambia)', 'fr'=>'Mobile Money (Zambie)'],
        ['en'=>'Mobile Money (DR Congo)', 'fr'=>'Mobile Money (RD Congo)'],
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mukuru (MWK)'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mukuru (ZAR)'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mukuru (ZMW)'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mukuru'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Chipper Cash'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'ZAR'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'USD'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'EUR'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'GBP'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'PayPal'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Skrill / Neteller'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'SticPay'),
        array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'AstroPay'),
        ['en'=>'Crypto', 'fr'=>'Crypto'],
        ];
    
    $pay_list = array_combine(array_column($ol_pay_list, LANG), array_values($en_pay_list));
}
$sidelistarr += $pay_list;
// show($sidelistarr);
$sidelist = [];
$country = strtolower(USER_COUNTRY);
foreach($sidelistarr as $key=>$val) {
    if($val['id']=='on' || $val['id']=='off') {
        if($val['id']=='on' && (isset($_SESSION['users']["logged_in"]) && $_SESSION['users']["logged_in"] === true)) {
            $sidelist[] = "<a ".(($this->page == $val['id'] || $this->page == $val['country']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        } elseif($val['id']=='off' && (!isset($_SESSION['users']["logged_in"]) || $_SESSION['users']["logged_in"] !== true)) {
            $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')." href='".$val['link']."'>$key</a>";
        } else {}
    } else {
        if(is_array($val['country'])) {
            if(in_array($country, $val['country'])) {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')."href=".$val['link'].">$key </a>";
            }
        } else {
            if($country == $val['country']) {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')."href=".$val['link'].">$key</a>";
            } elseif($val['country'] == 'all') {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')."href=".$val['link'].">$key</a>";
            } elseif($val['country'] == 'all_ng' && $country != 'ng') {
                $sidelist[] = "<a ".(($this->page == $val['id']) ? "class='active'" : '')."href=".$val['link'].">$key</a>";
            }
        }
    }
}
