<?php
class Support extends Controller {
    public $activepage = 'support';
    public $tags = true;
    public $writeupclass = 'w3-col m9 justify';
    // public $bn = 'BN 2674390';

    function sidelist() {
        include ROOT."/app/betagamers/incs/menusupport.php";
        return $sidelist;
    }

    private function urls($custom='') {
        $this->urls = support_links($this->page ?? $custom, true);
    }

    function index() {
        $this->urls(); //when $this->page hasn't been set, so that parameter=''
        $this->page = 'contact';
        $this->style = '.w3-ul li:last-child{border-bottom:1px solid #ddd} .tips-prof a{text-decoration: none}';
        $this->writeupclass = 'tips-prof';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, Betagamers Login page, best ftball prediction website';
            $this->description = 'Betagamers Subscription Payment Page. View the various payment options available.';
            $data['page_title'] = "Support Center";
            $data['h1'] = 'BetaGamers Support';
            $data['call']['header'] = 'We are Existent';
            $data['call']['prompt'] = 'Call or SMS';
            $data['email']['prompt'] = 'Email Us';
            $data['email']['text'] = "#Click here# to mail us and we'll get back to you in 24hours. You can also send us an email through ".EMAIL;
            $data['chat']['prompt'] = 'Chat with Us';
            $data['chat']['text'] = '#Click here# to chat with us.';
            $data['work']['header'] = 'Want to work for us?';
            $data['work']['text'] = '#Click here# to check for available jobs.';
            $data['social']['header'] = 'We are social too';
            $data['socials']['fb']['text'] = 'On FaceBook';
            $data['socials']['x']['text'] = 'On X';
            $data['socials']['ig']['text'] = 'On Instagram';
            $data['socials']['pinterest']['text'] = 'On Pinterest';
            $data['socials']['whatsapp']['text'] = 'On Whatsapp';
            $data['socials']['telegram']['text'] = 'On Telegram';
            $data['socials']['tchannel']['text'] = 'Telegram Channel';
            $data['socials']['fbgroup']['text'] = 'Recommended FaceBook Group';
            $data['socials']['fbgroup']['name'] = 'Sure Games Daily';
        } elseif(LANG=='fr') {
            $data['page_title'] = "Centre d'assistance Betagamers";
            $this->description = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->keywords = 'Centre de support Betagamers: Contactez-nous dès aujourd\'hui pour tout ce qui concerne nos produits ou services, nous serons heureux de vous aider.';
            $data['h1'] = 'Centre d\'assistance BetaGamers';
            $data['call']['header'] = 'Appeler ou SMS';
            $data['call']['prompt'] = 'Appeler ou SMS';
            $data['email']['prompt'] = 'Envoyez-nous un email';
            $data['email']['text'] = "#Cliquez ici# pour nous envoyer un e-mail et nous vous répondrons dans les 24 heures. Vous pouvez également nous envoyer un e-mail via ".EMAIL;
            $data['chat']['prompt'] = 'Discutez avec nous';
            $data['chat']['text'] = '#Cliquez ici# pour discuter avec nous.';
            $data['work']['header'] = 'Voulez-vous travailler pour nous?';
            $data['work']['text'] = '#Cliquez ici# pour vérifier les emplois disponibles.';
            $data['social']['header'] = 'Nous sommes aussi sociaux';
            $data['socials']['fb']['text'] = 'Sur FaceBook';
            $data['socials']['x']['text'] = 'Sur X';
            $data['socials']['ig']['text'] = 'Sur Instagram';
            $data['socials']['pinterest']['text'] = 'Sur Pinterest';
            $data['socials']['whatsapp']['text'] = 'Sur Whatsapp';
            $data['socials']['telegram']['text'] = 'Sur Telegram';
            $data['socials']['tchannel']['text'] = 'Canal de telegram';
            $data['socials']['fbgroup']['text'] = 'Groupe FaceBook';
            $data['socials']['fbgroup']['name'] = 'Sure Games Daily';
        }
        $data['sidelist'] = $this->sidelist();
        $data['email']['text'] = tag_format($data['email']['text'], [['href'=>support_links('mailus'), 'style'=>'color:green']]);
        $data['chat']['text'] = tag_format($data['chat']['text'], [['href'=>'javascript:void(Tawk_API.toggle())', 'style'=>'color:green']]);
        $data['work']['text'] = tag_format($data['work']['text'], [['href'=>support_links('jobs'), 'style'=>'color:green']]);
        $data['call']['phone'] = $data['socials']['whatsapp']['name'] = $data['socials']['telegram']['name'] = PHONE;
        $data['socials']['fb']['link'] = FBLINK;
        $data['socials']['fb']['name'] = '@'.FB;
        $data['socials']['x']['link'] = XLINK;
        $data['socials']['x']['name'] = '@'.X;
        $data['socials']['ig']['link'] = IGLINK;
        $data['socials']['ig']['name'] = '@'.IG;
        $data['socials']['pinterest']['link'] = PINTERESTLINK;
        $data['socials']['pinterest']['name'] = '@'.PINTEREST;
        $data['socials']['tchannel']['link'] = TELEGRAM_CHANNEL_LINK;
        $data['socials']['tchannel']['name'] = '@'.TELEGRAM_CHANNEL;
        $data['socials']['fbgroup']['link'] = FBGROUPLINK;
        $data['socials']['fb']['icon'] = $data['socials']['fbgroup']['icon'] = 'fab fa-facebook-square';
        $data['socials']['fb']['color'] = $data['socials']['fbgroup']['color'] = 'blue';
        $data['socials']['tchannel']['icon'] = $data['socials']['telegram']['icon'] = 'fab fa-telegram';
        $data['socials']['tchannel']['color'] = $data['socials']['telegram']['color'] = '#38A1F3';
        $data['socials']['telegram']['link'] = TELEGRAM_LINK;
        $data['socials']['whatsapp']['icon'] = 'fab fa-whatsapp';
        $data['socials']['whatsapp']['color'] = 'green';
        $data['socials']['whatsapp']['link'] = WHATSAPP_LINK;
        $data['socials']['pinterest']['icon'] = 'fab fa-pinterest-square';
        $data['socials']['pinterest']['color'] = 'red';
        $data['socials']['x']['icon'] = 'fab fa-x-twitter';
        $data['socials']['ig']['icon'] = 'fab fa-instagram';
        $data['socials'] = array_chunk($data['socials'], 4, true);
        $this->view("support/index",$data);
    }

    function aboutus() {
        $this->page = 'aboutus';
        $this->urls();
        $this->style = ".tips-prof a {color:green;} .tips-prof p {text-align:justify;}";
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers about us';
            $this->description = 'Good prediction site that provides sure real predictions on a wide range of sporting activities such as soccer, tennis, volleyball etc on a daily basis.';
            $data['page_title'] = "About Us";
            $data['h1'] = "ABOUT US";
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->description = 'Bon site de prédiction qui fournit des prévisions réelles et fiables sur un large éventail d\'activités sportives telles que le football, le tennis, le volley-ball, etc. quotidiennement.';
            $data['page_title'] = "À propos de nous";
            $data['h1'] = "Véritable site de Pronostics";
        }
        $this->writeupclass = 'tips-prof';
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
    
    function faqs() {
        $this->page = 'faqs';
        $this->urls();
        $this->style = ".tips-prof a {color:green;} .tips-prof p {text-align:justify;}";
        // $this->urls = free_games_link($this->page, true);
        $this->writeupclass = 'tips-prof';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers faqs';
            $this->description = 'Betagamers Frequently Asked Questions: See answers to questions frequently asked by users. Answers to yours might be here';
            $data['page_title'] = "FAQs";
            $data['h1'] = 'BetaGamers: FAQs';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->description = 'Foire aux questions sur Betagamers: Consultez les réponses aux questions fréquemment posées par les utilisateurs. Les réponses aux vôtres pourraient être ici';
            $data['page_title'] = "FAQs";
            $data['h1'] = 'BetaGamers: FAQs';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
    
    function howitworks() {
        $this->page = 'howitworks';
        $this->urls();
        $this->style = ".justify a {color:green; text-decoration: underline} .justify p {text-align:justify;}";
        // $this->urls = free_games_link($this->page, true);
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers howto';
            $this->description = 'Betagamers Support Center: Quick guide to how things work at Betagamers.';
            $data['page_title'] = "How it Works";
            $data['h1'] = 'How it Works';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web de betagamers, www.betagamers.net, Comment fonctionne betagamers';
            $this->description = 'Betagamers Centre de soutien: Guide rapide du fonctionnement de betagamers.';
            $data['page_title'] = $data['h1'] = 'Comment ça fonctionne';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
    
    function jobs() {
        $this->page = 'jobs';
        $this->urls();
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers jobs';
            $this->description = 'Betagamers Job Offer. Check out which opportunities best suits you';
            $data['page_title'] = "Job opportunities";
            $data['h1'] = 'BetaGamers: Job opportunities';
            include ROOT.'/app/betagamers/incs/countrylist/'.LANG.'.php';
            $data['h2'] = 'Available Opportunities in '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Image created by MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        'title'=>'Tennis / BasketBall Prediction Expert',
                        'description'=>''
                    ],
                    [
                        'title'=>'Mobile Money Agents',
                        'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        'title'=>'Tennis / BasketBall Prediction Expert',
                        'description'=>''
                    ]
                ]
            ];
            $nojobs = [
                "There are currently no job openings for your country at the moment.",
                "However, if you have anything you feel you can do for us, send a message to: ".HR.". We will notify you whenever that position is available."
            ];
            $additional = "For any of the roles you're interested in, kindly send a message to us on Whatsapp / Telegram ".PHONE;
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->description = 'Offre d\'emploi Betagamers. Découvrez les opportunités qui vous conviennent le mieux';
            $data['page_title'] = "Opportunités d'emploi";
            $data['h1'] = "BetaGamers: Opportunités d'emploi";
            include ROOT.'/app/betagamers/incs/countrylist/'.LANG.'.php';
            $data['h2'] = 'Opportunités disponibles dans '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Image créée par MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        'title'=>'Expert en pronostics Tennis / BasketBall',
                        'description'=>''
                    ],
                    [
                        'title'=>'Agents du Mobile Money',
                        'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        'title'=>'Expert en pronostics Tennis / BasketBall',
                        'description'=>''
                    ]
                ]
            ];
            $nojobs = [
                "Il n'y a actuellement aucune offre d'emploi pour le moment.",
                "Cependant, si vous pensez pouvoir faire quelque chose pour nous, envoyez un message à: ".HR.". Nous vous informerons dès que ce poste sera disponible."
            ];
            $additional = "Pour l'un des rôles qui vous intéresse, veuillez nous envoyer un message sur Whatsapp / Telegram via ".PHONE;
        }
        if(array_key_exists(USER_COUNTRY, $opportunities)) {
            $data['jobs'] = $opportunities[USER_COUNTRY];
            $data['additional'] = $additional;
        } else {
            $data['jobs'] = $nojobs;
        }
        //show($data['jobs']);
        $data['sidelist'] = $this->sidelist();
        $this->view("support/jobs",$data);
    }
    
    function mailus() {
        $this->page = $this->activepage = 'mailus';
        $this->urls();
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net';
            $this->description = "Send us a mail, we'll definitely reach back withn 24 hours.";
            $data['page_title'] = "Contact Us";
            $data['h1'] = "E-mail Us";
            $select = 'Select Subject';
            $subjects = [
                'Registration / Activation'=>['Registration Error', 'No Email Received'],
                'Subscription / Activation'=>['Prices and Pay Methods', 'Payment Complete', 'Payment Error'],
                'Account Settings'=>['Edit Profile', 'Forgot Password'],
                'Admin / Editorial'=>['Suggest Edits', 'Report a Missing Page', 'Linking and Guest Posts', 'Advertising', 'Jobs'],
                ''=>['Others']
            ];
            $successtxt= " Message Sent. We'll be intouch within 24 hours";
            $placeholders = ['Name', 'Your Email', 'Message'];
            $fieldnames = ['Name', 'E-mail', 'Subject', 'Message', ''];
            $sendmail = 'Send Mail';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web betagamers, fr.betagamers.net, conseils sportifs, site de pronostics sportifs précis, site de pronostics sportifs précis';
            $this->description = "Envoyez-nous un e-mail, nous vous répondrons certainement dans les 24 heures.";
            $data['page_title'] = "Envoyez-nous un email";
            $data['h1'] = "Envoyez-nous un email";
            $select = 'Sélectionnez le sujet';
            $subjects = [
                "Enregistrement / Activation"=>["Erreur d'enregistrement", "Aucun e-mail reçu"],
                'Abonnement / Activation'=>['Prix et modes de paiement', 'Paiement terminé', 'Erreur de paiement'],
                'Paramètres du compte'=>['Editer le profil', 'Mot de passe oublié'],
                "Admin / Éditorial"=>["Suggérer des modifications", "Signaler une page manquante", "Liens / articles d'invités", "La publicité", "L'emploi"],
                ''=>["Autres"]
            ];
            $successtxt= " Message Sent. We'll be intouch within 24 hours";
            $placeholders = ['Nom', 'Votre email', 'Message'];
            $fieldnames = ['Nom', 'E-mail', 'Sujet', 'Message', ''];
            $sendmail = 'Envoyer';
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['submit']) & !empty($_POST))) {
            $genclass = new General;
            $name = $genclass->validate_name($_POST['name']);
            $email = $genclass->validate_email($_POST['email'], unique:false);
            $unpackedarr = array_merge(...array_values($subjects));
            // echo 'ahaa';
            $subject = $genclass->validate_in_array($_POST['subject'], $unpackedarr, fieldname:'subject');
            $err = $genclass->err ? $genclass->err : [];
            // array_push($unpackedarr, $others);
            // if(!in_array($_POST['subject'], $unpackedarr)) {
            //     $err['subject'] = $genclass->resp_invalid_selection($fieldname['subject'], LANG);
            // }
            $message = purify($_POST["message"]);
            if(!$message) {
                $err['message'] = $genclass->resp_empty('message', LANG);
            } else {
                $mal = ['viagra', 'drug', 'cialis', 'pharmacy', 'pharmacies','loan','href','tadalafil'];
                foreach ($mal as $bad) {
                    if(stripos($message, $bad) !== false) {
                        $err['gen'] = $genclass->sth_went_wrong(LANG).'<br><br>';
                    }
                }
            }
            if(!implode('',$err)) {
                $to = EMAIL;
                $headers = 'From: '.$email."\r\n".
                'Reply-To: '.$email."\r\n" .
                'X-Mailer: PHP/' . phpversion();
                @mail($to, $subject, $message, $headers);
                $success= $successtxt;
            }
        }
        $formfields = [
            ['tag'=>'input', 'type'=>'text', 'placeholder'=>$placeholders[0], 'name'=>"name", 'value'=>$name ?? $_SESSION['users']['fullname'] ?? '', 'error'=>$err['name'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'email', 'placeholder'=>$placeholders[1], 'name'=>"email", 'value'=>$email ?? $_SESSION['users']['email'] ?? '', 'error'=>$err['email'] ?? '', 'required'],
            ['tag'=>'select', 'name'=>"subject", 'options_single'=>['default_opt_'.($subject ?? '')=>$subject ?? null, ...$subjects], 'id'=>'subject', 'error'=>$err['subject'] ?? '', 'required'],
            ['tag'=>'textarea', 'rows'=>'10', 'cols'=>'30', 'style'=>'width: 100%; resize: none;', 'placeholder'=>$placeholders[2], 'name'=>"message", 'value'=>$message ?? '', 'error'=>$err['message'] ?? '', 'required'],
            ['tag'=>'input', 'type'=>'submit', 'name'=>"submit", 'value'=>$sendmail, 'error'=>''],
        ];

        $errs = array_column($formfields, 'error', 'name');
        $output = form_format($formfields);
        $fieldnames = array_combine(array_column($formfields, 'name'), $fieldnames);
        
        $data['formfields'] = $output;
        $data['fieldnames'] = $fieldnames;
        $data['formerrors'] = $errs ?? $formdata[1] ?? null;
        $data['formerrors']['gen'] = $err['gen'] ?? $generr ?? '';
        $data['formsuccess'] = $success ?? '';
        $this->view("support/mailus",$data);
    }
    
    function prices() {
        $this->page = 'prices';
        $this->urls();
        $this->viewonly = true;
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers pricing page';
            $this->description = 'Take a look at the prices of various plans that are available at BetaGamers.';
            $data['page_title'] = "Pricing Plans";
            $data['h1'] = 'BetaGamers Pricing';
            $data['h2'] = 'Which Plan Best Represents You?';
            $data['p'] = "Select from the following and we'll provide the solutions that are ideal to your specific needs:";
            // $sub_text = 'SUBSCRIBE NOW';
            // $sub_text_1 = 'SUBSCRIBE';
            $prompt = ['SUBSCRIBE NOW', 'REGISTER', 'SUBSCRIBE'];
        } elseif(LANG=='fr') {
            $data['page_title'] = "Plans de tarification Betagamers";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web du betagamers, betagamers.net, prix des conseils sportifs, prix des pronostics précis des sportifs, meilleure fourchette de prix des pronostics de football';
            $this->description = 'Jetez un œil aux prix des différents plans disponibles chez BetaGamers.';
            $data['h1'] = 'Plans de tarification Betagamers';
            $data['h2'] = 'Quel plan vous représente le mieux?';
            $data['p'] = "Choisissez parmi les éléments suivants et nous vous fournirons les solutions idéales pour vos besoins spécifiques:";
            // $sub_text = 'SUBSCRIBE NOW';
            // $sub_text_1 = 'SUBSCRIBE';
            $prompt = ['ABONNEZ-VOUS MAINTENANT', 'S\'INSCRIRE', 'SOUSCRIRE'];
        }
        $data['sidelist'] = $this->sidelist();
        $data['tabs'] = sports();
        $pdetails = currencies(USER_COUNTRY);
        $data['plan']['cur_sign'] = $pdetails['cur_sign'];
        $data['plan']['cur_lower'] = $pdetails['currency'];
        $data['plan']['paylink'] = pay_links($pdetails['extralink'] ?? $pdetails['link']);
        $data['prompt'] = $prompt;
        $data['table']['headers'] = payment_table_headers(2);
        $this->view("payments/pricingpage",$data);
    }
    
    function privacy() {
        $this->page = 'privacy';
        $this->urls();
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers privacy policy page';
            $this->description = 'Go through the privacy policy statement of the services provided by BetaGamers';
            $data['page_title'] = "Privacy Policy";
            $data['h1'] = 'BETAGAMERS PRIVACY POLICY';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->description = 'Passez par la déclaration de politique de confidentialité des services fournis par BetaGamers';
            $data['page_title'] = "Politique de confidentialité de Betagamers";
            $data['h1'] = 'POLITIQUE DE PROTECTION DE LA VIE PRIVÉE DE BETAGAMERS';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
    
    function terms() {
        $this->page = 'terms';
        $this->urls();
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers terms and conditions of use';
            $this->description = 'Go through the terms and conditions of usage of services by BetaGamers';
            $data['page_title'] = "Terms";
            $data['h1'] = 'BETAGAMERS TERMS';
        } elseif(LANG=='fr') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, conseils de paris sportifs, site de pronostics sportifs précis, site de pronostic football fiable, site pronostic foot professionnel, pronostic football du jour, pronostics football, site de pronostic foot gagnant, prévisions de football gratuites, meilleur site de football';
            $this->description = 'Consulter les conditions générales d\'utilisation des services par BetaGamers';
            $data['page_title'] = "Conditions de Betagamers";
            $data['h1'] = 'CONDITIONS DE BETAGAMERS';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
}