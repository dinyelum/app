<?php
class Webhooks extends Processor {
    function webhookcb() {
        // Retrieve the request's body and parse it as JSON
        $input = @file_get_contents("php://input");
        $dec = json_decode(@file_get_contents("php://input"), true);

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_USER_AGENT', $_SERVER) || !array_key_exists('HTTP_X_CC_WEBHOOK_SIGNATURE', $_SERVER) ) {
            error_log("Error with Request or Key", 0);
            die();
        }

        $pretty = json_encode($dec, JSON_PRETTY_PRINT);
        file_put_contents(time().'_cb', $pretty);

        $agent = $_SERVER['HTTP_USER_AGENT'];
        $signature = $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'];
        $local_signature =  ENV['CCB_SECRET_KEY'];
        $mixed = hash_hmac('sha256', $input, $local_signature);

        if (($agent != 'weipay-webhooks') || ($signature != $mixed)) {
            error_log("Error with Webhook Values", 0);
            die ();
        }

        $ip =ip2long($_SERVER['HTTP_CF_CONNECTING_IP']);
        $lowip = ip2long("54.175.255.192");
        $highip = ip2long("54.175.255.223");

        if ($ip <= $highip && $lowip <= $ip) {
            
        } else {
            error_log("Error with IP Value: IP Value is ".$_SERVER['HTTP_CF_CONNECTING_IP'].". Check Coinbase API Docs (Webhooks) for any new ip range", 0);
        }

        $fullName= $dec['event']['data']['metadata']['customer_name'];
        $email= $dec['event']['data']['metadata']['customer_email'];
        $phone= $dec['event']['data']['metadata']['customer_phone'];
        $currency= $dec['event']['data']['pricing']['local']['currency'];
        $amount= $dec['event']['data']['pricing']['local']['amount'];
        $planid= $dec['event']['data']['name'];
        $txn_id= $dec['id'];
        $txn_ref = 'coin-'.$dec['event']['id'];

