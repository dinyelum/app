<?php
class Payments extends Controller {
    public $activepage='payments';
    public $btntxt = ['en'=>'MENU'];
    public $viewonly;
    public $writeupclass;
    public $color = 'green';

    function __construct() {
        check_logged_in();
    }

    function index() { 
        $this->page = 'payments';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers Login page, best ftball prediction website';
            $this->description = 'Betagamers Subscription Payment Page. View the various payment options available.';
            $data['page_title'] = "Payment Page";
        }
        //$data['banks'] = bank_details(['name'=>ACCTNAME, 'number'=>ACCTNUMBER, 'bank'=>BANK, 'swift'=>SWIFTCODE]);
        $data['btntxt'] = $this->btntxt[LANG];
        include ROOT."/app/betagamers/incs/menupay.php";
        $data['sidelist'] = $sidelist;
        $this->view("payments/index",$data);
    }

    private function instructions($platform) {
        if($platform=='Coinbase') {
            $tip = match(LANG) {
                'en'=>'We currently accept:',
                'fr'=>'',
                'es'=>'',
                'pt'=>'',
                'de'=>'',
                default=>''
            };
            $coins = [
                "Bitcoin (BTC)",
                "Bitcoin Cash (BCH)",
                "Dai (DAI)",
                "Dogecoin (DOGE)",
                "Ethereum (ETH)",
                "Litecoin (LTC)",
                "USD Coin (USDC)"
            ];
            return $ins = "<p>$tip</p><ul class='w3-ul w3-border-bottom w3-margin-bottom'><li>".implode('</li><li>', $coins)."</li></ul>";
        } elseif($platform=='PayPal') {
            switch(LANG) {
                case 'en':
                    $p = [
                        'You can click on any of the plans to pay online. Activation is automatic.',
                        'To pay manually:'
                    ];
                    $li = [
                        'You can pay to '.LINKS,
                        'Send your (1) Your Full Name (2) Your Email Address (3) Amount Paid (4) Subscription Plan',
                        'Example: Samuel Justin. samjoe@example.com. '.$this->plat3mths.'. 3monthsPlatinum.<br><br>',
                        'to '.PHONE.' (on whatsapp / telegram) OR send us an email through #here#. Activation may take up to 5-10 minutes.'
                    ];
            }
            $links = [['href'=>support_links('mailus'),  'style'=>"color:green"]];
            return $ins = '<p>'.implode('</p><p>', $p)."</p><ul><li>".tag_format(implode('</li><li>', $li), $links)."</li></ul>";
        } else {
            $tip = match(LANG) {
                'en'=>'You can also pay to:',
                'fr'=>'Vous pouvez également payer à:',
                'es'=>'También puede pagar a:',
                'pt'=>'Você também pode pagar para:',
                'de'=>'Sie können auch an bezahlen:',
                default=>''
            };
            $nb = [
                'After payment, send your (1) Your Full Name (2) Your Email Address (3) Amount Paid (4) Subscription Plan',
                'Example: Samuel Justin. samjoe@example.com. '.$this->plat3mths.'. 3monthsPlatinum.',
                'to '.PHONE.' (on whatsapp / telegram) OR send us an email through #here#',
                '*PLEASE NOTE*: The MPESA / Mobile Money number is for payments only, not calls. For all questions, ask '.PHONE.' on Whatsapp or Telegram.'
            ];
            $links = [['href'=>support_links('mailus'),  'style'=>"color:green"]];
            $nb = tag_format('<p>'.implode('</p><p>', $nb).'</p>', $links);
            
            
            include INCS."//banks.php";
            $country = substr($this->cur, 0, 2);
            if($country == 'XO') {
                $countries = ['BF', 'BJ', 'CI', 'CM', 'CG', 'GA', 'ML', 'NE', 'SN'];
                if(in_array(USER_COUNTRY, $countries)) {
                    $country = USER_COUNTRY;
                } else {
                    $country = 'CFA';
                }
            } elseif($country == 'US') {
                if($platform=='mukuru') {
                    $country = USER_COUNTRY=='ZA' || USER_COUNTRY=='ZW' ? USER_COUNTRY : 'ZA';
                }
            }
            $loop_name = $agent = '';
            $agentclass = new Agent;
            $get_agent = $agentclass->select()->where("countries LIKE CONCAT( '%',:countries,'%') AND level='agent' order by case when country='$country' then 0 else 1 end, country", ['countries'=>$country]);
            //show($get_agent);
            foreach($get_agent as $val) {
                if($loop_name != $val['name']) {
                    $agent .= '<br><b>'.$val['name'].'</b><br>';
                }
                //if(strtolower($country) == strtolower($val['country']))
                if(strtolower(USER_COUNTRY) == strtolower($val['country'])) {
                    $agent .= '<b>'.$val['phone'].'</b>, '.$val['network'].'<br>';
                } else {
                    if(str_starts_with($val['phone'], '0')) {
                        $phone = $val['intl'].ltrim($val['phone'], '0');
                    } else {
                        $phone = $val['intl'].$val['phone'];
                    }
                    $agent .= '<b>'.$phone.'</b>, '.$val['network'].'<br>';
                }
                $loop_name = $val['name'];
            }
            //$ins = trim($agent) ? "<p>$tip$agent</p>$nb" : '';
            return trim($banks) || trim($agent) ? "$tip$banks$agent$nb" : '';
        }
    }

    private function paymentpage($platform, $pre, $currency=null) {
        $_SESSION['payurl'] = URI;
        $data['tabs'] = sports();
        $data['btntxt'] = $this->btntxt[LANG];
        include ROOT."/app/betagamers/incs/menupay.php";
        $data['sidelist'] = $sidelist;
        $pdetails = currencies($currency ?? $_GET['id'] ?? USER_COUNTRY);
        $data['plan']['cur_sign'] = $pdetails['cur_sign'];
        $data['plan']['cur_lower'] = $pdetails['currency'];
        $data['plan']['cur_upper'] = $this->cur = strtoupper($pdetails['currency']);
        $plat = single_price('platinum', '3 Months', $data['plan']['cur_lower']);
        $this->plat3mths = $plat['price'].' '.$data['plan']['cur_upper'];
        $data['plan']['pre'] = $pre;
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = 'Make online '.$data['plan']['cur_upper']." payments with $platform";
            $data['page_title'] = "Pay with $platform";
            $h2 = "Payment Page";
            $data['table']['headers'] = $this->viewonly ? payment_table_headers(2) : payment_table_headers();
            $data['table']['action'] = 'Pay ';
        }
        $data['h2'] = $platform=='Flutterwave' ? $h2 : $platform;
        $data['instructions'] = $this->instructions($platform);
        $this->view("payments/pricingpage",$data);
    }

    function rave() {
        $this->page = 'rave'.($_GET['id'] ?? '');
        $this->paymentpage('Flutterwave', 'flw');
    }

    function mukuru() {
        $this->page = 'mukuru'.($_GET['id'] ?? 'usd');
        $this->viewonly = true;
        $this->paymentpage('mukuru', '');
    }

    function paystack() {
        $this->page = 'paystack';
        $this->paymentpage('PayStack', 'psk', 'ngn');
    }

    function paypal() {
        $this->page = 'paypal';
        $this->paymentpage('PayPal', 'pal');
    }

    function coinbase() {
        $this->page = 'coinbase';
        $this->paymentpage('Coinbase', 'ccb');
    }

    function view_prices() {
        $this->page = 'view'.($_GET['id'] ?? '');
        $this->viewonly = true;
        $this->paymentpage('', '');
    }

    function topup() {
        $_SESSION['payurl'] = URI;
        $name = $email = $currency = $meta = $error = '';
        //betagamers.net/topup.php?agent=ng_rave
        //betagamers.net/topup.php?client=ngn_rave
        if(LANG=='en') {
            $data['page_title'] = 'Top Up';
            $data['h1'] = 'Top Up Page';
            $method_err = 'Method not specified';
            $cur_err = 'Currency not specified';
            $data['input']['name']['placeholder'] = 'Name';
            $data['input']['email']['placeholder'] = 'E-mail';
            $data['input']['amount']['placeholder'] = 'Amount';
        }
        $this->style = 'h2 {text-align: center;}';
        $genclass = new General;
        if(isset($_GET['agent']) && $_GET['agent'] != '') {
            $meta = 'agentTopup';
            list($country, $method) = explode('_', $_GET['agent']);
            $country = $genclass->validate_alpha_iso($country);
            if($genclass->err) exit($genclass->err['country']);
            if(!isset($method)) exit($method_err);
            $agent = $genclass->get_by_country('agent', ['name', 'email', 'currency'], [$country]);
            if(is_array($agent) && count($agent) > 0) {
                $name = $agent[0]['name'];
                $email = $agent[0]['email'];
                $currency = strtoupper($agent[0]['currency']);
            }
        } elseif(isset($_GET['client']) && $_GET['client'] != '') {
            $meta = 'clientTopup';
            list($currency, $method) = explode('_', $_GET['client']);
            $currency = $currency ? strtoupper($currency) : exit($cur_err);
            if(!isset($method)) exit($method_err);
        } else {}

        $currency = ($currency=='CDF' || $currency=='USD') ? 'USD' : $currency;
        if(strlen($currency) !== 3) exit($genclass->resp_invalid('currency', LANG));
        $methods = get_class_methods(new Gateways);
        if(!in_array($method, $methods)) exit($genclass->resp_invalid('method', LANG));
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])) {
            $name = $genclass->validate_name($_POST['name']);
            $email = $genclass->validate_email($_POST['email'], unique:false);
            $amount = $genclass->validate_number($_POST['amount'], fieldname:'amount');

            if(!$genclass->err) {
                $_SESSION['users']['fullname'] = $name;
                $_SESSION['users']['email'] = $email;
                $_SESSION['users']['phone'] = isset($_SESSION['users']['phone']) ? $_SESSION['users']['phone'] : '';
                $start = new Processor;
                switch($method) {
                    case 'rave':
                        $start->rave($currency, $amount, $meta);
                    break;
                    case 'pal':
                        $start->paypal($email, $amount, $meta);
                    break;
                    default:
                }
            } else {
                $data['form']['err'] = $genclass->err;
            }
        }
        $data['form']['name'] = $name;
        $data['form']['email'] = $email;
        $data['form']['amount'] = $amount ?? '';
        $data['form']['currency'] = $currency;
        $this->view("payments/topup",$data);
    }

    function system() {
        if(LANG=='en') {
            $method_err = 'Something went wrong. Please contact us immediately.';
            $plan_err = 'Unable to get subscription details. Please contact us immediately.';
            $url_err = 'Invalid URL.';
        }
        if(isset($_GET['planid']) && !empty($_GET['planid'])) {
            list($method, $currency, $planlink) = explode('_', $_GET['planid'], 3);
            list($plansec, $duration) = explode('_', $planlink, 2);
            $plan = single_price($plansec, ucwords(str_replace('_', ' ', $duration)), $currency);
            // $amount = (float) (LANG=='en' ? str_replace(',', '', $plan['price']) : str_replace('.', '', $plandetails['price']));
            $amount = DISCOUNT ? $plan['plaindiscount'] : $plan['plainprice'];
            $gateways = ['flw', 'pal', 'str', 'ccb', 'psk'];
            if(in_array($method, $gateways)) {
                $gatewayclass = new Gateways;
                switch ($method) {
                    case 'flw':
                        $gatewayclass->rave($currency, $amount, $plan['description']);
                    break;
                    case 'pal':
                        $gatewayclass->paypal($amount, $plan['description']);
                    break;
                    case 'str':
                        $gatewayclass->stripe($amount, $plan['description']);
                    break;
                    case 'ccb':
                        $gatewayclass->coinbase($amount, $plan['description']);
                    break;
                    case 'psk':
                        $gatewayclass->paystack($amount, $plan['description']);
                    break;
                    default:
                        $pay_now = '';
                }
            } else {
                exit($method_err);
            }
        } else {
            exit($url_err);
        }
    }

    function statusrave() {
        $err_message = match(LANG) {
            'fr'=>'Aucune référence de transaction trouvée',
            'es'=>'No se encontró ninguna referencia de transacción',
            'pt'=>'Nenhuma referência de transação encontrada',
            'de'=>'Keine Transaktionsreferenz gefunden',
            default=>'No transaction reference found',
        };
        if (isset($_GET['status']) && $_GET['status']=='cancelled'){
            $profile = profile_links();
            $redirect = $_SESSION['payurl'] ?? $profile;
            header('location:'.$redirect);
    	    exit;
        } else {
            if (isset($_GET['tx_ref'])) {
                $ref = $_GET['tx_ref'];
                $query = array(
                    "SECKEY" => ENV['FLW_SECRET_KEY'],
                    "txref" => $ref
                );
        
                $data_string = json_encode($query);
                $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');              
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
                $response = curl_exec($ch);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($response, 0, $header_size);
                $body = substr($response, $header_size);
        
                curl_close($ch);
        
                $resp = json_decode($response, true);
                
                $paymentStatus = $resp['data']['status'];
                $chargeResponsecode = $resp['data']['chargecode'];
                $planid = str_replace(' ', '_', $resp['data']['meta'][1]['metavalue']);
        
                if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($paymentStatus == "successful")) {
        //            echo 'success';
                  header("location: success?planid=$planid");
                  exit;
                } else {
        //            echo 'failed';
                    header("location: failed");
                    exit;
                }
            }
                else {
              die($err_message);
            }
        }
    }

    function statuspsk () {
        if (!isset($_GET['reference']) || trim($_GET['reference'])=='') {
            exit('Transaction reference not found');
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$_GET['reference'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer ".ENV['PSK_SECRET_KEY'],
          "Cache-Control: no-cache",
        ),
        ));
        
        $response = curl_exec($curl);
        $response = json_decode($response); //comment out before uncommenting the following 3 lines
        //header('Content-Type: application/json');
        //$response = json_encode(json_decode($response), JSON_PRETTY_PRINT);
        //echo "<pre>$response</pre>"; exit;
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $planid = str_replace(' ', '_', $response->data->metadata->custom_fields->planid);
            if($response->data->status == 'success') {
                header("location: success?planid=$planid");
            } elseif($response->data->status == 'failed') {
                header("location: failed");
            } else {
                header("location: pending");
            }
        }
        exit;
    }

    function statuscb () {
        $profile = profile_links();
        switch(LANG) {
            case 'en':
                $err_curl = 'Curl returned error: ';
                $err_api = 'API returned error: ';
            break;
            case 'fr':
                $err_curl = 'Curl a renvoyé une erreur: ';
                $err_api = "L'API a renvoyé une erreur: ";
            break;
            case 'es':
                $err_curl = 'Curl devolvió un error: ';
                $err_api = 'API devolvió un error: ';
            break;
            case 'pt':
                $err_curl = 'Curl retornou erro: ';
                $err_api = 'API retornou erro: ';
            break;
            case 'de':
                $err_curl = 'Curl hat einen Fehler zurückgegeben: ';
                $err_api = 'API hat einen Fehler zurückgegeben: ';
            break;
            default:
                $err_curl = $err_api = '';
        }
        
        //$code = 'NR7T82GB';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.commerce.coinbase.com/charges/".$_SESSION['ccb']["code"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "X-CC-Api-Key: ".ENV['CCB_API_KEY'],
            "X-CC-Version: 2018-03-22",
            "cache-control: no-cache"
            ],
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
            // there was an error contacting the rave API
            die($err_curl . $err);
        }
        
        $status = json_decode($response,true);
        $planid = str_replace(' ', '_', $status['data']['name']);
        
        if(!$status['data']){
            // there was an error from the API
            print_r($err_api . $status['error']['message']);
        }
        
        if($status['data']['payments'][0]['status']=='CONFIRMED'){
            header("Location: success?planid=$planid");
            exit;
        } elseif($status['data']['payments'][0]['status']=='PENDING'){
            header('Location: pending');
            exit;
        } elseif (empty($status['data']['payments'])) {
                if (isset($status['data']['timeline'][2]['status']) && $status['data']['timeline'][2]['status']=='UNRESOLVED') {
                    header('Location: pending');
                    exit;
                } else {
                    header('Location: failed');
                    exit;
                }
        } else {
            header("Location: $profile");
            exit;
        }
    }

    function success() {
        $en = ['Diamond', 'Platinum', 'Ultimate', 'Year', 'Months', 'Month', 'Week', 'Days', 'Football', 'Tennis', 'Silver', 'Gold'];
        $message = "Your Payment was Successful.";
        $thankyou = 'Thank You for Subscribing.';
        $message_extra = isset($_SESSION["ce_ref"]) ? 'The transaction reference is '.$_SESSION["ce_ref"] : '';
        $data['page_title'] = 'Successful Transaction';
        $this->description = 'Best football predictions and tips site worldwide';
        
        if(LANG != 'en') {
            switch(LANG) {
                case 'fr':
                    $data['page_title'] = 'Transaction réussie';
                    $this->description = 'Meilleur site de prédiction de football au monde';
                    $replace = ['Diamant', 'Platine', 'Ultime', 'An', 'Mois', 'Mois', 'Semaine', 'Jours', 'Football', 'Tennis', 'Argent', 'Or'];
                    $message = 'Votre paiement a réussi.';
                    $thankyou = 'Merci de vous être abonné.';
                    $message_extra = isset($_SESSION["ce_ref"]) ? 'La référence de la transaction est '.$_SESSION["ce_ref"] : '';
                break;
                case 'es':
                    $data['page_title'] = 'Transacción exitosa';
                    $this->description = 'El mejor sitio de predicción de fútbol del mundo';
                    $replace = ['Diamante', 'Platino', 'Ultimate', 'Año', 'Meses', 'Mes', 'Semana', 'Días', 'Fútbol', 'Tenis', 'Plata', 'Oro'];
                    $message = 'Su pago fue exitoso.';
                    $thankyou = 'Gracias por suscribirse.';
                    $message_extra = isset($_SESSION["ce_ref"]) ? 'La referencia de la transacción es '.$_SESSION["ce_ref"] : '';
                break;
                case 'pt':
                    $data['page_title'] = 'Transação bem-sucedida';
                    $this->description = 'Melhor site de prognósticos de futebol do mundo';
                    $replace = ['Diamante', 'Platina', 'Ultimate', 'Ano', 'Meses', 'Mês', 'Semana', 'Dias', 'Futebol', 'Tênis', 'Prata', 'Ouro'];
                    $message = 'Seu pagamento foi aprovado.';
                    $thankyou = 'Obrigado por se inscrever.';
                    $message_extra = isset($_SESSION["ce_ref"]) ? 'A referência da transação é '.$_SESSION["ce_ref"] : '';
                break;
                case 'de':
                    $data['page_title'] = 'Erfolgreiche Transaktion';
                    $this->description = 'Betagamers Erfolgreiche Transaktion';
                    $replace = ['Diamant', 'Platin', 'Ultimate', 'Jahr', 'Monate', 'Monat', 'Woche', 'Tage', 'Fußball', 'Tennis', 'Silber', 'Gold'];
                    $message = 'Ihre Zahlung war erfolgreich.';
                    $thankyou = 'Danke fürs Abonnieren.';
                    $message_extra = isset($_SESSION["ce_ref"]) ? 'Die Transaktionsreferenz ist '.$_SESSION["ce_ref"] : '';
                break;
                default:
                    $replace = [];
                    $data['page_title'] = $this->description = $message = '';
            }
        }
        if(isset($_GET['planid']) && str_contains($_GET['planid'], '_')) {
            $planid = str_replace('_', ' ', $_GET['planid']);
            $plan = explode(' ', $planid);
            if($plan[0] == 'Combo') {
                $plan = 'Ultimate / Platinum / Diamond';
            } elseif($plan[0] == 'Platinum' || $plan[0] == 'Football') {
                $plan = 'Platinum / Diamond';
            } else {
                $plan = $plan[0];
            }
            
            if(LANG != 'en') {
                $plan = str_ireplace($en, $replace, $plan);
                $planid = str_ireplace($en, $replace, $planid);
            }
            
            switch(LANG) {
                case 'en':
                    $guide = ['Just Click on VIP Tips', 'Click on MENU', 'Click on '.$plan];
                    $message = "Your Payment for $planid was Successful.";
                break;
                case 'fr':
                    $guide = ['Cliquez simplement sur Pronos VIP', 'Cliquez sur MENÜ', 'Cliquez sur '.$plan];
                    $message = "Votre paiement pour $planid a été effectué avec succès.";
                break;
                case 'es':
                    $guide = ['Simplemente haga clic en VIP', 'Haga clic en MENÚ', 'Haga clic en '.$plan];
                    $message = "Su pago por $planid fue exitoso.";
                break;
                case 'pt':
                    $guide = ['Basta clicar em VIP', 'Clique em MENÚ', 'Clique em '.$plan];
                    $message = "Seu pagamento por $planid foi realizado com sucesso.";
                break;
                case 'de':
                    $guide = ['Klicken Sie einfach auf VIP', 'Klicken Sie auf MENÜ', 'Klicken Sie auf '.$plan];
                    $message = "Ihre Zahlung für $planid war erfolgreich.";
                break;
                default:
                    $guide = [];
                    $message = '';
            }
        } else {
            $message = $message;
        }
        $pstyle = isset($guide) ? "style='text-align: left'" : '';
        $data['message'] = "<p $pstyle>$message</p>".(isset($guide) ? "<ul class='w3-ul' style='text-align: left'><li>".implode('</li><li>', $guide)."</li></ul><br>" : "")."<p $pstyle>$thankyou</p><p $pstyle>$message_extra</p>";
        $this->view("payments/status",$data);
    }

    function failed() {
        switch(LANG){
            case 'en':
                $data['page_title'] = 'Failed Transaction';
                $message = "Ooops! Something went Wrong. Please #Try Again# OR #Contact Us#. Thank You.";
            break;

            case 'fr':
                $data['page_title'] = 'Échec de la transaction';
                $message = "Oops! Quelque chose a mal tourné. Veuillez #réessayer# OU #nous contacter#. Merci.";
            break;
            case 'es':
                $data['page_title'] = 'Transacción fallida';
                $message = "¡Ups! Algo salió mal. Vuelva #a intentarlo# O #póngase en contacto con nosotros#. Gracias.";
            break;
            case 'pt':
                $data['page_title'] = 'Transação com falha';
                $message = "Ops! Algo deu errado. Por favor, #tente novamente# OU #entre em contato conosco#. Obrigado.";
            break;
            case 'de':
                $data['page_title'] = 'Fehlgeschlagene Transaktion';
                $message = "Hoppla! Etwas ist schief gelaufen. Bitte #versuchen Sie es erneut# oder #kontaktieren Sie uns#. Danke schön.";
            break;
            default:
                $data['page_title'] = $pay_link = $supp_link = '';
        }
        $pay_link = isset($_SESSION["payurl"]) && !empty($_SESSION["payurl"]) ? $_SESSION["payurl"] : pay_links();
        $links = [['href'=>$pay_link,  'style'=>"color:green"], ['href'=>support_links(),  'style'=>"color:green"]];
        $data['message'] = "<p>".tag_format($message, $links)."</p>";
        $this->view("payments/status",$data);
    }

    function pending() {
        switch(LANG){
            case 'en':
                $data['page_title'] = 'Pending Transaction';
                $this->description = 'Best football predictions and tips site worldwide';
                $message = 'Your transaction is pending. You can check your #profile# to see if your accounnt is active. Or #Contact Us# if your account is still inactive after 1 hour. Thank you.';
            break;
            case 'fr':
                $data['page_title'] = 'Transaction en attente';
                $this->description = 'Meilleur site de prédiction de football au monde';
                $message = 'Votre transaction est en attente. Vous pouvez vérifier #votre profil# pour voir si votre compte a été activé. OU #Contactez-nous# si votre compte reste inactif après 1 heure. Merci!';
            break;
            case 'es':
                $data['page_title'] = 'Transacción pendiente';
                $this->description = 'El mejor sitio de predicción de fútbol del mundo';
                $message = 'Su transacción aún está Pendiente. Puedes consultar #su perfil# para saber cuándo se ha activado su cuenta. O #Contáctenos# si su cuenta sigue inactiva después de 1 hora. Gracias.';
            break;
            case 'pt':
                $data['page_title'] = 'Transação pendente';
                $this->description = 'Transação pendente';
                $message = 'Sua transação ainda está pendente. Você pode verificar #seu perfil# para saber quando sua conta foi ativada. OU #Entre em contato conosco# se sua conta ainda estiver inativa após 1 hora. Obrigado.';
            break;
            case 'de':
                $data['page_title'] = 'Ausstehender Vorgang';
                $this->description = 'Betagamers Ausstehender Vorgang';
                $message = 'Ihre Transaktion steht noch aus. Sie können #Ihr Profil# überprüfen, um zu erfahren, wann Ihr Konto aktiviert wurde. ODER #Kontaktieren Sie uns# wenn Ihr Konto nach 1 Stunde immer noch inaktiv ist. Danke.';
            break;
            default:
                $data['page_title'] = $this->description = $message = '';
        }
        $links = [['href'=>profile_links(),  'style'=>"color:green"], ['href'=>support_links(),  'style'=>"color:green"]];
        $data['message'] = "<p>".tag_format($message, $links)."</p>";
        $this->view("payments/status",$data);
    }

    private function send_manually(array $data) {
        $data['btntxt'] = $this->btntxt[LANG];
        include ROOT."/app/betagamers/incs/menupay.php";
        $data['sidelist'] = $sidelist;
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = 'Subscribe to our services using '. $data['method'];
            $data['page_title'] = "Pay with ".$data['method'];
            $data['p'] = $data['p'] ?? [
                'All '.$data['method'].' Payments to us should be made to *'.$data['recipient'].'*',
                'Send us a proof of payment on whatsapp / telegram via '.PHONE.' OR #Click here# to send us an email.'
            ];
        }
        $this->style = "b {color:".$this->color."}";
        $links = [['href'=>support_links('mailus'),  'style'=>"color:green"]];
        if(isset($data['extra'])) {
            array_push($data['p'], ...$data['extra']);
            $links = [
                ['href'=>support_links('mailus'), 'style'=>'color:green'], 
                ['href'=>'https://chipper.cash/invite/Q5LY4', 'target'=>'_blank', 'style'=>'color:green']
            ];
        }
        $data['p'] = tag_format('<p>'.implode('</p><p>', $data['p']).'</p>', $links);
        $this->view("payments/send_manually",$data);
    }

    function skrill() {
        $data['method'] = 'Skrill / Neteller';
        $data['recipient'] = PAYMENTS;
        $data['image'] = [
            'url'=>HOME.'/assets/images/skrill_neteller.webp',
            'alt'=>'Skrill_Neteller',
            'width'=>500,
            'height'=>89
        ];
        $this->page = 'skrill';
        $this->color = 'purple';
        $this->send_manually($data);
    }

    function sticpay() {
        $data['method'] = 'SticPay';
        //$data['recipient'] = PAYMENTS;
        $data['image'] = [
            'url'=>HOME.'/assets/images/sticpay.webp',
            'alt'=>'SticPay Logo',
            'width'=>500,
            'height'=>244
        ];
        $data['p'] = match(LANG) {
            'fr'=>'',
            default=>['#Click here# to send us a mail or message us via '.PHONE.' on Whatsapp or Telegram and we\'ll reply you with thhe recipient email address.']
        };
        $this->page = 'sticpay';
        $this->color = '#f15922';
        $this->send_manually($data);
    }

    function astropay() {
        $data['method'] = 'AstroPay';
        //$data['recipient'] = PAYMENTS;
        $data['image'] = [
            'url'=>HOME.'/astropay.jpg',
            'alt'=>'AstroPay Logo',
            'width'=>600,
            'height'=>400
        ];
        $data['p'] = match(LANG) {
            'fr'=>'',
            default=>['#Click here# to send us a mail or message us via '.PHONE.' on Whatsapp or Telegram and we\'ll reply you with the payment details.']
        };
        $this->page = 'astropay';
        //$this->color = '#f15922';
        $this->send_manually($data);
    }

    function chippercash() {
        $data['method'] = 'Chipper Cash';
        $data['recipient'] = '@betagamers';
        $data['image'] = [
            'url'=>HOME.'/assets/images/chipper.webp',
            'alt'=>'Chipper Cash Logo',
            'width'=>512,
            'height'=>250
        ];
        $data['extra'] = ["No Chipper Cash account yet? You can #click here to register#."];
        $this->page = 'chippercash';
        $this->send_manually($data);
    }
}