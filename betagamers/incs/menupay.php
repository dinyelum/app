<?php
$sidelistarr = side_list_top();
$pay_list = $en_pay_list = [
    'Bank/Mobile/ATM Transfers'=>['link'=>pay_links(), 'id'=>'bank', 'country'=>'all'],
    'Mobile Money (CFA)'=>['link'=>pay_links('rave?id=xof'), 'id'=>'ravexof', 'country'=>['bf', 'bj', 'cg', 'ci', 'ml', 'ne', 'sn']],//'id'=>'ravecfa'
    'Mobile Money (Ghana)'=>['link'=>pay_links('rave?id=ghs'), 'id'=>'raveghs', 'country'=>'gh'],
    'MPESA (Kenya)'=>['link'=>pay_links('rave?id=kes'), 'id'=>'ravekes', 'country'=>'ke'],
    'Flutterwave'=>['link'=>pay_links('rave?id=ngn'), 'id'=>'ravengn', 'country'=>'ng'],
    'PayStack'=>['link'=>pay_links('paystack'), 'id'=>'paystack', 'country'=>'ng'],
    'Mobile Money (Uganda)'=>['link'=>pay_links('rave?id=ugx'), 'id'=>'raveugx', 'country'=>'ug'],
    'Mobile Money (Rwanda)'=>['link'=>pay_links('rave?id=rwf'), 'id'=>'raverwf', 'country'=>'rw'],
    'Mobile Money (Malawi)'=>['link'=>pay_links('rave?id=mwk'), 'id'=>'ravemwk', 'country'=>'mw'],
    'Mobile Money (Tanzania)'=>['link'=>pay_links('rave?id=tzs'), 'id'=>'ravetzs', 'country'=>'tz'],
    'Mobile Money (Zambia)'=>['link'=>pay_links('rave?id=zmw'), 'id'=>'ravezmw', 'country'=>'zm'],
    'Mobile Money (DR Congo)'=>['link'=>pay_links('view_prices?id=cdf'), 'id'=>'viewcdf', 'country'=>'cdf'],
    'Mukuru (MWK)'=>['link'=>pay_links('mukuru?id=mwk'), 'id'=>'viewmwk_muk', 'country'=>'mw'],
    //'Mukuru (ZAR)'=>['link'=>pay_links('mukuru?id=zar'), 'id'=>'viewzar_muk', 'country'=>['ls', 'za']], put mukuru as ins on pages instead
    'Mukuru (ZMW)'=>['link'=>pay_links('mukuru?id=zmw'), 'id'=>'viewzmw_muk', 'country'=>'zm'],
    'Mukuru'=>['link'=>pay_links('mukuru?id=usd'), 'id'=>'viewusd_muk', 'country'=>['zw']],
    'Chipper Cash'=>['link'=>pay_links('chipper'), 'id'=>'chippercash', 'country'=>['bf', 'bw', 'cd', 'cg', 'ci', 'et', 'gh', 'gw', 'lr', 'ml', 'mw', 'ne', 'rw', 'sn', 'sl', 'tz', 'ug', 'zm', 'zw']],
    'ZAR'=>['link'=>pay_links('rave?id=zar'), 'id'=>'ravezar', 'country'=>['ls', 'za']],
    'USD'=>['link'=>pay_links('rave?id=usd'), 'id'=>'raveusd', 'country'=>'all_ng'],
    'EUR'=>['link'=>pay_links('rave?id=eur'), 'id'=>'raveeur', 'country'=>'all_ng'],
    'GBP'=>['link'=>pay_links('rave?id=gbp'), 'id'=>'ravegbp', 'country'=>'all_ng'],
    'PayPal'=>['link'=>pay_links('paypal'), 'id'=>'paypal', 'country'=>'all_ng'],
    'Skrill / Neteller'=>['link'=>pay_links('skrill'), 'id'=>'skrill', 'country'=>'all'],
    'SticPay'=>['link'=>pay_links('sticpay'), 'id'=>'sticpay', 'country'=>'all'],
    'AstroPay'=>['link'=>pay_links('astropay'), 'id'=>'astropay', 'country'=>'all_ng'],
    'Crypto'=>['link'=>pay_links('coinbase'), 'id'=>'coinbase', 'country'=>'all']
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
        // array_fill_keys(['en', 'fr', 'es', 'pt', 'de'], 'Mukuru (ZAR)'),
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
