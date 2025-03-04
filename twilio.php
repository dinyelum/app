<?php
//5 attempts, 10 minutes
require_once '/home/betaahfg/vendor/autoload.php';
use Twilio\Rest\Client;
class Twilio {
    private $sid = "ACfc2ca77813982121264132d416a661e1";
    private $token = "eee5ae8d8a83a93202ac24e250df6345";
    private $twilio;
    
    public function __construct() {
        $this->twilio = new Client($this->sid, $this->token);
    }
    
    public function verify_service() {
        $service = $this->twilio->verify->v2->services->create("Betagamers Services");
        return $service->sid;
    }
    
    public function send_otp($number) {
        try {
            $verification = $this->twilio->verify->v2->services("VA207e89bf83d24acf97fd34e74899e639")->verifications->create($number, "sms");
            return $verification->status;
        } catch (\Twilio\Exceptions\TwilioException $e) {
            error_log("OTP could not be sent. Twillio Error: \nCode: {$e->getCode()}.\nMessage: {$e->getMessage()}.\n", 3, ENV['TWILLIO_ERR_URL']);
            return false;
            //echo "Something went wrong.\nCode: {$e->getCode()}.\nMessage: {$e->getMessage()}.\n";
        }
    }
    
    public function verify_otp($number, $otp) {
        $verification_check = $this->twilio->verify->v2->services("VA207e89bf83d24acf97fd34e74899e639")->verificationChecks->create(["to" => $number, "code" => $otp]);
        return($verification_check->status);
    }
}

/*
try {
    $twilio
        ->messages
        ->create(
            $to,
            [
                'body' => "Here is my message to you!",
                'from' => $SMS_FROM,
            ]
        );
} catch (\Twilio\Exceptions\TwilioException $e) {
    echo "Something went wrong.\nCode: {$e->getCode()}.\nMessage: {$e->getMessage()}.\n";
}
*/


/*
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '/home/betaahfg/vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = "ACfc2ca77813982121264132d416a661e1";
$token = "eee5ae8d8a83a93202ac24e250df6345";
$twilio = new Client($sid, $token);

$service = $twilio->verify->v2->services
                              ->create("Betagamers Services");

print($service->sid);
*/
/*
// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once '/home/betaahfg/vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = "ACfc2ca77813982121264132d416a661e1";
$token = "eee5ae8d8a83a93202ac24e250df6345";
$twilio = new Client($sid, $token);

$verification = $twilio->verify->v2->services("VA207e89bf83d24acf97fd34e74899e639")
                                   ->verifications
                                   ->create("+2349112726323", "sms");

print($verification->status);
*/
/*
require_once '/home/betaahfg/vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = "ACfc2ca77813982121264132d416a661e1";
$token = "eee5ae8d8a83a93202ac24e250df6345";
$twilio = new Client($sid, $token);
$verification_check = $twilio->verify->v2->services("VA207e89bf83d24acf97fd34e74899e639")
                                         ->verificationChecks
                                         ->create([
                                                      "to" => "+2349112726323",
                                                      "code" => "881989"
                                                  ]
                                         );

print($verification_check->status);
*/