        if ($dec['event']['type']=='charge:confirmed') {
            $this->process_payments('Coinbase', $fullName, $email, $phone, $currency, $amount, $planid, $txn_id, $txn_ref);
        } else {
            error_log("Error: Event type is not charge:confirmed. It is ".$dec['event']['type'], 0); exit();
        }
    }
    
    function webhookcb_all() {
        //invoice webhooks https://webhook.site/#!/adbdef6b-6fde-469f-95fe-eaefe5ba1a9e/07ef3fa0-fb67-4a3b-94b6-293899405333/2

        // Retrieve the request's body and parse it as JSON
        $input = @file_get_contents("php://input");
        $dec = json_decode(@file_get_contents("php://input"), true);

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_USER_AGENT', $_SERVER) || !array_key_exists('HTTP_X_CC_WEBHOOK_SIGNATURE', $_SERVER) ) {
            die();
        }

        $agent = $_SERVER['HTTP_USER_AGENT'];
        $signature = $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'];
        $local_signature =  ENV['CCB_SECRET_KEY'];
        $mixed = hash_hmac('sha256', $input, $local_signature);

        if (($agent != 'weipay-webhooks') || ($signature != $mixed)) {
            die ();
        }

        $code = $dec['event']['data']['code'];
        $email = $dec['event']['data']['metadata']['customer_email'];
        $time = $dec['event']['created_at'];
        $plan = $dec['event']['data']['name'];

        $log = $email.', '.$code.', '.$plan.', '.$time."\n";


        file_put_contents("cb_filelog.txt", $log, FILE_APPEND);
    }
    
    function webhookpal() {
        // For test payments we want to enable the sandbox mode. If you want to put live
        // payments through then this setting needs changing to `false`.
        $enableSandbox = false;

        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

        // Include Functions
        //require 'palfunction.php';

        // Handle the PayPal response.
        $requestData = $_POST; // multipart/form-data
        if(empty($requestData)){
            $requestData = json_decode(file_get_contents('php://input'), true); // application/json
        }
        $pretty = json_encode(($requestData), JSON_PRETTY_PRINT);
        file_put_contents(time().'_pal', $pretty);

        // Assign posted variables to local data array.
        $data = [
            'item_name' => $_POST['item_name'],
            'item_number' => $_POST['item_number'],
            'payment_status' => $_POST['payment_status'],
            'payment_amount' => $_POST['mc_gross'],
            'payment_currency' => $_POST['mc_currency'],
            'txn_id' => $_POST['txn_id'],
            'receiver_email' => $_POST['receiver_email'],
            'payer_email' => $_POST['payer_email'],
            'payer_name' => $_POST['last_name'] . ' ' . $_POST['first_name'],
            'custom' => $_POST['custom'],
        ];

        // We need to verify the transaction comes from PayPal and check we've not
        // already processed the transaction before adding the payment to our
        // database.
        if ($this->verifyTransaction($_POST, $paypalUrl)) {
            if ($this->addPayment($data) !== false) {
                // Payment successfully added.
            }
        }
    }
    
    private function verifyTransaction($data, $url) {
            // global $paypalUrl;
        
            $req = 'cmd=_notify-validate';
            foreach ($data as $key => $value) {
                $value = urlencode(stripslashes($value));
                $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
                $req .= "&$key=$value";
            }
        
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
            $res = curl_exec($ch);
        
            if (!$res) {
                $errno = curl_errno($ch);
                $errstr = curl_error($ch);
                curl_close($ch);
                throw new Exception("cURL error: [$errno] $errstr");
            }
        
            $info = curl_getinfo($ch);
        
            // Check the http response
            $httpCode = $info['http_code'];
            if ($httpCode != 200) {
                throw new Exception("PayPal responded with http code $httpCode");
            }
        
            curl_close($ch);
        
            return $res === 'VERIFIED';
        }
        
    private function addPayment($data) {
        //    global $db;
        $fullName= $data['payer_name'];
        $email= $data['custom'];
        $phone= '';
        $currency= $data['payment_currency'];
        $amount= $data['payment_amount'];
        $planid= $data['item_name'];
        $txn_id= $data['txn_id'];
        $txn_ref= $data['item_number'];
        
        return $this->process_payments('PayPal', $fullName, $email, $phone, $currency, $amount, $planid, $txn_id, $txn_ref);
    }
    
    function webhookpsk() {
        // only a post with paystack signature header gets our attention
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) {
            error_log('No Psk Signature');
            exit();
        } 

        // Retrieve the request's body
        $input = @file_get_contents("php://input");

        // validate event do all at once to avoid timing attack
        if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, ENV['PSK_SECRET_KEY'])) {
            error_log('Keys ddnt match');
            exit();
        }

        http_response_code(200);

        // parse event (which is json string) as object
        // Do something - that will not take long - with $event
        $event = json_decode($input);
        file_put_contents(time().'_psk', json_encode($event, JSON_PRETTY_PRINT));
        $fullName = 'paystack_customer';
        $email = $event->data->customer->email;
        $phone = $event->data->customer->phone ?? '070';
        if($event->event == 'charge.success') {
            $currency = $event->data->currency;
            $amount = $event->data->amount / 100;
            $metaplan = $event->data->metadata->custom_fields->planid;
            $id = $event->data->id;
            $txn_ref = $event->data->reference;
            $this->process_payments('PayStack', $fullName, $email, $phone, $currency, $amount, $metaplan, $id, $txn_ref);
        } elseif($event->event == 'refund.processed' ) {
            $currency = $event->data->transaction->currency;
            $amount = $event->data->transaction->amount / 100;
            $metaplan = $event->data->transaction->metadata->custom_fields->planid;
            $id = $event->data->transaction->id;
            $txn_ref = $event->data->transaction->reference;
            $this->deactivate_sub('PayStack', $email, $currency, $amount, $metaplan, 'refund');
        } else {}
        exit();
    }
    
    function webhookrave() {
        // Retrieve the request's body
        $body = @file_get_contents("php://input");

        // retrieve the signature sent in the reques header's.
        $signature = (isset($_SERVER['HTTP_VERIF_HASH']) ? $_SERVER['HTTP_VERIF_HASH'] : '');

        if (!$signature) {
            // only a post with rave signature header gets our attention
            die();
        }
            
        /* It is a good idea to log all events received. Add code *
        * here to log the signature and body to db or file       */
        
        $pretty = json_encode(json_decode($body), JSON_PRETTY_PRINT);
        $content = [ 'body' => $pretty, 'signature' => $signature ];
        $prettier = json_decode(json_encode($content), JSON_PRETTY_PRINT);
        file_put_contents(time().'_flw', $prettier);
        $local_signature =  ENV['FLW_HASH'];
        // Store the same signature on your server as an env variable and check against what was sent in the headers
        //$local_signature = getenv('SECRET_HASH');

        // confirm the event's signature
        if( $signature !== $local_signature ){
            error_log("Error: Rave signature mismatch", 0);
        // silently forget this ever happened
        die();
        }

        http_response_code(200); // PHP 5.4 or greater
        // parse event (which is json string) as object
        // Give value to your customer but don't give any output
        // Remember that this is a call from rave's servers and 
        // Your customer is not seeing the response here at all

        $response = json_decode($body);
            # code...
            // TIP: you may still verify the transaction
                    // before giving value.
                    
        if ($response->status == 'successful') {
            
            $id = $response->id;
            $amount = $response->amount; //Correct Amount from Server
            $currency = $response->currency; //Correct Currency from Server
            $txn_ref = $response->txRef;

            $authorisation = "Authorization: Bearer ".ENV['FLW_SECRET_KEY'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$id."/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    $authorisation), 
                    ));

            $resp = curl_exec($curl);
            curl_close($curl);
            $jsonarray = json_decode ($resp,true);
            
            $paymentStatus = $jsonarray['data']['status'];
            $chargeRaw = $jsonarray['data']['processor_response'];
            $chargeResponsecode = strtolower($chargeRaw);
            $chargeAmount = $jsonarray['data']['amount'];
            $chargeCurrency = $jsonarray['data']['currency'];
            $metaplan = $jsonarray['data']['meta']['metavalue'];
            
            $response_codes = ["payment is successful", "transaction successful", "approved by financial institution", "successful", "success", "success", "approved or completed successfully", "approved", "request successfully processed", "request successful", "transaction successful.", "the service request is processed successfully."];

            if(in_array($chargeResponsecode, $response_codes) && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
            // transaction was successful...
                // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            //Give Value and return to Success page

                $fullName= $jsonarray['data']['customer']['name'];
                $email= $jsonarray['data']['customer']['email'];
                $phone= $jsonarray['data']['customer']['phone_number'];
                
                $this->process_payments('Rave', $fullName, $email, $phone, $currency, $amount, $metaplan, $id, $txn_ref);
                
                } else {
                    error_log("Error: Problem with chargeResponsecode, chargeAmount and chargeCurrency. Chargeresponse is: '$chargeResponsecode'", 0);
                    exit();
                }
            } else {
                error_log("Error: Response is not equal to successful, it is: ".$response->status, 0);
        }
        exit();
    }
}