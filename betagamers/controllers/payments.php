<?php
class Payments extends Controller {
    public $activepage='payments';
    public $viewonly;
    public $writeupclass;
    public $color = 'green';

    function __construct() {
        check_logged_in();
    }

    function index() { 
        $this->page = 'payments';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = 'Betagamers Subscription Payment Page. View the various payment options available.';
            $data['page_title'] = "Payment Page";
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site Web du betagamers, fr.betagamers.net';
            $this->description = 'Page de paiement de l\'abonnement Betagamers. Voir les différentes options de paiement disponibles.';
            $data['page_title'] = "Page de paiement";
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, es.betagamers.net';
            $data['page_title'] = "Página de pago";
            $this->description = 'Vea las diversas opciones de pago disponibles.';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, pt.betagamers.net';
            $data['page_title'] = "Página de pagamento";
            $this->description = 'Página de pagamento de assinatura do Betagamers. Veja as várias opções de pagamento disponíveis.';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, de.betagamers.net';
            $data['page_title'] = "Zahlungsseite";
            $this->description = 'Betagamers Zahlungsseite. Sehen Sie sich die verschiedenen verfügbaren Zahlungsoptionen an.';
        }
        //$data['banks'] = bank_details(['name'=>ACCTNAME, 'number'=>ACCTNUMBER, 'bank'=>BANK, 'swift'=>SWIFTCODE]);
        include ROOT."/app/betagamers/incs/menupay.php";
        $data['sidelist'] = $sidelist;
        $this->view("payments/index",$data);
    }

    private function instructions($platform) {
        if($platform=='Coinbase') {
            $tip = match(LANG) {
                'fr'=>'Nous acceptons actuellement:',
                'es'=>'Actualmente aceptamos:',
                'pt'=>'Atualmente aceitamos:',
                'de'=>'Wir akzeptieren derzeit:',
                default=>'We currently accept',
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
                break;
                case 'fr':
                    $p = [
                        "Vous pouvez cliquer sur l'un des plans pour payer en ligne. L'activation est automatique.",
                        'Pour payer manuellement:'
                    ];
                    $li = [
                        'Vous pouvez payer à '.LINKS,
                        "Envoyez votre (1) Nom complet (2) adresse email (3) Le montant payé (4) Plan d'abonnement",
                        'Par example: Charles Louis. louislucas@exemple.com. '.$this->plat3mths.'. 3 mois Platine.<br><br>',
                        "à ".PHONE." (sur whatsapp / telegram) OU envoyez-nous un e-mail via #ici#. L'activation peut prendre de 5 à 10 minutes."
                    ];
                break;
                case 'es':
                    $p = [
                        'Puede hacer clic en cualquiera de los planes para pagar en línea. La activación es automática.',
                        'Para pagar manualmente:'
                    ];
                    $li = [
                        'Puedes pagar a '.LINKS,
                        'Envíe (1) Su nombre completo (2) Su dirección de correo electrónico (3) Cantidad pagada (4) Plan de suscripción',
                        'Ejemplo: Diego Alejandro. diegoalejandro@ejemplo.com. '.$this->plat3mths.'. 3 meses Platino.<br><br>',
                        'al '.PHONE.' (en whatsapp / telegram) O envíenos un correo electrónico a través de #aquí#. La activación puede tardar entre 5 y 10 minutos.'
                    ];
                break;
                case 'pt':
                    $p = [
                        'Você pode clicar em qualquer um dos planos para pagar online. A ativação é automática.',
                        'Para pagar manualmente:'
                    ];
                    $li = [
                        'Você pode pagar para '.LINKS,
                        'Envie (1) Seu nome completo (2) Seu endereço de e-mail (3) Valor pago (4) Plano de assinatura',
                        'Exemplo: João Afonso. joaoafonso@exemplo.com. '.$this->plat3mths.'. 3mesesPlatina.<br><br>',
                        'para '.PHONE.' (no whatsapp / telegram) OU envie-nos um email por #aqui#. A ativação pode levar de 5 a 10 minutos.'
                    ];
                break;
                case 'de':
                    $p = [
                        'Sie können auf einen der Pläne klicken, um online zu bezahlen. Die Aktivierung erfolgt automatisch.',
                        'Um manuell zu bezahlen:'
                    ];
                    $li = [
                        'Sie können an '.LINKS.' bezahlen',
                        'Senden Sie Ihren (1) Ihren vollständigen Namen (2) Ihre E-Mail-Adresse (3) den bezahlten Betrag (4) den Abonnementplan',
                        'Beispiel: Karl Friedrich. karlfriedrich@beispiel.com. '.$this->plat3mths.'. 3monatPlatin.<br><br>',
                        'an '.PHONE.' (auf WhatsApp / Telegramm) ODER #Mailen Sie uns#. Die Aktivierung kann bis zu 5-10 Minuten dauern.'
                    ];
                break;
            }
            $links = [['href'=>support_links('mailus'),  'style'=>"color:green"]];
            return $ins = '<p>'.implode('</p><p>', $p)."</p><ul><li>".tag_format(implode('</li><li>', $li), $links)."</li></ul>";
        } else {
            if(LANG=='en') {
                $tip = 'You can also pay to:';
                $nb = [
                    'After payment, send your (1) Your Full Name (2) Your Email Address (3) Amount Paid (4) Subscription Plan',
                    'Example: Samuel Justin. samjoe@example.com. '.$this->plat3mths.'. 3monthsPlatinum.',
                    'to '.PHONE.' (on whatsapp / telegram) OR send us an email through #here#',
                    '*PLEASE NOTE*: The MPESA / Mobile Money number is for payments only, not calls. For all questions, ask '.PHONE.' on Whatsapp or Telegram.'
                ];
            } elseif(LANG=='fr') {
                $tip = 'Vous pouvez également payer à:';
                $nb = [
                    "Après paiement, envoyez votre (1) Nom complet (2) adresse email (3) Le montant payé (4) Plan d'abonnement",
                    'Par example: Charles Louis. louislucas@exemple.com. '.$this->plat3mths.'. 3 mois Platine.',
                    'à '.PHONE.' (sur whatsapp / telegram) OU envoyez-nous un e-mail via #ici#',
                    '*VEUILLEZ NOTER*: Le numéro MPESA / Mobile Money / Mukuru est réservé aux paiements, pas aux appels. Pour toutes questions, demandez le '.PHONE.' sur Whatsapp ou Telegram.'
                ];
            } elseif(LANG=='es') {
                $tip = 'También puede pagar a:';
                $nb = [
                    'Después del pago, envíe (1) Su nombre completo (2) Su dirección de correo electrónico (3) Cantidad pagada (4) Plan de suscripción',
                    'Ejemplo: Diego Alejandro. diegoalejandro@ejemplo.com. '.$this->plat3mths.'. 3 meses Platino.',
                    'al '.PHONE.' (en whatsapp / telegram) O envíenos un correo electrónico a través de #aquí#',
                    '*TENGA EN CUENTA*: El número de MPESA / Mobile Money / Mukuru es solo para pagos, no para llamadas. Para todas las preguntas, pregunte '.PHONE.' en Whatsapp o Telegram.'
                ];
            } elseif(LANG=='pt') {
                $tip = 'Você também pode pagar para:';
                $nb = [
                    'Após o pagamento, envie (1) Seu nome completo (2) Seu endereço de e-mail (3) Valor pago (4) Plano de assinatura',
                    'Exemplo: João Afonso. joaoafonso@exemplo.com. '.$this->plat3mths.'. 3mesesPlatina.',
                    'para '.PHONE.' (no whatsapp / telegram) OU envie-nos um email por #aqui#',
                    '*OBSERVE*: O número MPESA / Mobile Money / Mukuru é apenas para pagamentos, não para chamadas. Para todas as perguntas, pergunte '.PHONE.' no Whatsapp ou Telegram.'
                ];
            } elseif(LANG=='de') {
                $tip = 'Sie können auch an bezahlen:';
                $nb = [
                    'Senden Sie nach der Zahlung Ihren (1) Ihren vollständigen Namen (2) Ihre E-Mail-Adresse (3) den bezahlten Betrag (4) den Abonnementplan',
                    'Beispiel: Karl Friedrich. karlfriedrich@beispiel.com. '.$this->plat3mths.'. 3monatPlatin.',
                    'an '.PHONE.' (auf WhatsApp / Telegramm) ODER #mailen Sie uns#',
                    '*BITTE BEACHTEN SIE*: Die MPESA / Mobile Money / Mukuru-Nummer dient nur für Zahlungen, nicht für Anrufe. Bei Fragen kontaktieren Sie '.PHONE.' auf WhatsApp oder Telegram.'
                ];
            }
            $links = [['href'=>support_links('mailus'),  'style'=>"color:green"]];
            $nb = tag_format('<p>'.implode('</p><p>', $nb).'</p>', $links);
            
            
            include INCS."/banks.php";
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
        include ROOT."/app/betagamers/incs/menupay.php";
        $data['sidelist'] = $sidelist;
        $pdetails = currencies($currency ?? $_GET['id'] ?? USER_COUNTRY);
        $data['plan']['cur_sign'] = $pdetails['cur_sign'];
        $data['plan']['cur_lower'] = $pdetails['currency'];
        $data['plan']['cur_upper'] = $this->cur = strtoupper($pdetails['currency']);
        $plat = single_price('platinum', '3 Months', $data['plan']['cur_lower'], 'en');
        $this->plat3mths = $plat['price'].' '.$data['plan']['cur_upper'];
        $data['plan']['pre'] = $pre;
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = 'Make online '.$data['plan']['cur_upper']." payments with $platform";
            $data['page_title'] = "Pay with $platform";
            $h2 = "Payment Page";
            $data['table']['headers'] = $this->viewonly ? payment_table_headers(2) : payment_table_headers();
            $data['table']['action'] = 'Pay ';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site Web du betagamers, fr.betagamers.net';
            $this->description = 'Effectuez des paiements en ligne en '.$data['plan']['cur_upper']." avec $platform";
            $data['page_title'] = "Payer par $platform";
            $h2 = "Page de paiement";
            $data['table']['action'] = 'Payer ';
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net';
            $this->description = 'Realice pagos en línea en '.$data['plan']['cur_upper']." con $platform";
            $data['page_title'] = "Pagar con $platform";
            $h2 = "Página de pago";
            $data['table']['action'] = 'Paga ';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site betagamers, pt.betagamers.net';
            $this->description = 'Faça pagamentos online em '.$data['plan']['cur_upper']." com $platform";
            $data['page_title'] = "Pague com $platform";
            $h2 = "Página de pagamento";
            $data['table']['action'] = 'Pague ';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, Betagamers-Website, de.betagamers.net';
            $this->description = 'Führen Sie Online- '.$data['plan']['cur_upper']." -Zahlungen mit $platform durch";
            $data['page_title'] = "Zahlen Sie mit $platform";
            $h2 = "Zahlungsseite";
            $data['table']['action'] = 'Zahlen Sie ';
        }
        $data['h2'] = $platform=='Flutterwave' ? $h2 : $platform;
        $data['instructions'] = $this->instructions($platform);
        $data['table']['headers'] = $this->viewonly ? payment_table_headers(2) : payment_table_headers();
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
        $this->paymentpage('PayPal', 'pal', 'usd');
    }

    function coinbase() {
        $this->page = 'coinbase';
        $this->paymentpage('Coinbase', 'ccb', 'usd');
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
        } elseif(LANG=='fr') {
            $data['page_title'] = 'Recharger';
            $data['h1'] = 'Page de recharge';
            $method_err = 'Méthode non précisée';
            $cur_err = 'Devise non précisée';
            $data['input']['name']['placeholder'] = 'Nom';
            $data['input']['email']['placeholder'] = 'E-mail';
            $data['input']['amount']['placeholder'] = 'Montant';
        } elseif(LANG=='es') {
            $data['page_title'] = 'Recargar';
            $data['h1'] = 'Página de recarga';
            $method_err = 'Método no especificado';
            $cur_err = 'Moneda no especificada';
            $data['input']['name']['placeholder'] = 'Nombre';
            $data['input']['email']['placeholder'] = 'Correo electrónico';
            $data['input']['amount']['placeholder'] = 'Monto';
        } elseif(LANG=='pt') {
            $data['page_title'] = 'Recarga';
            $data['h1'] = 'Página de recarga';
            $method_err = 'Método não especificado';
            $cur_err = 'Moeda não especificada';
            $data['input']['name']['placeholder'] = 'Nome';
            $data['input']['email']['placeholder'] = 'E-mail';
            $data['input']['amount']['placeholder'] = 'Quantia';
        } elseif(LANG=='de') {
            $data['page_title'] = 'Aufladen';
            $data['h1'] = 'Aufladeseite';
            $method_err = 'Methode nicht angegeben';
            $cur_err = 'Währung nicht angegeben';
            $data['input']['name']['placeholder'] = 'Name';
            $data['input']['email']['placeholder'] = 'E-Mail';
            $data['input']['amount']['placeholder'] = 'Betrag';
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
        } elseif(LANG=='fr') {
            $method_err = "Quelque chose s'est mal passé. Veuillez nous contacter immédiatement.";
            $plan_err = "Impossible d'obtenir les détails de l'abonnement. Veuillez nous contacter immédiatement.";
            $url_err = "URL invalide.";
        } elseif(LANG=='es') {
            $method_err = 'Algo salió mal. Póngase en contacto con nosotros inmediatamente.';
            $plan_err = 'No se pueden obtener los detalles de la suscripción. Póngase en contacto con nosotros inmediatamente.';
            $url_err = 'URL invalida.';
        } elseif(LANG=='pt') {
            $method_err = 'Algo deu errado. Entre em contato conosco imediatamente.';
            $plan_err = 'Não foi possível obter os detalhes da assinatura. Entre em contato conosco imediatamente.';
            $url_err = 'URL inválida.';
        } elseif(LANG=='de') {
            $method_err = 'Etwas ist schief gelaufen. Bitte kontaktieren Sie uns umgehend.';
            $plan_err = 'Abonnementdetails können nicht abgerufen werden. Bitte kontaktieren Sie uns umgehend.';
            $url_err = 'ungültige URL.';
        }
        if(isset($_GET['planid']) && !empty($_GET['planid'])) {
            list($method, $currency, $planlink) = explode('_', $_GET['planid'], 3);
            // https://betagamers.net/payments/system?planid=flw_ugx_diamond_1_week
            // https://betagamers.net/payments/system?planid=flw_ugx_combo_pro
            // flw_usd_footballtennis_1_month
            list($plansec, $duration) = explode('_', $planlink, 2);
            if(str_starts_with($planlink, 'combo')) {
                $duration = ucwords(str_replace('_', ' ', $planlink));
            }
            $plan = single_price($plansec, ucwords(str_replace('_', ' ', $duration)), $currency, 'en');
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
            $profile = account_links('profile');
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
                  header("location: ".pay_links('success')."?planid=$planid");
                  exit;
                } else {
        //            echo 'failed';
                    header("location: ".pay_links('failed'));
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
                header("location: ".pay_links('success')."?planid=$planid");
            } elseif($response->data->status == 'failed') {
                header("location: ".pay_links('failed'));
            } else {
                header("location: ".pay_links('pending'));
            }
        }
        exit;
    }

    function statuscb () {
        $profile = account_links('profile');
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
            header("location: ".pay_links('success')."?planid=$planid");
            exit;
        } elseif($status['data']['payments'][0]['status']=='PENDING'){
            header("location: ".pay_links('pending'));
            exit;
        } elseif (empty($status['data']['payments'])) {
                if (isset($status['data']['timeline'][2]['status']) && $status['data']['timeline'][2]['status']=='UNRESOLVED') {
                    header("location: ".pay_links('pending'));
                    exit;
                } else {
                    header("location: ".pay_links('failed'));
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
        $links = [['href'=>account_links('profile'),  'style'=>"color:green"], ['href'=>support_links(),  'style'=>"color:green"]];
        $data['message'] = "<p>".tag_format($message, $links)."</p>";
        $this->view("payments/status",$data);
    }

    private function send_manually(array $data) {
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
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site Web du betagamers, www.betagamers.net';
            $this->description = 'Abonnez-vous à nos services en utilisant '. $data['method'];
            $data['page_title'] = "Payer par ".$data['method'];
            $data['p'] = $data['p'] ?? [
                'Tous les paiements par '.$data['method'].' à nous doivent être effectués à *'.$data['recipient'].'*',
                'Envoyez-nous une preuve de paiement sur WhatsApp / Telegram via '.PHONE.' OR #Cliquez ici# pour nous envoyer un email.'
            ];
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net';
            $this->description = 'Suscríbete a nuestros servicios usando '. $data['method'];
            $data['page_title'] = "Paga con ".$data['method'];
            $data['p'] = $data['p'] ?? [
                'Todos los pagos de '.$data['method'].' a nosotros deben hacerse a *'.$data['recipient'].'*',
                'Envíenos un comprobante de pago por whatsapp / telegram a través del '.PHONE.' O #Haga clic aquí# para enviarnos un correo electrónico.'
            ];
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site betagamers, www.betagamers.net';
            $this->description = 'Assine nossos serviços usando '. $data['method'];
            $data['page_title'] = "Pague com ".$data['method'];
            $data['p'] = $data['p'] ?? [
                'Todos os Pagamentos '.$data['method'].' para nós devem ser feitos para *'.$data['recipient'].'*',
                'Envie-nos um comprovativo de pagamento no whatsapp / telegram através do '.PHONE.' OU #Clique aqui# para nos enviar um e-mail.'
            ];
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, Betagamers-Website, www.betagamers.net';
            $this->description = 'Abonnieren Sie unsere Dienste mit '. $data['method'];
            $data['page_title'] = "Zahlen Sie mit ".$data['method'];
            $data['p'] = $data['p'] ?? [
                'Alle '.$data['method'].' Zahlungen an uns sollten an *'.$data['recipient'].'*',
                'Senden Sie uns einen Zahlungsnachweis per WhatsApp / Telegram über '.PHONE.' ODER #Klicken Sie hier# um uns eine E-Mail zu senden.'
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
            'fr'=>['#Cliquez ici# pour nous envoyer un e-mail ou nous envoyer un message via '.PHONE.' sur Whatsapp ou Telegram et nous vous répondrons avec l\'adresse e-mail du destinataire.'],
            'es'=>['#Haga clic aquí# para enviarnos un correo electrónico o envíenos un mensaje a través del '.PHONE.' en Whatsapp o Telegram y le responderemos con la dirección de correo electrónico del destinatario.'],
            'pt'=>['#Clique aqui# para nos enviar um e-mail ou uma mensagem pelo número '.PHONE.' do Whatsapp ou Telegram e responderemos com o endereço de e-mail do destinatário.'],
            'de'=>['#Klicken Sie hier#, um uns eine E-Mail zu senden, oder schicken Sie uns eine Nachricht über '.PHONE.' auf WhatsApp oder Telegram. Wir antworten Ihnen mit der E-Mail-Adresse des Empfängers.'],
            default=>['#Click here# to send us a mail or message us via '.PHONE.' on Whatsapp or Telegram and we\'ll reply you with the recipient email address.']
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
            'fr'=>['#Cliquez ici# pour nous envoyer un e-mail ou nous envoyer un message via '.PHONE.' sur Whatsapp ou Telegram et nous vous répondrons avec les détails du paiement.'],
            'es'=>['#Haga clic aquí# para enviarnos un correo electrónico o envíenos un mensaje a través del '.PHONE.' en Whatsapp o Telegram y le responderemos con los detalles del pago.'],
            'pt'=>['#Clique aqui# para nos enviar um e-mail ou mensagem via '.PHONE.' no Whatsapp ou Telegram e responderemos com os detalhes de pagamento.'],
            'de'=>['#Klicken Sie hier#, um uns eine E-Mail zu senden, oder schreiben Sie uns unter '.PHONE.' eine Nachricht über WhatsApp oder Telegram. Wir antworten Ihnen dann mit den Zahlungsdetails.'],
            default=>['#Click here# to send us a mail or message us via '.PHONE.' on Whatsapp or Telegram and we\'ll reply you with the payment details.'],
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
        $data['extra'] = match(LANG) {
            'fr'=>['Pas encore de compte Chipper Cash ? Vous pouvez #cliquer ici pour vous inscrire#'],
            'es'=>['¿Todavía no tienes una cuenta de Chipper Cash? Puede #hacer clic aquí para registrarse#'],
            'pt'=>['Ainda não tem conta Chipper Cash? Você pode #clicar aqui para se cadastrar#'],
            'de'=>['Noch kein Chipper Cash Konto? Sie können #hier klicken, um sich zu registrieren#'],
            default=>["Pas encore de compte Chipper Cash? Vous pouvez #cliquer ici pour vous inscrire#."]
        };
        $this->page = 'chippercash';
        $this->send_manually($data);
    }
}