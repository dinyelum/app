<?php

Class Account extends Controller 
{
    public $activepage = 'login';
    public $authmode;
    public $maxauth;
    //public $err;

    // function __construct($lang) {
    //     $this->lang = $lang;
    //     $this->country = $_SESSION['country'] ?? $_SERVER['HTTP_CF_IPCOUNTRY'] ?? '';
    // }

    // function __call($function, $params=[]) {
    //     // exit('here');
    //     if(LANG!='en') {
    //         $allmethods = directory_listing('account');
    //         if($method = array_search($function, array_column($allmethods, LANG, 'en'))) {
    //             return $this->$method();
    //         }
    //     }
    //     //include err 404 page
    //     exit('method, does not exist'); //err 404 page
    // }

    function index() {
        header('location:'.account_links('login'));
        exit;
    }

    function logout() {
        unset($_SESSION['users']);
        unset($_SESSION['redirectURL']);
        unset($_SESSION['newuser']);
        header("location: ".HOME);
        exit;
    }

    function login() {
        $hash = set_signature();
        $signature = bin2hex(random_bytes(4)).'_'.$hash;
        // show($_SESSION);
        // unset($_SESSION['users']);
        // show($_SERVER);
        $this->page = 'login';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers Login page, best ftball prediction website';
            $this->description = 'Sign in to Betagamers today and explore the world of opportunities waiting for you.';
            $data['page_title'] = $data['h1'] = "Login";
            $data['tab'] = ['With Email', 'With Phone'];
            $fieldnames['email'] = ['E-mail', 'Password', 'Show Password', '', ''];
            $fieldnames['fullphone'] = ['Phone Number', 'Password', 'Show Password', '', ''];
            $logintxt = $data['input']['submit']['fieldname'] = "Login";
            $prompts = ['Not yet a member? Register', 'Forgot Password?'];
            $phoneins = "Select your country's code. Then, type your normal number eg: 07062345988";
        } elseif(LANG=='fr') {
            $this->keywords = "Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football au monde";
            $this->description = "Connectez-vous avec Betagamers aujourd'hui et explorez les opportunités à venir.";
            $data['page_title'] = 'Connexion des Betagamers';
            $data['h1'] = $logintxt = $data['input']['submit']['fieldname'] = "Se Connecter";
            $data['tab'] = ['Avec e-mail', 'Avec téléphone'];
            $fieldnames['email'] = ['E-mail', 'Mot de passe', 'Montrer le Mot de Passe', '', ''];
            $fieldnames['fullphone'] = ['Numéro de téléphone (nombre normal)', 'Mot de passe', 'Montrer le Mot de Passe', '', ''];
            $prompts = ["Pas encore membre? S'inscrire", 'Mot de Passe Oublié?'];
            $phoneins = "Sélectionnez le code de votre pays. Tapez ensuite votre nombre normal, par exemple: 07062345988";
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, el login de betagamers';
            $this->description = 'Inicia sesión en Betagamers hoy.';
            $data['page_title'] = $data['h1'] = "Login";
            $data['tab'] = ['Con correo', 'Con teléfono'];
            $fieldnames['email'] = ['Correo electrónico', 'Contraseña', 'Mostrar contraseña', '', ''];
            $fieldnames['fullphone'] = ['Número de teléfono', 'Contraseña', 'Mostrar contraseña', '', ''];
            $logintxt = $data['input']['submit']['fieldname'] = "Login";
            $prompts = ['¿Todavía no eres miembro? Registrarse', '¿Has olvidado tu contraseña?'];
            $phoneins = "Selecciona el código de tu país, luego escriba su número normal p.eg: 07062345988";
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = 'Faça login no Betagamers hoje.';
            $data['page_title'] = $data['h1'] = "Entrar";
            $data['tab'] = ['Com E-mail', 'Com número'];
            $fieldnames['email'] = ['E-mail', 'Senha', 'Mostrar senha', '', ''];
            $fieldnames['fullphone'] = ['Telefone', 'Senha', 'Mostrar senha', '', ''];
            $logintxt = $data['input']['submit']['fieldname'] = 'Conecte-se';
            $prompts = ['Ainda não é um membro? Registro', 'Esqueceu sua senha?'];
            $phoneins = "Selecione o código do seu país. Em seguida, digite seu número normal, por exemplo: 07062345988";
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net';
            $this->description = 'Melden Sie sich noch heute bei Betagamers an.';
            $data['page_title'] = $data['h1'] = "Einloggen";
            $data['tab'] = ['Mit E-Mail', 'Mit Telefon'];
            $fieldnames['email'] = ['E-mail', 'Passwort', 'Passwort anzeigen', '', ''];
            $fieldnames['fullphone'] = ['Telefon', 'Passwort', 'Passwort anzeigen', '', ''];
            $logintxt = $data['input']['submit']['fieldname'] = 'Einloggen';
            $prompts = ['Noch kein Mitglied? Registrieren', 'Passwort vergessen?'];
            $phoneins = "Wählen Sie Ihre Landesvorwahl aus und geben Sie dann Ihre normale Nummer ein. zB: 07062345988";
        }
        $fieldnames['fullphone'][0] = 
        "<span class='w3-tooltip'><span style='position:absolute;left:0;bottom:18px' class='w3-text w3-tag w3-round-xlarge'>$phoneins
        </span>".$fieldnames['fullphone'][0]." <i class='fa fa-question-circle' style='font-size:15px; color:green'></i></span>";

        if(USER_LOGGED_IN === true){
            // exit('yeap');
            //full auth url to correct account/ redirecting to home controller/auth
            header("Location: ".account_links('auth'));
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            // show($_POST);
            check_signature('login', $hash);
            $genclass = new General;
            $_SESSION['users']['loginattempts'] = $_SESSION['users']['loginattempts'] ?? 0;
            //mild brute force mitigation, expires after 20mins when sessions expire. You can check user in db / store user (email / better still unique device info) in db and extend the time the user can wait before retrying.
            if($_SESSION['users']['loginattempts'] >= 5) {
                $data['logincount'] = $genclass->resp_max_attempts().'<br><br>';
            } else {
                $login = $genclass->login($_POST, 'users', ['id', 'fullname', 'email', 'country', 'phone', 'fullphone', 'active', 'regotpcount']);
                if($login === true) {
                    header("location: auth");
                    exit();
                } else {
                    $_SESSION['users']['loginattempts'] = $_SESSION['users']['loginattempts'] + 1;
                    $attemptsremaining = 5-$_SESSION['users']['loginattempts'];
                    $data['logincount'] = (!$attemptsremaining ? $genclass->resp_max_attempts() : $genclass->resp_attempts_remaining($attemptsremaining))."<br><br>";
                    $data['login'] = $login[1];
                }
            }
        }
        $formfields = [
            'email'=>[
                ['tag'=>'input', 'type'=>'email', 'name'=>"email", 'value'=>$login[0]['email'] ?? '', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'password', 'name'=>"password", 'value'=>'', 'class'=>'password', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'checkbox', 'name'=>'', 'class'=>'ptoggler'],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature, 'error'=>''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$logintxt, 'error'=>''],
            ],
            'fullphone'=>[
                ['tag'=>'input', 'id'=>"fullphone", 'type'=>'tel', 'placeholder'=>'7062345988', 'name'=>"fullphone", 'value'=>$login[0]['fullphone'] ?? '', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'password', 'name'=>"password", 'value'=>'', 'class'=>'password', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'checkbox', 'name'=>'', 'class'=>'ptoggler'],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature, 'error'=>''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$logintxt, 'error'=>''],
            ]
        ];

        foreach($formfields as $key=>$val) {
            $errs[$key] = isset($_POST[$key]) ? (isset($login[1]['gen']) ? $login[1]['gen'].'<br><br>' : ($login[1][$key] ?? null)) : null;
            $output[$key] = form_format($val);
            $fieldnames[$key] = array_combine(array_column($val, 'name'), $fieldnames[$key]);
        }
        // show($fieldnames);
        
        $data['formfields'] = $output;
        // show($data['formfields']);
        $data['fieldnames'] = $fieldnames;
        $data['formerror'] = $errs ?? $formdata[1] ?? null;
        $data['formsuccess'] = $success ?? '';
        $data['prompts'] = array_combine(['register', 'forgot'], $prompts);
        $this->view("account/login",$data);
    }

    function register() {
        $hash = set_signature();
        $signature = bin2hex(random_bytes(4)).'_'.$hash;

        include ROOT."/app/betagamers/incs/countrylist/".LANG.".php";
        if(LANG!='en') locale_sort($country_list, LANG);
        $country_form_list = array_combine(array_keys($country_list), array_column($country_list, 'name'));
        $this->page = 'register';
        $this->style = ".form {width: 70%;} @media screen and (max-width: 600px){.form {width: 100%;}}";
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers registration page, best footballprediction website';
            $this->description = 'Betagamers Registration Form: Join us today and explore with us.';
            $data['page_title'] = "Register";
            $data['h1'] = "Create An Account";
            $fieldnames = ['Full Name', 'E-mail', "I don't have email", 'Phone (Normal Number)', 'Select Country', 'Password', 'Show Password', ''];
            $placeholders = ['fullname'=>'Full Name', 'email'=>'E-mail', 'password'=>'Password'];
            $phoneins = "Select your country's code. Then, type your normal number eg: 07062345988";
            $prompts = ['submit'=>'Register', 'login'=>'Already a Member? SignIn'];
            $terms = "By creating an account you agree to our #Terms of Use# and #Privacy Policy#";
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football au mon';
            $this->description = "Formulaire d'inscription Betagamers: Rejoignez-nous aujourd'hui et gagnez avec nous.";
            $data['page_title'] = "Formulaire d'inscription";
            $data['h1'] = "Créer un compte";
            $fieldnames = ['Nom complet', 'E-mail', "Je n'ai pas d'email", 'Numéro de téléphone (nombre normal)', 'Choisissez le pays', 'Mot de passe', 'Montrer le Mot de Passe', ''];
            $placeholders = ['fullname'=>'Nom complet', 'email'=>'E-mail', 'password'=>'Mot de passe'];
            $phoneins = "Sélectionnez le code de votre pays. Tapez ensuite votre nombre normal, par exemple: 07062345988";
            $prompts = ['submit'=>'Soumettre', 'login'=>'Déjà membre? se connecter'];
            $terms = "En créant un compte, vous acceptez nos #conditions d'utilisation# et notre #politique de confidentialité#";
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Formulario de inscripción de Betagamers';
            $this->description = 'Formulario de inscripción de Betagamers: Únete a nosotras hoy.';
            $data['page_title'] = "Formulario de inscripción";
            $data['h1'] = "Crea una cuenta";
            $fieldnames = ['Nombre completo', 'Correo-e', "No tengo una dirección de correo-e", 'Teléfono (Número Normal)', 'Selecciona tu pais', 'Contraseña', 'Mostrar contraseña', ''];
            $placeholders = ['fullname'=>'Nombre completo', 'email'=>'Correo electrónico', 'password'=>'Contraseña'];
            $phoneins = "Selecciona el código de tu país, luego escriba su número normal p.eg: 07062345988";
            $prompts = ['submit'=>'Registrarse', 'login'=>'¿Ya eres usuario? Iniciar sesión'];
            $terms = "Al crear una cuenta, acepta nuestros #condiciones de uso# y #Política de privacidad#";
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = 'Formulário de registro de betagamers: Junte-se a nós hoje.';
            $data['page_title'] = "Cadastro";
            $data['h1'] = "Crie a sua conta";
            $fieldnames = ['Nome completo:', 'E-mail', "Não tenho e-mail", 'Telefone (Número Normal)', 'Selecione o pais', 'Senha', 'Mostrar senha', ''];
            $placeholders = ['fullname'=>'Nome completo:', 'email'=>'E-mail', 'password'=>'Senha'];
            $phoneins = "Selecione o código do seu país. Em seguida, digite seu número normal, por exemplo: 07062345988";
            $prompts = ['submit'=>'Enviar', 'login'=>'Já é um membro? Entrar'];
            $terms = "Ao criar uma conta, você concorda com nossos #Termos de Uso# e #Política de Privacidade#.";
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net';
            $this->description = 'Betagamers Anmeldeformular: Trete uns heute bei.';
            $data['page_title'] = "Registrierung";
            $data['h1'] = "Ein Konto erstellen";
            $fieldnames = ['Vollständiger Name', 'E-mail', "Ich habe keine E-Mail", 'Telefon (normale Nummer)', 'Land auswählen', 'Passwort', 'Passwort anzeigen', ''];
            $placeholders = ['fullname'=>'Vollständiger Name', 'email'=>'E-mail', 'password'=>'Passwort'];
            $phoneins = "Wählen Sie Ihre Landesvorwahl aus und geben Sie dann Ihre normale Nummer ein. zB: 07062345988";
            $prompts = ['submit'=>'Absenden', 'login'=>'Schon ein Mitglied? Einloggen'];
            $terms = "Indem Sie ein Konto erstellen, stimmen Sie unseren #Nutzungsbedingungen# und #Datenschutzbestimmungen# zu.";
        }
        $fieldnames[3] = 
        "<span class='w3-tooltip'><span style='position:absolute;left:0;bottom:18px' class='w3-text w3-tag w3-round-xlarge'>$phoneins
      </span>".$fieldnames[3]." <i class='fa fa-question-circle' style='font-size:15px; color:green'></i></span>";

        $countryname = $country_list[CF_COUNTRY]['name'];
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            check_signature('register', $hash);
            $genclass = new General;
            //show($_POST);
            $genclass->insertunique = ['email'];
            $genclass->required = ['email', 'phone'];
            $_POST['language'] = strtoupper(LANG);
            $validcountry = array_key_exists($_POST['country'], $country_form_list);
            $dialcode = $validcountry ? $country_list[$_POST['country']]['phone'] : (CF_COUNTRY ? $country_list[CF_COUNTRY]['phone'] : null);
            $countryname = $validcountry ? $country_list[$_POST['country']]['name'] : null;
            $_POST['hash'] = sha1(rand(0,1000));
            if(!isset($_POST['fullphone']) || trim($_POST['fullphone'])=='') {
                $_POST['fullphone'] = str_starts_with($_POST['phone'], '+') ? $_POST['phone'] : (str_starts_with($_POST['phone'], $dialcode) ? '+'.$_POST['phone'] : "+$dialcode".$_POST['phone']);
                $_POST['phone'] = str_replace('+', '', $_POST['phone']);
            }
            if (isset($_POST['noemail']) && $_POST['noemail']==true) {
                unset($_POST['email']);
                $genclass->insertunique = ['fullphone'];
            }
            $reg = $genclass->create($_POST, 'users', 'id, fullname, email, country, phone, fullphone, active, regotpcount');
            if($reg === true) {
                $_SESSION['newuser']['regcount'] = $_SESSION['newuser']['regcount'] + 1;
                if(isset($_POST['email']) && trim($_POST['email']) != '') {
                    $fullname = purify($_POST['fullname']);
                    $email = $to['email'] = purify($_POST['email']);
                    $hash = $_POST['hash'];
                    include ROOT."/app/betagamers/incs/mails/reg.php";
				    $genclass->sendmail($to, $message, $from);
				}
                header("location: auth");
                exit();
            } else {
                $formdata = $reg;
            }
            // var_dump($_POST);
        }
        $countrysymb = array_search($countryname, $country_form_list);
        $formfields = [
            ['tag'=>'input', 'id'=>"fullname", 'type'=>'text', 'placeholder'=>$placeholders['fullname'], 'name'=>"fullname", 'value'=>$formdata[0]['fullname'] ?? '', 'error'=>$formdata[1]['fullname'] ?? '', 'required'],
            ['tag'=>'input', 'id'=>"email", 'type'=>'email', 'placeholder'=>$placeholders['email'], 'name'=>"email", 'value'=>$formdata[0]['email'] ?? '', 'error'=>$formdata[1]['email'] ?? '', 'required'],
            ['tag'=>'input', 'id'=>"noemail", 'type'=>'checkbox', 'name'=>"noemail", 'value'=>true, 'error'=>'', isset($_POST['noemail']) && $_POST['noemail']==true ? 'checked' : ''],
            ['tag'=>'input', 'id'=>"phone", 'type'=>'tel', 'placeholder'=>'7062345988', 'name'=>"phone", 'value'=>$formdata[0]['fullphone'] ?? '', 'error'=>$formdata[1]['fullphone'] ?? '', 'required'],
            //['tag'=>'select', 'name'=>"country", 'options'=>['default_opt_'.($formdata[0]['country'] ?? '')=>$country_form_list[$formdata[0]['country'] ?? ''] ?? null, ...$country_form_list], 'id'=>'country', 'error'=>$formdata[1]['country'] ?? '', 'required'],
            ['tag'=>'select', 'name'=>"country", 'options'=>["default_opt_$countrysymb"=>$countryname, ...$country_form_list], 'id'=>'country', 'error'=>$formdata[1]['country'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'password', 'placeholder'=>$placeholders['password'], 'name'=>"password", 'value'=>'', 'class'=>'password', 'error'=>$formdata[1]['password'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'checkbox', 'name'=>'', 'class'=>'ptoggler', 'error'=>''],
            ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature, 'error'=>''],
            // ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$register, 'error'=>''],
        ];

        $errs = array_column($formfields, 'error', 'name');
        $errs['gen'] = isset($formdata[1]['language']) ? $genclass->sth_went_wrong() : '';
        $output = form_format($formfields);
        // show($output);

        $data['formfields'] = array_chunk($output, 4, true);
        $data['fieldnames'] = array_combine(array_column($formfields, 'name'), $fieldnames);
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formsuccess'] = $success ?? '';
        $data['terms'] = tag_format($terms, [['href'=>support_links('terms'), 'style'=>'color: green', 'target'=>'_blank'], ['href'=>support_links('privacy'), 'style'=>'color: green', 'target'=>'_blank']]);
        $data['prompts'] = $prompts;
        $this->view("account/register",$data);
    }

    function auth() {
        $this->page = 'Auth';
        $this->style = "b {color: green;}";
        if(LANG=='en') {
            $data['page_title'] = "Access Denied";
            $data['email']['message'] = "We have sent a link to your email, *".($_SESSION['users']['email'] ?? '')."*. Please click the link in your email to activate your account. Check both the Inbox and the Spam folders.";
            $data['email']['prompt1'] = ["Didin't receive an email", "Resend"];
            $data['email']['prompt2'] = "#Click here# to report to us if you did not receive any email / if the email address you provided was wrong / if you dont have email at all. Thanks.";
            $data['phone']['message'] = "A 6 digit code was sent to ".($_SESSION['users']["phone"] ?? '').". Please enter the code to verify your account. OTP expires after 10 minutes.";
            $data['phone']['prompt'] = "Use another verification method";
            $data['phone']['verifybtn'] = "Verify OTP";
            $data['phone']['resendbtn'] = "Didn't recieve otp? Resend";
            $data['phone']['confirmreg'] = "Please send *CONFIRM REG ".($_SESSION['users']['phone'] ?? '')."* to +2348157437268 through sms, Whatsapp or Telegram so that we can activate your account.<br><br>Please make sure to send the message from the same number you registered here. Thanks.";
            $data['autherr'] = "Auth mode wasn't set, please contact admin about this.";
            $data['script']['resend'] = "Resend";
            $data['script']['emailsent'] = "Email sent! Check your email, check your spam folder. Resend available in";
            $unknownerror = 'unknown error';
        } elseif(LANG=='fr') {
            $data['page_title'] = "Accès refusé";
            $data['email']['message'] = "Nous avons envoyé un lien vers votre e-mail, *".($_SESSION['users']['email'] ?? '')."*. Veuillez cliquer sur le lien dans votre e-mail pour activer votre compte. Vérifiez à la fois la boîte de réception et les dossiers de spam.";
            $data['email']['prompt1'] = ["Vous n'avez pas reçu d'e-mail", "Renvoyer"];
            $data['email']['prompt2'] = "#Cliquez ici# pour nous signaler si vous n'avez reçu aucun e-mail / si l'adresse e-mail que vous avez fournie est erronée / si vous n'avez pas du tout d'e-mail. Merci.";
            $data['phone']['message'] = "Un code à 6 chiffres a été envoyé au ".($_SESSION['users']["phone"] ?? '').". Veuillez saisir le code pour vérifier votre compte. OTP expire après 10 minutes.";
            $data['phone']['prompt'] = "Utilisez une autre méthode de vérification";
            $data['phone']['verifybtn'] = "Vérifiez OTP";
            $data['phone']['resendbtn'] = "Vous n'avez pas reçu d'OTP? Renvoyer";
            $data['phone']['confirmreg'] = "Veuillez envoyer *CONFIRMER REG ".($_SESSION['users']['phone'] ?? '')."* au +2348157437268 par SMS, WhatsApp ou télégramme pour activer votre compte.<br><br>Veuillez vous assurer d'envoyer le message à partir du même numéro que vous avez enregistré ici. Merci.";
            $data['autherr'] = "Le mode d'authentification n'a pas été défini, veuillez contacter l'administrateur à ce sujet.";
            $data['script']['resend'] = "Renvoyer";
            $data['script']['emailsent'] = "Email envoyé! Vérifiez votre courrier électronique, vérifiez votre dossier spam. Renvoi disponible dans";
            $unknownerror = 'erreur inconnue';
        } elseif(LANG=='es') {
            $data['page_title'] = "Acceso denegado";
            $data['email']['message'] = "Hemos enviado un enlace a su correo electrónico., *".($_SESSION['users']['email'] ?? '')."*. Por favor, haga clic en el enlace en su correo electrónico para activar su cuenta. Revisa tu bandeja de entrada y carpetas de correo no deseado.";
            $data['email']['prompt1'] = ["¿No recibiste un correo electrónico?", "Reenviar"];
            $data['email']['prompt2'] = "#Haga clic aquí# para informarnos si no recibió ningún correo electrónico, si la dirección de correo electrónico que proporcionó fue incorrecta o si no tiene una dirección de correo electrónico. Gracias.";
            $data['phone']['message'] = "Se envió un código de 6 dígitos al ".($_SESSION['users']["phone"] ?? '').". Ingrese el código para verificar su cuenta. La OTP caduca después de 10 minutos.";
            $data['phone']['prompt'] = "Utilice otro método de verificación";
            $data['phone']['verifybtn'] = "Verifique OTP";
            $data['phone']['resendbtn'] = "¿No recibiste otp? Reenviar";
            $data['phone']['confirmreg'] = "Envíe *CONFIRMAR REGISTRO ".($_SESSION['users']['phone'] ?? '')."* al +2348157437268 por mensaje de texto, Whatsapp o Telegram para que podamos activar su cuenta. <br><br>Por favor, asegúrese de enviar el mensaje desde el mismo número que registró aquí. Gracias.";
            $data['autherr'] = "El modo de autenticación no se configuró, comuníquese con el administrador sobre esto.";
            $data['script']['resend'] = "Reenviar";
            $data['script']['emailsent'] = "¡Email enviado! Revisa tu correo electrónico, revisa tu carpeta de spam. Reenvío disponible en";
            $unknownerror = 'error desconocido';
        } elseif(LANG=='pt') {
            $data['page_title'] = "Acesso negado";
            $data['email']['message'] = "Enviamos um link para seu e-mail, *".($_SESSION['users']['email'] ?? '')."*. Por favor, clique no link em seu e-mail para ativar sua conta. Verifique a caixa de entrada e as pastas de spam.";
            $data['email']['prompt1'] = ["Não recebeu um e-mail?", "Reenviar"];
            $data['email']['prompt2'] = "#Clique aqui# para nos informar se você não recebeu nenhum e-mail / se o endereço de e-mail que você forneceu estava errado / se você não tem e-mail. Obrigado.";
            $data['phone']['message'] = "Um código de 6 dígitos foi enviado para ".($_SESSION['users']["phone"] ?? '').". Digite o código para verificar sua conta. OTP expira após 10 minutos.";
            $data['phone']['prompt'] = "Use outro método de verificação";
            $data['phone']['verifybtn'] = "Verifique OTP";
            $data['phone']['resendbtn'] = "Não recebeu otp? Reenviar";
            $data['phone']['confirmreg'] = "Por favor, envie *CONFIRMAR REG ".($_SESSION['users']['phone'] ?? '')."* para +2348157437268 através de SMS, Whatsapp ou Telegram para que possamos ativar sua conta. <br><br>Por favor, certifique-se de enviar a mensagem do mesmo número que você registrou aqui. Obrigado.";
            $data['autherr'] = "O modo de autenticação não foi definido. Entre em contato com o administrador sobre isso.";
            $data['script']['resend'] = "Reenviar";
            $data['script']['emailsent'] = "E-mail enviado! Verifique seu e-mail, verifique sua pasta de spam. Reenviar disponível em";
            $unknownerror = 'erro desconhecido';
        } elseif(LANG=='de') {
            $data['page_title'] = "Zugriff abgelehnt";
            $data['email']['message'] = "Wir haben einen Link an Ihre E-Mail gesendet, *".($_SESSION['users']['email'] ?? '')."*. Bitte klicken Sie auf den Link in Ihrer E-Mail, um Ihr Konto zu aktivieren. Überprüfen Sie sowohl den Posteingang als auch den Spam-Ordner.";
            $data['email']['prompt1'] = ["Keine E-Mail erhalten?", "Erneut senden"];
            $data['email']['prompt2'] = "#Klicken Sie hier#, um uns zu melden, wenn Sie keine E-Mail erhalten haben / wenn die von Ihnen angegebene E-Mail-Adresse falsch war / wenn Sie überhaupt keine E-Mail haben. Vielen Dank.";
            $data['phone']['message'] = "Ein 6-stelliger Code wurde an ".($_SESSION['users']["phone"] ?? '')." gesendet. Bitte geben Sie den Code ein, um Ihr Konto zu bestätigen. OTP läuft nach 10 Minuten ab.";
            $data['phone']['prompt'] = "Verwenden Sie eine andere Überprüfungsmethode";
            $data['phone']['verifybtn'] = "Überprüfen Sie das OTP";
            $data['phone']['resendbtn'] = "OTP nicht erhalten? Erneut senden";
            $data['phone']['confirmreg'] = "Bitte senden Sie *REG. BESTÄTIGEN ".($_SESSION['users']['phone'] ?? '')."* per SMS, WhatsApp oder Telegram an +2348157437268, damit wir Ihr Konto aktivieren können.<br><br>Bitte stellen Sie sicher, dass Sie die Nachricht von derselben Nummer senden, die Sie hier registriert haben. Danke.";
            $data['autherr'] = "Der Authentifizierungsmodus wurde nicht festgelegt. Wenden Sie sich diesbezüglich bitte an den Administrator.";
            $data['script']['resend'] = "Erneut senden";
            $data['script']['emailsent'] = "E-Mail gesendet! Überprüfen Sie Ihre E-Mails und Ihren Spam-Ordner. Erneut senden möglich in";
            $unknownerror = 'unbekannter Fehler';
        }
        $data['email']['message'] = tag_format($data['email']['message']);
        $data['email']['prompt2'] = tag_format($data['email']['prompt2'], [['href'=>support_links('mailus'), 'style'=>'font-weight:bold; color:green']]);
        $data['phone']['confirmreg'] = tag_format($data['phone']['confirmreg']);

        if(isset($_SESSION['users']["active"]) && $_SESSION['users']["active"] == 0) {
            if(isset($_SESSION['users']["email"]) && $_SESSION['users']["email"] == "") {
                $this->authmode = 'phone';
            } elseif (isset($_SESSION['users']["email"]) && $_SESSION['users']["email"] != "") {
                $this->authmode = 'email';
            } else {}
            unset($_SESSION['users']["logged_in"]);
        } elseif(isset($_SESSION['users']["active"]) && $_SESSION['users']["active"] == 1){
    		if(isset($_SESSION["redirectURL"])) {
    		    header('Location:'.$_SESSION['redirectURL']); 
    		} else {
    			header("Location: ".account_links('profile'));
    		}
            exit;
        } elseif(isset($_SESSION['users']["active"]) && $_SESSION['users']["active"] == 2) {
    	    $data['maxauth'] = true;
    	    unset($_SESSION['users']["logged_in"]);
    	} else {
    		echo $unknownerror;
            unset($_SESSION['users']);
    		//session_unset();
    		//session_destroy();
    		exit();
    	}
        $this->view("account/auth",$data);
    }

    function verify() {
        $this->page = 'verify';
        if(LANG=='en') {
            $data['page_title'] = "New Account Verification";
        } elseif(LANG=='fr') {
            $data['page_title'] = "Vérification du nouveau compte";
        } elseif(LANG=='es') {
            $data['page_title'] = "Verificación de cuenta nueva";
        } elseif(LANG=='pt') {
            $data['page_title'] = "Verificação de nova conta";
        } elseif(LANG=='de') {
            $data['page_title'] = "Neue Kontobestätigung";
        }
        if(isset($_GET['email']) && isset($_GET['hash'])) {
            $genclass = new General;
            $email_hash = array_intersect_key($_GET, ['email'=>'keep', 'hash'=>'keep']);
            $userdata = $genclass->get_by_email_and_hash('users', ['fullname', 'email'], $email_hash);
            if(is_array($userdata[0]) && count($userdata[0]) && $userdata[1] === false) {
                $update = $genclass->update_by_email_and_hash('users', ['hash'=>generate_hash(), 'active'=>1], $email_hash);
                if($update[0]===true) {
                    $_SESSION['users']['active'] = 1;
                    header("location: ".account_links('profile'));
                    exit();
                } else {
                    $data['err'] = $genclass->sth_went_wrong().' '.$genclass->resp_try_again();
                }
            }
        }
        $data['err'] = match(LANG) {
            'en' => "Account has already been activated or the URL is invalid.",
            'fr' => "Le compte a déjà été activé ou l'URL n'est pas valide.",
            'es' => "Esta cuenta ya se ha activado o la URL no es válida.",
            'pt' => "A conta já foi ativada ou o URL é inválido.",
            'de' => "Konto wurde bereits aktiviert oder die URL ist ungültig.",
        };
        $this->view("account/verify",$data);
    }

    function forgot() {
        $hash = set_signature();
        $signature = bin2hex(random_bytes(4)).'_'.$hash;
        //We could not find the email $email. Please click <a href='register' style='text-decoration: underline'>here</a> to register.<br>
        $this->page = 'forgot';
        $this->style = ".success {color: green; text-align: center;}";
        if(LANG=='en') {
            $data['page_title'] = "Forgot Password";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, sports tips, accurate sports prediction website, accurate sports prediction site, sure tips';
            $this->description = 'You can use this page to reset your account on BetaGamers';
            $data['h1'] = 'Enter your E-mail Address';
            $data['h2'] = 'Enter your Phone Number';
            $data['tab'] = ['With Email', 'With Phone'];
            $fieldnames['email'] = ['E-mail', '', ''];
            $fieldnames['fullphone'] = ['Enter your Phone Number', '', ''];
            $phoneins = "Select your country's code. Then, type your normal number eg: 07062345988";
            $submit = 'Submit';
        } elseif(LANG=='fr') {
            $data['page_title'] = "Mot de passe oublié";
            $this->keywords = "Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis";
            $this->description = 'Vous pouvez utiliser cette page pour réinitialiser votre compte sur BetaGamers';
            $data['h1'] = 'Entrez votre adresse e-mail';
            $data['h2'] = 'Entrez votre numéro de téléphone';
            $data['tab'] = ['Avec e-mail', 'Avec téléphone'];
            $fieldnames['email'] = ['E-mail', '', ''];
            $fieldnames['fullphone'] = ['Numéro de téléphone (nombre normal)', '', ''];
            $phoneins = "Sélectionnez le code de votre pays. Tapez ensuite votre nombre normal, par exemple: 07062345988";
            $submit = 'Soumettre';
        } elseif(LANG=='es') {
            $data['page_title'] = "Has olvidado tu contraseña";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, es.betagamers.net';
            $this->description = 'Has olvidado tu contraseña de Betagamers.';
            $data['h1'] = 'Ingrese su dirección de correo electrónico';
            $data['h2'] = 'Ingrese su número telefónico';
            $data['tab'] = ['Con correo', 'Con teléfono'];
            $fieldnames['email'] = ['Correo-e', '', ''];
            $fieldnames['fullphone'] = ['Número de teléfono', '', ''];
            $phoneins = "Selecciona el código de tu país, luego escriba su número normal p.eg: 07062345988";
            $submit = 'Enviar';
        } elseif(LANG=='pt') {
            $data['page_title'] = "Esqueceu sua senha";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = 'Você pode usar esta página para redefinir sua conta no BetaGamers';
            $data['h1'] = 'Insira o seu endereço de email';
            $data['h2'] = 'Digite seu número de telefone';
            $data['tab'] = ['Com E-mail', 'Com número'];
            $fieldnames['email'] = ['E-mail', '', ''];
            $fieldnames['fullphone'] = ['Telefone', '', ''];
            $phoneins = "Selecione o código do seu país. Em seguida, digite seu número normal, por exemplo: 07062345988";
            $submit = 'Enviar';
        } elseif(LANG=='de') {
            $data['page_title'] = "Passwort vergessen";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net';
            $this->description = 'Sie können diese Seite verwenden, um Ihr Konto bei BetaGamers zurückzusetzen';
            $data['h1'] = 'Geben sie ihre E-Mailadresse ein';
            $data['h2'] = 'Gib deine Telefonnummer ein';
            $data['tab'] = ['Mit E-Mail', 'Mit Telefon'];
            $fieldnames['email'] = ['E-mail', '', ''];
            $fieldnames['fullphone'] = ['Telefon', '', ''];
            $phoneins = "Wählen Sie Ihre Landesvorwahl aus und geben Sie dann Ihre normale Nummer ein. zB: 07062345988";
            $submit = 'Einreichen';
        }
        $fieldnames['fullphone'][0] = 
        "<span class='w3-tooltip'><span style='position:absolute;left:0;bottom:18px' class='w3-text w3-tag w3-round-xlarge'>$phoneins
        </span>".$fieldnames['fullphone'][0]." <i class='fa fa-question-circle' style='font-size:15px; color:green'></i></span>";
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            check_signature('forgot', $hash);
            unset($_POST['submit']);
            unset($_POST['signature']);
            $get_by = 'get_by_'.implode('', array_keys($_POST));
            $genclass = new General;
            $userdata = $genclass->$get_by('users', ['fullname', 'email', 'fullphone', 'hash'], array_values($_POST));
            // show($userdata);
            if(is_array($userdata[0]) && count($userdata[0]) && $userdata[1] === false) {
                $userdata = $userdata[0];
                if(trim($userdata[0]["email"]) !='' && !str_contains($userdata[0]["email"], 'betagamers.net')) {
                    $to['email'] = $email = $userdata[0]["email"];
                    $hash = $userdata[0]["hash"];
                    $fullname = $userdata[0]["fullname"];
                    // $lang = $userdata[0]['language'];
                    include ROOT."/app/betagamers/incs/mails/forgot.php";
                    $genclass->sendmail($to, $message, $from);
                    $success['email'] = match(LANG) {
                        'fr' => "<p>Succès! Veuillez vérifier votre e-mail, <span>$email</span> pour le lien de réinitialisation de votre mot de passe!</p>",
                        'es' => "<p>Exitoso! Por favor revise su correo electrónico, <span>$email</span> para su enlace de restablecimiento de contraseña!</p>",
                        'pt' => "<p>Bem-sucedido! Por favor, verifique seu e-mail, <span>$email</span> para o link de redefinição de senha!</p>",
                        'de' => "<p>Erfolgreich! Bitte überprüfen Sie Ihre E-Mail, <span>$email</span>, auf Ihren Link zum Zurücksetzen des Passworts!</p>",
                        default => "<p>Succesful! Please check your email, <span>$email</span> for your password reset link!</p>",
                    }.'<br>';
                    unset ($_POST);
                } else {
                    $fullphone = $userdata[0]["fullphone"];
                    $success['fullphone'] = match(LANG) {
                        'fr' => "<p>Envoyez <b>RÉINITIALISER</b> au +2348157437268 par sms, Whatsapp ou Telegram.<br>Assurez-vous d'envoyer le message à partir de $fullphone. Merci.</p>",
                        'es' => "<p>Envía <b>RESTABLECER CONTRASEÑA</b> al +2348157437268 a través de sms, Whatsapp o Telegram.<br>Asegúrese de enviar el mensaje desde las $fullphone. Gracias.</p>",
                        'pt' => "<p>Envie <b>REDEFINIR SENHA</b> para +2348157437268 através de sms, Whatsapp ou Telegram.<br>Por favor, certifique-se de enviar a mensagem de $fullphone. Obrigado.</p>",
                        'de' => "<p>Senden Sie <b>PASSWORT ZURÜCKSETZEN</b> per SMS, WhatsApp oder Telegram an +2348157437268.<br>Bitte stellen Sie sicher, dass Sie die Nachricht von $fullphone Uhr senden. Danke.</p>",
                        default => "<p>Send <b>RESET PASS</b> to +2348157437268 through sms, Whatsapp or Telegram.<br>Please make sure to send the message from $fullphone. Thanks.</p>",
                    }.'<br>';
                }
                $_SESSION['newuser']['regcount'] = $_SESSION['newuser']['regcount'] + 1;
            } else {
                // $this->err = true;
                if($userdata[1] === false) {
                    if($get_by=='get_by_fullphone') {
                        $fullphone = $genclass->inputs['fullphone'];
                        $errs['fullphone'] = match(LANG) {
                            'fr' => "Numéro de téléphone introuvable",
                            'es' => "Número de teléfono no encontrado",
                            'pt' => "Número de telefone não encontrado",
                            'de' => "Telefonnummer nicht gefunden",
                            default => "Phone number not found",
                        }.'<br>';
                    } else {
                        $email = $genclass->inputs['email'];
                        $errs['email'] = match (LANG) {
                            'fr' => "Nous n'avons pas pu trouver l'e-mail $email. Veuillez cliquer <a href='inscrire' style='text-decoration: underline'>ici</a> pour vous inscrire. <br>",
                            'es' => "No pudimos encontrar la dirección de correo electrónico. $email. Por favor haga clic <a href='registro' style='text-decoration: underline'>aquí</a> para registrarse.<br>",
                            'pt' => "Não encontramos o e-mail $email. Por favor clique <a href='registro' style='text-decoration: underline'>aqui</a> para se registar.<br>",
                            'de' => "Wir konnten die E-Mail $email nicht finden. Bitte klicken Sie <a href='registrieren' style='text-decoration: underline'>hier</a>, um sich zu registrieren.<br>",
                            default => "We could not find the email $email. Please click <a href='register' style='text-decoration: underline'>here</a> to register.<br>",
                        }.'<br>';
                    }
                } else {
                    // $response = $userdata;
                }
            }
            // $data['form'] = $response ?? '';
            // show($data['form']);
        }

        $formfields = [
            'email'=>[
                ['tag'=>'input', 'type'=>'email', 'name'=>"email", 'value'=>$email ?? '', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature, 'error'=>''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$submit, 'error'=>''],
            ],
            'fullphone'=>[
                ['tag'=>'input', 'id'=>"fullphone", 'type'=>'tel', 'placeholder'=>'7062345988', 'name'=>"fullphone", 'value'=>$fullphone ?? '', 'error'=>'', 'required'],
                ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature, 'error'=>''],
                ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$submit, 'error'=>''],
            ]
        ];

        foreach($formfields as $key=>$val) {
            $errs[$key] = isset($_POST[$key]) ? (isset($userdata[1]['gen']) ? $userdata[1]['gen'].'<br><br>' : ($userdata[1][$key] ?? $errs[$key] ?? null)) : null;
            $success[$key] = $success[$key] ?? '';
            $output[$key] = form_format($val);
            $fieldnames[$key] = array_combine(array_column($val, 'name'), $fieldnames[$key]);
        }
        // show($fieldnames);
        
        $data['formfields'] = $output;
        // show($data['formfields']);
        $data['fieldnames'] = $fieldnames;
        $data['formerror'] = $errs ?? $formdata[1] ?? null;
        $data['formsuccess'] = $success ?? '';
        // $data['prompts'] = array_combine(['register', 'forgot'], $prompts);
        $this->view("account/forgot",$data);
    }

    function reset() {
        //'en' => "<p>Password Reset was succesful! <a href='login' style='color:green; text-decoration:underline'>Click here</a> to login.</p>",
        $hash = set_signature();
        $signature = bin2hex(random_bytes(4)).'_'.$hash;
        $this->page = 'reset';
        if(LANG=='en') {
            $data['page_title'] = "Reset Password";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = 'Betagamers Password Reset';
            $data['h1'] = 'Password Reset';
            $fieldnames = ['New Password', 'Show Password', '', ''];
            $reset = 'RESET';

        } elseif(LANG=='fr') {
            $data['page_title'] = "Réinitialiser le mot de passe";
            $this->keywords = 'Betagamers.net, betagamers, fr.betagamers.net, site Web du betagamers website';
            $this->description = 'Réinitialisation du mot de passe Betagamers';
            $data['h1'] = 'Réinitialisation du mot de passe';
            $fieldnames = ['Nouveau mot de passe', 'Montrer le Mot de Passe', '', ''];
            $reset = 'RÉINITIALISER';

        } elseif(LANG=='es') {
            $data['page_title'] = "Restablecer la contraseña";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, es.betagamers.net';
            $this->description = 'Restablece la contraseña de tu cuenta de Betagamers';
            $data['h1'] = 'Restablecimiento de contraseña';
            $fieldnames = ['Nueva contraseña', 'Mostrar contraseña', '', ''];
            $reset = 'REINICIAR';

        } elseif(LANG=='pt') {
            $data['page_title'] = "Redefinir senha";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = 'Redefinição de senha de betagamers';
            $data['h1'] = 'Redefinição de senha';
            $fieldnames = ['Nova Senha', 'Mostrar senha', '', ''];
            $reset = 'REDEFINIR';

        } elseif(LANG=='de') {
            $data['page_title'] = "Passwort zurücksetzen";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net';
            $this->description = 'Passwort zurücksetzen';
            $data['h1'] = 'Passwort zurücksetzen';
            $fieldnames = ['Neues Passwort', 'Passwort anzeigen', '', ''];
            $reset = 'ZURÜCKSETZEN';

        }
        $genclass = new General;
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST)) {
            check_signature('reset', $hash);
            $data['showform'] = true;
            $email_hash = array_intersect_key($_GET, ['email'=>'keep', 'hash'=>'keep']);
            $update = $genclass->update_by_email_and_hash('users', ['password'=>$_POST['password'], 'hash'=>generate_hash(), 'active'=>1], $email_hash);
            if($update[0]===true) {
                $_SESSION['newuser']['regcount'] = $_SESSION['newuser']['regcount'] + 1;
                $success = match (LANG) {
                    'en' => "<p>Password Reset was succesful! <a href='login' style='color:green; text-decoration:underline'>Click here</a> to login.</p>",
                    'fr' => "<p>Votre mot de passe a été changé avec succès. <a href='connecter' style='color:green; text-decoration:underline'>Cliquez ici</a> pour vous connecter.</p>",
                    'es' => "<p>Tu contraseña ha sido cambiada exitosamente. <a href='login' style='color:green; text-decoration:underline'>Haga clic aquí</a> para ingresar.</p>",
                    'pt' => "<p>Sua senha foi alterada com sucesso. <a href='entrar' style='color:green; text-decoration:underline'>Clique aqui</a> para logar.</p>",
                    'de' => "<p>Ihr Passwort wurde erfolgreich geändert. <a href='einloggen' style='color:green; text-decoration:underline'>Klicken Sie hier</a> um sich einzuloggen.</p>",
                };
            }
        } elseif(isset($_GET['email']) && isset($_GET['hash'])) {
            $email_hash = array_intersect_key($_GET, ['email'=>'keep', 'hash'=>'keep']);
            $userdata = $genclass->get_by_email_and_hash('users', ['fullname', 'email'], $email_hash);
            // show($userdata);
            if(is_array($userdata[0]) && count($userdata[0]) && $userdata[1] === false) {
                $data['showform'] = true;
                $data['email'] = $userdata[0][0]['email'];
            } else {
                $response_err = match (LANG) {
                    'en' => 'You have entered an invalid URL for password reset!',
                    'fr' => 'Vous avez entré une URL non valide pour la réinitialisation du mot de passe!',
                    'es' => 'Has introducido una URL no válida para restablecer tu contraseña!',
                    'pt' => 'Você inseriu um URL inválido para redefinição de senha!',
                    'de' => 'Sie haben eine ungültige URL zum Zurücksetzen des Passworts eingegeben!',
                };
            }
        } else {}
        $formfields = [
            ['tag'=>'input', 'type'=>'password', 'name'=>"password", 'value'=>'', 'class'=>'password', 'required'],
            ['tag'=>'input', 'type'=>'checkbox', 'name'=>'', 'class'=>'ptoggler'],
            ['tag'=>'input', 'type'=>'hidden', 'name'=>"signature", 'value'=>$signature],
            ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$reset],
        ];

        $err = $update[1]['password'] ?? $update[1]['gen'] ?? '';
        $output = form_format($formfields);
        // show($output);

        $data['formfields'] = $output;
        $data['fieldnames'] = array_combine(array_column($formfields, 'name'), $fieldnames);
        $data['formerror'] = $err ?? null;
        $data['response_err'] = $response_err ?? $genclass->sth_went_wrong(LANG);
        $data['formsuccess'] = $success ?? '';
        $this->view("account/reset",$data);
    }

    function profile() {
        check_logged_in();
        $country = isset($_SESSION['users']['country']) && trim($_SESSION['users']['country']) != '' ? strtolower($_SESSION['users']['country']) : strtolower(CF_COUNTRY);
        $this->page = 'profile';
        $diamondclass = new Diamond;
        $duration = $diamondclass->select("expdate as diamond, 
        (select expdate from platinum where email=:email) as platinum,
        (select expdate from alpha where email=:email) as ultimate,
        (select expdate from othersports where email=:email and sports='tennis') as 'tennis vip'")
        ->where('email=:email', ['email'=>$_SESSION['users']['email']]);
        
        if(is_array($duration) && count($duration)) {
            $duration = $duration[0];
            foreach($duration as $key=>$val) {
                if(!$val) {
                    continue;
                }
                $exptime = strtotime($val);
                $remaining = $exptime - time();
                $days = floor($remaining / 86400);
                $hours = floor(($remaining % 86400) / 3600);

                if(strtotime('now') < $exptime) {
                    $data['table']['color'][$key] = 'blue';
                    $active[$key] = ['days'=>$days, 'hours'=>$hours];
                } else {
                    $expired[] = $key;
                }
            }
        } else {}
        $data['tabs'] = sports();
        $data['plannames'] = plans();
        if(LANG=='en') {
            $this->description = 'Betagamers Profile';
            $data['page_title'] = "Profile";
            $data['table']['h1'] = 'Account Information';
            $data['table']['user'] = ['fullname'=>'Name', 'email'=>'Email', 'phone'=>'Phone', 'country'=>'Country'];
            $data['table']['substatus'] = 'Subscription Status'; //diamond, platinum etc
            $substatus = "Active. Expires in: dd days, hh hours";
            $data['substatus']['ultimate'] = isset($active) && array_key_exists('ultimate', $active) ? str_replace(['dd', 'hh'], [$active['ultimate']['days'], $active['ultimate']['hours']], $substatus) : (isset($expired) && in_array('ultimate', $expired) ? 'Expired' : 'Not Active');
            $data['substatus']['platinum'] = isset($active) && array_key_exists('platinum', $active) ? str_replace(['dd', 'hh'], [$active['platinum']['days'], $active['platinum']['hours']], $substatus) : (isset($expired) && in_array('platinum', $expired) ? 'Expired' : 'Not Active');
            $data['substatus']['diamond'] = isset($active) && array_key_exists('diamond', $active) ? str_replace(['dd', 'hh'], [$active['diamond']['days'], $active['diamond']['hours']], $substatus) : (isset($expired) && in_array('diamond', $expired) ? 'Expired' : 'Not Active');
            $data['substatus']['tennis vip'] = isset($active) && array_key_exists('tennis vip', $active) ? str_replace(['dd', 'hh'], [$active['tennis vip']['days'], $active['tennis vip']['hours']], $substatus) : (isset($expired) && in_array('tennis vip', $expired) ? 'Expired' : 'Not Active');
            $data['table']['h2'] = 'Subscription Plans';
            $data['plan']['features'] = 'FEATURES';
            $data['plan']['choose'] = 'CHOOSE PLAN';
        } elseif(LANG=='fr') {
            $this->description = 'Profil de BetaGamers';
            $data['page_title'] = "Profil";
            $data['table']['h1'] = 'Information sur le compte';
            $data['table']['user'] = ['fullname'=>'Nom', 'email'=>'E-mail', 'phone'=>'Numéro de téléphone', 'country'=>'Pays'];
            $data['table']['substatus'] = "État de l'abonnement"; //diamond, platinum etc
            $substatus = "Actif. Expire dans: dd jours, hh heures";
            $data['substatus']['ultimate'] = isset($active) && array_key_exists('ultimate', $active) ? str_replace(['dd', 'hh'], [$active['ultimate']['days'], $active['ultimate']['hours']], $substatus) : (isset($expired) && in_array('ultimate', $expired) ? 'Expiré' : 'Pas actif');
            $data['substatus']['platinum'] = isset($active) && array_key_exists('platinum', $active) ? str_replace(['dd', 'hh'], [$active['platinum']['days'], $active['platinum']['hours']], $substatus) : (isset($expired) && in_array('platinum', $expired) ? 'Expiré' : 'Pas actif');
            $data['substatus']['diamond'] = isset($active) && array_key_exists('diamond', $active) ? str_replace(['dd', 'hh'], [$active['diamond']['days'], $active['diamond']['hours']], $substatus) : (isset($expired) && in_array('diamond', $expired) ? 'Expiré' : 'Pas actif');
            $data['substatus']['tennis vip'] = isset($active) && array_key_exists('tennis vip', $active) ? str_replace(['dd', 'hh'], [$active['tennis vip']['days'], $active['tennis vip']['hours']], $substatus) : (isset($expired) && in_array('tennis vip', $expired) ? 'Expiré' : 'Pas actif');
            $data['table']['h2'] = "Plans d\'abonnement";
            $data['plan']['features'] = 'CARACTÉRISTIQUES';
            $data['plan']['choose'] = 'CHOISIR';
        } elseif(LANG=='es') {
            $this->description = 'Perfil de Betagamers';
            $data['page_title'] = "Perfil";
            $data['table']['h1'] = 'Información de la cuenta';
            $data['table']['user'] = ['fullname'=>'Nombre', 'email'=>'Correo-e', 'phone'=>'Teléfono', 'country'=>'País'];
            $data['table']['substatus'] = 'Estado de suscripción'; //diamond, platinum etc
            $substatus = "Activo. Caduca en: dd días, hh horas";
            $data['substatus']['ultimate'] = isset($active) && array_key_exists('ultimate', $active) ? str_replace(['dd', 'hh'], [$active['ultimate']['days'], $active['ultimate']['hours']], $substatus) : (isset($expired) && in_array('ultimate', $expired) ? 'Caducado' : 'No activo');
            $data['substatus']['platinum'] = isset($active) && array_key_exists('platinum', $active) ? str_replace(['dd', 'hh'], [$active['platinum']['days'], $active['platinum']['hours']], $substatus) : (isset($expired) && in_array('platinum', $expired) ? 'Caducado' : 'No activo');
            $data['substatus']['diamond'] = isset($active) && array_key_exists('diamond', $active) ? str_replace(['dd', 'hh'], [$active['diamond']['days'], $active['diamond']['hours']], $substatus) : (isset($expired) && in_array('diamond', $expired) ? 'Caducado' : 'No activo');
            $data['substatus']['tennis vip'] = isset($active) && array_key_exists('tennis vip', $active) ? str_replace(['dd', 'hh'], [$active['tennis vip']['days'], $active['tennis vip']['hours']], $substatus) : (isset($expired) && in_array('tennis vip', $expired) ? 'Caducado' : 'No activo');
            $data['table']['h2'] = 'Planes de Suscripción';
            $data['plan']['features'] = 'CARACTERISTICAS';
            $data['plan']['choose'] = 'VEA AHORA';
        } elseif(LANG=='pt') {
            $this->description = 'Votre perfil em Betagamers';
            $data['page_title'] = "Perfil";
            $data['table']['h1'] = 'Informação da conta';
            $data['table']['user'] = ['fullname'=>'Nome', 'email'=>'E-mail', 'phone'=>'Telefone', 'country'=>'País'];
            $data['table']['substatus'] = 'Status de assinatura'; //diamond, platinum etc
            $substatus = "Ativo. Expira em: dd dias, hh horas";
            $data['substatus']['ultimate'] = isset($active) && array_key_exists('ultimate', $active) ? str_replace(['dd', 'hh'], [$active['ultimate']['days'], $active['ultimate']['hours']], $substatus) : (isset($expired) && in_array('ultimate', $expired) ? 'Expirado' : 'Não ativo');
            $data['substatus']['platinum'] = isset($active) && array_key_exists('platinum', $active) ? str_replace(['dd', 'hh'], [$active['platinum']['days'], $active['platinum']['hours']], $substatus) : (isset($expired) && in_array('platinum', $expired) ? 'Expirado' : 'Não ativo');
            $data['substatus']['diamond'] = isset($active) && array_key_exists('diamond', $active) ? str_replace(['dd', 'hh'], [$active['diamond']['days'], $active['diamond']['hours']], $substatus) : (isset($expired) && in_array('diamond', $expired) ? 'Expirado' : 'Não ativo');
            $data['substatus']['tennis vip'] = isset($active) && array_key_exists('tennis vip', $active) ? str_replace(['dd', 'hh'], [$active['tennis vip']['days'], $active['tennis vip']['hours']], $substatus) : (isset($expired) && in_array('tennis vip', $expired) ? 'Expirado' : 'Não ativo');
            $data['table']['h2'] = 'Planos de assinatura';
            $data['plan']['features'] = 'RECURSOS';
            $data['plan']['choose'] = 'ESCOLHER PLANO';
        } elseif(LANG=='de') {
            $this->description = 'Betagamers Profil';
            $data['page_title'] = "Profil";
            $data['table']['h1'] = 'Kontoinformationen';
            $data['table']['user'] = ['fullname'=>'Name', 'email'=>'Email', 'phone'=>'Telefon', 'country'=>'Land'];
            $data['table']['substatus'] = 'Abonnementstatus'; //diamond, platinum etc
            $substatus = "Aktiv. Läuft in: dd Tagen, hh Stunden";
            $data['substatus']['ultimate'] = isset($active) && array_key_exists('ultimate', $active) ? str_replace(['dd', 'hh'], [$active['ultimate']['days'], $active['ultimate']['hours']], $substatus) : (isset($expired) && in_array('ultimate', $expired) ? 'Abgelaufen' : 'Nicht aktiv');
            $data['substatus']['platinum'] = isset($active) && array_key_exists('platinum', $active) ? str_replace(['dd', 'hh'], [$active['platinum']['days'], $active['platinum']['hours']], $substatus) : (isset($expired) && in_array('platinum', $expired) ? 'Abgelaufen' : 'Nicht aktiv');
            $data['substatus']['diamond'] = isset($active) && array_key_exists('diamond', $active) ? str_replace(['dd', 'hh'], [$active['diamond']['days'], $active['diamond']['hours']], $substatus) : (isset($expired) && in_array('diamond', $expired) ? 'Abgelaufen' : 'Nicht aktiv');
            $data['substatus']['tennis vip'] = isset($active) && array_key_exists('tennis vip', $active) ? str_replace(['dd', 'hh'], [$active['tennis vip']['days'], $active['tennis vip']['hours']], $substatus) : (isset($expired) && in_array('tennis vip', $expired) ? 'Abgelaufen' : 'Nicht aktiv');
            $data['table']['h2'] = 'Abonnementpläne';
            $data['plan']['features'] = 'MERKMALE';
            $data['plan']['choose'] = 'WÄHLEN SIE DIESEN TARIF';
        } 
        $pdetails = currencies(USER_COUNTRY);
        $data['plan']['currency'] = $pdetails['currency'];
        $data['plan']['cur_sign'] = $pdetails['cur_sign'];
        $data['plan']['paylink'] = pay_links($pdetails['extralink'] ?? $pdetails['link']);
        include ROOT."/app/betagamers/incs/menutips.php";
        $data['sidelist'] = $sidelist;
        $this->view("account/profile",$data);
    }
}