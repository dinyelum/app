<?php
class Gateways {
    public function rave ($currency, $amount, $metaval) {
        if(LANG=='en') {
            $err_curl = 'Curl returned error: ';
            $err_api = 'API returned error: ';
        } elseif(LANG=='fr') {
            $err_curl = 'Curl a renvoyé une erreur: ';
            $err_api = "L'API a renvoyé une erreur: ";
        } elseif(LANG=='es') {
            $err_curl = 'Curl devolvió un error: ';
            $err_api = 'API devolvió un error: ';
        } elseif(LANG=='pt') {
            $err_curl = 'Curl retornou erro: ';
            $err_api = 'API retornou erro: ';
        } elseif(LANG=='de') {
            $err_curl = 'Curl hat einen Fehler zurückgegeben: ';
            $err_api = 'API hat einen Fehler zurückgegeben: ';
        } else {}

        $redirect_url = pay_links('statusrave');
        $name = $_SESSION['users']["fullname"];
        $email = $_SESSION['users']["email"];
        $phone = $_SESSION['users']["phone"];
        $txref = 'rave'.bin2hex(random_bytes(2)).str_replace(' ', '', $metaval).mt_rand();
        $authorisation = "Authorization: Bearer ".ENV['FLW_SECRET_KEY'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
            'tx_ref'=>$txref,
            'amount'=>$amount,
            'currency'=>strtoupper($currency),
            'redirect_url'=>$redirect_url,
            'customer'=>['email'=>$email, 'phonenumber'=>$phone, 'name'=>$name],
            'meta'=>['metavalue'=>$metaval]
          ]),
          CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            $authorisation,
            "cache-control: no-cache"
          ],
        ));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
          // there was an error contacting the rave API
          error_log('Error contacting the rave API. '.$err_curl . $err, 0);
          die($err_curl . $err);
        }
        
        $transaction = json_decode($response);
        
        if(!$transaction->data && !$transaction->data->link){
          // there was an error from the API
          error_log('Error from the rave API. '.$err_api . $transaction->message, 0);
          print_r($err_api . $transaction->message);
          exit;
        }
        
        //print_r($transaction->data->message);
        
        //echo 'ref is:'.$txref.'<br'.$transaction->data->link;
        
        header('Location: ' . $transaction->data->link);
        exit;
    }

    public function paystack($amount, $metaval) {
        $txref = 'pstk'.bin2hex(random_bytes(2)).str_replace(' ', '', $metaval).mt_rand();
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
        'email' => $_SESSION['users']["email"],
        'amount' => $amount*100,
        'callback_url' => "https://betagamers.net/payments/statuspsk",
        'metadata' => [
            'cart_id'=>$txref,
            "cancel_action" => "https://betagamers.net/payments/paystack",
            "custom_fields"=> [
                "planid"=>$metaval
                ]
            ]
        ];
        
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer ".ENV['PSK_SECRET_KEY'],
        "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
        $result = json_decode($result);
        //echo $result->data->authorization_url;
        header('Location: ' . $result->data->authorization_url);
        exit;
    }

    public function paypal ($amount, $metaval) {
        $txref = 'pal'.bin2hex(random_bytes(2)).str_replace(' ', '', $metaval).mt_rand();
        $planid = str_replace(' ', '_', $metaval);
        $email = $_SESSION['users']['email'];?>
        
        <body onload="document.forms['palform'].submit()">
        <form name="palform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="links@betagamers.net">
        <input type="hidden" name="item_name" value="<?php echo $metaval ?>">
        <input type="hidden" name="item_number" value="<?php echo $txref ?>">
        <input type="hidden" name="credits" value="1">
        <input type="hidden" name="custom" value="<?php echo $email ?>">
        <input type="hidden" name="amount" value="<?php echo $amount ?>">
        <!--<input type="hidden" name="cpp_header_image" value="https://betagamers.net/750by90logo.jpg">-->
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="handling" value="0">
        <input type="hidden" name="cancel_return" value="<?php echo pay_links('paypal') ?>">
        <input type="hidden" name="return" value="<?php echo pay_links('success')."?planid=$planid" ?>">
        </form>
        </body>
        <?php
    }

    public function coinbase($amount, $metaval) {
        $name = $_SESSION['users']["fullname"];
        $email = $_SESSION['users']["email"];
        $phone = $_SESSION['users']["phone"];
        $cancel = pay_links('coinbase');
        $redirect = pay_links('statuscb');
        
        switch(LANG) {
            case 'en':
                $description = 'Payment to Betagamers Services for '.$metaval.' Plan';
                $err_curl = 'Curl returned error: ';
                $err_api = 'API returned error: ';
            break;
            case 'fr':
                $description = 'Le paiement au Betagamers Services pour le plan '.$metaval;
                $err_curl = 'Curl a renvoyé une erreur: ';
                $err_api = "L'API a renvoyé une erreur: ";
            break;
            case 'es':
                $description = 'Pago a Betagamers Services por plan '.$metaval;
                $err_curl = 'Curl devolvió un error: ';
                $err_api = 'API devolvió un error: ';
            break;
            case 'pt':
                $description = 'Pagamento ao Betagamers Services para o plano '.$metaval;
                $err_curl = 'Curl devolvió un error: ';
                $err_api = 'API devolvió un error: ';
            break;
            case 'de':
                $description = 'Zahlung an Betagamers Services für '.$metaval.' Plan';
                $err_curl = 'Curl hat einen Fehler zurückgegeben: ';
                $err_api = 'API hat einen Fehler zurückgegeben: ';
            break;
            default:
                $description = $cancel = $redirect = $err_curl = $err_api = '';
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.commerce.coinbase.com/charges/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
            'name'=>$metaval,
            'description'=>$description,
            'local_price'=>['amount'=> $amount, 'currency'=> 'USD'],
            'pricing_type'=>'fixed_price',
            'metadata'=>[
                'customer_name'=> $name,
                'customer_email'=> $email,
                'customer_phone'=> $phone
                ],
            'redirect_url'=>$redirect,
            'cancel_url'=>$cancel
          ]),
          CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "X-CC-Api-Key: ".ENV['CCB_API_KEY'],
            "X-CC-Version: 2018-03-22",
            "cache-control: no-cache"
          ],
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        $getcode = json_decode($response,true);
        // $code = $getcode['data']['code'];
        $_SESSION['ccb']["code"] = $getcode['data']['code'];
        //exit ();
        
        if($err){
          // there was an error contacting the rave API
          die($err_curl . $err);
        }
        
        $transaction = json_decode($response);
        
        if(!$transaction->data && !$transaction->data->hosted_url){
          // there was an error from the API
          //you can also print 'error' and 'warning' to file. commerce.coinbase.com/docs/api/#errors
          print_r($err_api . $transaction->error->message);
          exit;
        }
        
        header('Location: ' . $transaction->data->hosted_url);
        exit;
    }
}