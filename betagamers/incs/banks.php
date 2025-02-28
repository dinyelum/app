<?php
$curbanks = ['zar'];
$banks = '';
if(isset($_GET['id']) && in_array(strtolower($_GET['id']), $curbanks)) {
    $currency = strtolower($_GET['id']);
    if($currency==='zar') {
        if(LANG=='en') {
            $forbankdep = 'For Bank Transfers';
            $atmdep = 'For ATM Deposits';
            $tillpoints = 'For Deposits at Till Points(Checkers, Shoprite, etc)';
        } elseif(LANG=='fr') {
            $forbankdep = 'Pour les virements bancaires';
            $atmdep = 'Pour les dépôts aux guichets automatiques';
            $tillpoints = 'Pour les dépôts aux points de caisse(Checkers, Shoprite, etc)';
        }
        $allbanks = [
            $forbankdep=>[
                'name'=>'Reuben Ezekiel Charuma',
                'number'=>'78601121693',
                'type'=>'Current',
                'bank'=>'SASFIN BANK, SOUTH AFRICA',
                'branchcode'=>'683000'
                ],
        
            $atmdep=>[
                'name'=>'Hello Paisa Pty Ltd',
                'number'=>'62508532141',
                'bank'=>'FNB, SOUTH AFRICA',
                'branchcode'=>'250655',
                'hellopaisaunique'=>'1142978601121693'
                ],
                
            $tillpoints=>[
                'hellopaisaunique'=>'1142978601121693'
                ]
            ];
        foreach($allbanks as $key=>$val) {
            $banks .= "<button class='w3-bar w3-left-align accobtn'>$key</button>
            <div class='w3-hide accocontent'><p>".implode('</p><p>', bank_details($val))."</p></div>";
        }
    }
}