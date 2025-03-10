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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, soporte de betagamers';
            $this->description = 'Contáctenos hoy para cualquier cosa relacionada con cualquiera de nuestros productos o servicios, nos encantaría ayudar.';
            $data['page_title'] = "Centro de Apoyo";
            $data['h1'] = 'Centro de contacto de BetaGamers';
            $data['call']['header'] = 'Nosotros somos existentes';
            $data['call']['prompt'] = 'Llama o envía un mensaje de texto';
            $data['email']['prompt'] = 'Envíenos un correo electrónico';
            $data['email']['text'] = "#Haga clic aquí# para enviarnos un correo y le responderemos en 24 horas. También puede enviarnos un correo electrónico a través de ".EMAIL;
            $data['chat']['prompt'] = 'Charla con nosotros';
            $data['chat']['text'] = '#Haz clic aquí# para charlar con nosotros.';
            $data['work']['header'] = '¿Quieres trabajar para nosotros?';
            $data['work']['text'] = '#Haga clic aquí# para ver los trabajos disponibles.';
            $data['social']['header'] = 'Nosotros tambien somos sociales';
            $data['socials']['fb']['text'] = 'On FaceBook';
            $data['socials']['x']['text'] = 'En X';
            $data['socials']['ig']['text'] = 'En Instagram';
            $data['socials']['pinterest']['text'] = 'En Pinterest';
            $data['socials']['whatsapp']['text'] = 'En Whatsapp';
            $data['socials']['telegram']['text'] = 'En Telegram';
            $data['socials']['tchannel']['text'] = 'Telegram Channel';
            $data['socials']['fbgroup']['text'] = 'Grupo de Facebook';
            $data['socials']['fbgroup']['name'] = 'Sure Games Daily';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, suporte para betagamers';
            $this->description = 'Centro de suporte para betagamers: contacte-nos hoje, adoraríamos ajudar.';
            $data['page_title'] = "Centro de Suporte";
            $data['h1'] = 'Central de contato do Betagamers';
            $data['call']['header'] = 'Nós somos existentes';
            $data['call']['prompt'] = 'Ligue ou SMS';
            $data['email']['prompt'] = 'Envia-nos um email';
            $data['email']['text'] = "#Clique aqui# para nos enviar um e-mail e retornaremos em 24 horas. Você também pode nos enviar um e-mail através de ".EMAIL;
            $data['chat']['prompt'] = 'Converse conosco';
            $data['chat']['text'] = '#Clique aqui# para conversar conosco.';
            $data['work']['header'] = 'Quer trabalhar para nós?';
            $data['work']['text'] = '#Clique aqui# para verificar as vagas disponíveis.';
            $data['social']['header'] = 'Também somos sociais';
            $data['socials']['fb']['text'] = 'No FaceBook';
            $data['socials']['x']['text'] = 'No X';
            $data['socials']['ig']['text'] = 'No Instagram';
            $data['socials']['pinterest']['text'] = 'No Pinterest';
            $data['socials']['whatsapp']['text'] = 'No Whatsapp';
            $data['socials']['telegram']['text'] = 'No Telegram';
            $data['socials']['tchannel']['text'] = 'Canal de telegram';
            $data['socials']['fbgroup']['text'] = 'Grupo Facebook';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, betagamers-hilfecenter';
            $this->description = 'Kontaktieren Sie uns noch heute, wenn Sie Fragen zu unseren Produkten oder Dienstleistungen haben. Wir sind hier um zu helfen.';
            $data['page_title'] = "Hilfecenter";
            $data['h1'] = 'BetaGamers-Hilfecenter';
            $data['call']['header'] = 'Wir sind hier';
            $data['call']['prompt'] = 'Rufen Sie uns an oder SMS';
            $data['email']['prompt'] = 'Schreiben Sie uns eine E-Mail';
            $data['email']['text'] = "#Klicken Sie hier# um uns eine E-Mail zu senden. Wir werden uns innerhalb von 24 Stunden bei Ihnen melden. Sie können uns auch eine E-Mail über ".EMAIL.' senden';
            $data['chat']['prompt'] = 'Chatte mit uns';
            $data['chat']['text'] = '#Klicken Sie hier# um mit uns zu chatten.';
            $data['work']['header'] = 'Sie möchten bei uns arbeiten?';
            $data['work']['text'] = '#Klicken Sie hier# um nach verfügbaren Jobs zu suchen.';
            $data['social']['header'] = 'Wir sind auch sozial';
            $data['socials']['fb']['text'] = 'Auf FaceBook';
            $data['socials']['x']['text'] = 'Auf X';
            $data['socials']['ig']['text'] = 'Auf Instagram';
            $data['socials']['pinterest']['text'] = 'Auf Pinterest';
            $data['socials']['whatsapp']['text'] = 'Auf Whatsapp';
            $data['socials']['telegram']['text'] = 'Auf Telegram';
            $data['socials']['tchannel']['text'] = 'Telegrammkanal';
            $data['socials']['fbgroup']['text'] = 'Gruppe Facebook';
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
        $data['socials']['fbgroup']['name'] = FBGROUPNAME;
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, sobre Betagamers';
            $this->description = 'Haz clic aquí para saber más sobre Betagamers.';
            $data['page_title'] = "Sobre nosotros";
            $data['h1'] = "SOBRE NOSOTROS";
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = 'Site que fornece boas previsões sobre uma ampla gama de atividades esportivas como futebol, tênis, vôlei etc diariamente.';
            $data['page_title'] = "SOBRE NÓS";
            $data['h1'] = "SOBRE NÓS";
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net';
            $this->description = 'Über betagamers';
            $data['page_title'] = "Über uns";
            $data['h1'] = "ÜBER UNS";
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, betagamers faqs';
            $this->description = 'Vea respuestas a preguntas frecuentes de los usuarios. Las respuestas a las tuyas podrían estar aquí';
            $data['page_title'] = "Preguntas frecuentes";
            $data['h1'] = 'BetaGamers: Preguntas frecuentes';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, betagamers faqs';
            $this->description = 'Veja as respostas às perguntas frequentes dos usuários betagamers';
            $data['page_title'] = "FAQs";
            $data['h1'] = 'BetaGamers: FAQs';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, betagamers-häufig gestellte Fragen';
            $this->description = 'Sehen Sie sich Antworten auf Fragen an, die häufig von Benutzern gestellt werden. Antworten auf Ihre könnten hier sein';
            $data['page_title'] = "Häufig gestellte Fragen";
            $data['h1'] = 'BetaGamers: Häufig gestellte Fragen';
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, cómo funciona betagamers';
            $this->description = 'Guía rápida de cómo funcionan las cosas en Betagamers.';
            $data['page_title'] = "Cómo funciona";
            $data['h1'] = 'Cómo funciona';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, betagamers como fazer';
            $this->description = 'Centro de suporte do Betagamers: Guia rápido de como as coisas funcionam na Betagamers.';
            $data['page_title'] = "Como Funciona";
            $data['h1'] = 'Como Funciona';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Betagamers-Anleitung';
            $this->description = 'Betagamers-Hilfecenter: Kurzanleitung, wie die Dinge bei Betagamers funktionieren.';
            $data['page_title'] = "Wie es funktioniert";
            $data['h1'] = 'Wie es funktioniert';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
    
    function jobs() {
        $this->page = 'jobs';
        $this->urls();
        include ROOT.'/app/betagamers/incs/countrylist/'.LANG.'.php';
        if(LANG=='en') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, www.betagamers.net, betagamers jobs';
            $this->description = 'Betagamers Job Offer. Check out which opportunities best suits you';
            $data['page_title'] = "Job opportunities";
            $data['h1'] = 'BetaGamers: Job opportunities';
            $data['h2'] = 'Available Opportunities in '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Image created by MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
                    ],
                    [
                        // 'title'=>'Mobile Money Agents',
                        // 'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
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
            $data['h2'] = 'Opportunités disponibles dans '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Image créée par MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        // 'title'=>'Expert en pronostics Tennis / BasketBall',
                        // 'description'=>''
                    ],
                    [
                        // 'title'=>'Agents du Mobile Money',
                        // 'description'=>"We're looking to..."
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, oportunidades de trabajo de betagamers';
            $this->description = 'Consulta la oferta de trabajo de Betagamers y qué oportunidades se adaptan mejor a ti';
            $data['page_title'] = "Oportunidades de trabajo";
            $data['h1'] = 'BetaGamers: Oportunidades de trabajo';
            $data['h2'] = 'Oportunidades disponibles en '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Imagen creada por MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        // 'title'=>'Experto en predicciones de tenis y baloncesto',
                        // 'description'=>''
                    ],
                    [
                        // 'title'=>'Agentes de Mobile Money',
                        // 'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        // 'title'=>'Experto en predicciones de tenis y baloncesto',
                        // 'description'=>''
                    ]
                ]
            ];
            $nojobs = [
                "Actualmente no hay ofertas de trabajo en este momento.",
                "Sin embargo, si tiene algo que cree que puede hacer por nosotros, envíe un mensaje a: ".HR.". Se avisaremos cuando ese puesto esté disponible."
            ];
            $additional = "Para cualquiera de los roles que le interesen, envíenos un mensaje por Whatsapp / Telegram al ".PHONE;
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, oportunidades de emprego de betagamers';
            $this->description = 'Oferta de emprego por betagamers. Confira quais oportunidades mais combinam com você';
            $data['page_title'] = "Oportunidades de emprego";
            $data['h1'] = 'BetaGamers: Oportunidades de emprego';
            $data['h2'] = 'Oportunidades Disponíveis em '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Imagem criada por MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
                    ],
                    [
                        // 'title'=>'Mobile Money Agents',
                        // 'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
                    ]
                ]
            ];
            $nojobs = [
                "No momento não há vagas de emprego no momento.",
                "No entanto, se você sentir que pode fazer algo por nós, envie uma mensagem para: ".HR.". Iremos notificá-lo sempre que essa posição estiver disponível.."
            ];
            $additional = "Para qualquer uma das funções em que você esteja interessado, envie uma mensagem para nós no Whatsapp / Telegram ".PHONE;
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Tippgeber, Betagamers-Jobs';
            $this->description = 'Stellenangebote von BetaGamers. Prüfen Sie, welche Möglichkeiten am besten zu Ihnen passen';
            $data['page_title'] = "Beschäftigungsmöglichkeiten";
            $data['h1'] = 'BetaGamers: Beschäftigungsmöglichkeitens';
            $data['h2'] = 'Verfügbare Möglichkeiten in '.$country_list[USER_COUNTRY]['name'];
            $data['imgcaption'] = 'Bild erstellt von MohamedHassan - www.freerangestock.com';
            $opportunities = [
                'NG'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
                    ],
                    [
                        // 'title'=>'Mobile Money Agents',
                        // 'description'=>"We're looking to..."
                    ]
                ],
                'ABC'=>[
                    [
                        // 'title'=>'Tennis / BasketBall Prediction Expert',
                        // 'description'=>''
                    ]
                ]
            ];
            $nojobs = [
                "Derzeit sind keine Stellen zu besetzen.",
                "Wenn Sie jedoch etwas für uns tun können, senden Sie eine Nachricht an: ".HR.". Wir werden Sie benachrichtigen, sobald diese Stelle verfügbar wird."
            ];
            $additional = "Für alle Rollen, an denen Sie interessiert sind, senden Sie uns bitte eine Nachricht über WhatsApp / Telegram".PHONE;
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
                "Enregistrement / Activation"=>["Erreur d\'enregistrement", "Aucun e-mail reçu"],
                'Abonnement / Activation'=>['Prix et modes de paiement', 'Paiement terminé', 'Erreur de paiement'],
                'Paramètres du compte'=>['Editer le profil', 'Mot de passe oublié'],
                "Admin / Éditorial"=>["Suggérer des modifications", "Signaler une page manquante", "Liens / articles d'invités", "La publicité", "L'emploi"],
                ''=>["Autres"]
            ];
            $successtxt= " Message Sent. We'll be intouch within 24 hours";
            $placeholders = ['Nom', 'Votre email', 'Message'];
            $fieldnames = ['Nom', 'E-mail', 'Sujet', 'Message', ''];
            $sendmail = 'Envoyer';
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, formulario de contacto de Betagamers';
            $this->description = "Envianos un email, le responderemos dentro de las 24 horas.";
            $data['page_title'] = "Contacta con nosotros";
            $data['h1'] = "Envíenos un correo electrónico";
            $select = 'Seleccione Asunto';
            $subjects = [
                'Inscripción / Activación'=>['Error de registro', 'Ningún correo electrónico recibido'],
                'Suscripción / Activación'=>['Precios y Formas de Pago', 'Pago completado', 'Error en el pago'],
                'Configuraciones de la cuenta'=>['Editar perfil', 'Has olvidado tu contraseña'],
                'Admón / Editorial'=>['Sugerir ediciones', 'Informar de una página que falta', 'Vincular y Publicación de invitados', 'Publicidad', 'Empleos'],
                ''=>['Otros']
            ];
            $successtxt= " Mensaje enviado. Le responderemos dentro de las 24 horas";
            $placeholders = ['Nombre', 'Tu correo electrónico', 'Mensaje'];
            $fieldnames = ['Nombre', 'Correo-e', 'El Asunto', 'Mensaje', ''];
            $sendmail = 'Envía correo';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net';
            $this->description = "Envie-nos um e-mail, nós definitivamente entraremos em contato dentro de 24 horas.";
            $data['page_title'] = "Contate-Nos";
            $data['h1'] = "Envia-nos um email";
            $select = 'Selecione o assunto';
            $subjects = [
                'Registro e Ativação'=>['Erro de Registo', 'Nenhum e-mail recebido'],
                'Assinatura / Ativação'=>['Preços e métodos de pagamento', 'Pagamento completo', 'Erro de pagamento'],
                'Configurações de Conta'=>['Editar Perfil', 'Esqueceu sua senha'],
                'Administrador / Editorial'=>['Sugerir edições', 'Denunciar uma página ausente', 'Links e Postagens Convidadas', 'Anúncio', 'Empregos'],
                ''=>['Outros']
            ];
            $successtxt= " Mensagem enviada. Entraremos em contato em até 24 horas.";
            $placeholders = ['Nome', 'Seu email', 'Mensagem'];
            $fieldnames = ['Nome', 'E-mail', 'O assunto', 'Mensagem', ''];
            $sendmail = 'Enviar correio';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers website, de.betagamers.net';
            $this->description = "Senden Sie uns eine E-Mail, wir werden uns auf jeden Fall innerhalb von 24 Stunden bei Ihnen melden.";
            $data['page_title'] = "Schreiben Sie uns eine E-Mail";
            $data['h1'] = "Schreiben Sie uns eine E-Mail";
            $select = 'Thema auswählen';
            $subjects = [
                'Registrierung und Aktivierung'=>['Registrierungsfehler', 'Keine E-Mail erhalten'],
                'Abonnement / Aktivierung'=>['Preise und Zahlungsmethoden', 'Zahlung abgeschlossen', 'Zahlungsfehler'],
                'Account Einstellungen'=>['Profil bearbeiten', 'Passwort vergessen'],
                'Admin / Editorial'=>['Änderungen vorschlagen', 'Melden Sie eine fehlende Seite', 'Verlinkung und Gastbeiträge', 'Werbung', 'Arbeitsplätze'],
                ''=>['Andere']
            ];
            $successtxt= " Nachricht wurde gesendet. Wir melden uns innerhalb von 24 Stunden.";
            $placeholders = ['Name', 'Ihre E-Mail', 'Nachricht'];
            $fieldnames = ['Name', 'E-mail', 'Thema', 'Nachricht', ''];
            $sendmail = 'Senden Sie';
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
            $prompt = ['SUBSCRIBE NOW', 'REGISTER', 'SUBSCRIBE'];
        } elseif(LANG=='fr') {
            $data['page_title'] = "Plans de tarification Betagamers";
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site web du betagamers, betagamers.net, prix des conseils sportifs, prix des pronostics précis des sportifs, meilleure fourchette de prix des pronostics de football';
            $this->description = 'Jetez un œil aux prix des différents plans disponibles chez BetaGamers.';
            $data['h1'] = 'Plans de tarification Betagamers';
            $data['h2'] = 'Quel plan vous représente le mieux?';
            $data['p'] = "Choisissez parmi les éléments suivants et nous vous fournirons les solutions idéales pour vos besoins spécifiques:";
            $prompt = ['ABONNEZ-VOUS MAINTENANT', 'S\'INSCRIRE', 'SOUSCRIRE'];
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, planes de BetaGamers, rango de precio de mejor predicción de fútbol';
            $this->description = 'Echa un vistazo a los precios de varios planes que están disponibles en BetaGamers.';
            $data['page_title'] = $data['h1'] = 'Planes de BetaGamers';
            $data['h2'] = '¿Qué plan te representa mejor?';
            $data['p'] = "Selecciona una de las siguientes opciones y te brindaremos las soluciones ideales para tus necesidades específicas:";
            $prompt = ['SUSCRÍBATE AHORA', 'REGISTRARTE', 'SUSCRÍBATE'];
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, preços de dicas de esportes, preços de previsão de esportes precisos, melhor faixa de preço de previsão de futebol';
            $this->description = 'Dê uma olhada nos preços de vários planos que estão disponíveis no BetaGamers.';
            $data['page_title'] = $data['h1'] = 'Planos de preços';
            $data['h2'] = 'Qual plano melhor representa você?';
            $data['p'] = "Selecione entre os seguintes e forneceremos as soluções que são ideais para suas necessidades específicas:";
            $prompt = ['INSCREVA-SE AGORA', 'REGISTRAR', 'INSCREVA-SE'];
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, betagamers-preispläne, sports tips prices, Preise für genaue Sportvorhersagen-Website, beste Preisklasse für Fußballvorhersagen';
            $this->description = 'Werfen Sie einen Blick auf die Preise verschiedener Pläne, die bei BetaGamers verfügbar sind.';
            $data['page_title'] = $data['h1'] = 'Preispläne';
            $data['h2'] = 'Welcher Plan passt am besten zu Ihnen?';
            $data['p'] = "Wählen Sie aus den folgenden Optionen und wir bieten Ihnen die Lösungen, die Ihren spezifischen Anforderungen am besten entsprechen:";
            $prompt = ['ABONNIEREN JETZT', 'REGISTRIEREN', 'ABONNIEREN'];
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, política de privacidad de Betagamers';
            $this->description = 'Ir a través de la declaración de política de privacidad de los servicios proporcionados por BetaGamers';
            $data['page_title'] = "Política de Privacidad";
            $data['h1'] = 'Política de privacidad de BETAGAMERS';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, política de privacidade da betagamers';
            $this->description = 'Percorra a declaração de política de privacidade dos serviços prestados pela BetaGamers';
            $data['page_title'] = "Política de Privacidade";
            $data['h1'] = 'POLÍTICA DE PRIVACIDADE DA BETAGAMERS';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, Datenschutzrichtlinie für Betagamer';
            $this->description = 'Gehen Sie die Datenschutzerklärung der von BetaGamers bereitgestellten Dienste durch';
            $data['page_title'] = "Datenschutzrichtlinie";
            $data['h1'] = 'DATENSCHUTZRICHTLINIE FÜR BETAGAMERS';
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
        } elseif(LANG=='es') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, sitio web de betagamers, es.betagamers.net, términos y condiciones de betagamers';
            $this->description = 'Consulta los términos y condiciones de uso de los servicios de BetaGamers';
            $data['page_title'] = "Condiciones de Betagamers";
            $data['h1'] = 'BETAGAMERS TÉRMINOS Y CONDICIONES';
        } elseif(LANG=='pt') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, site de betagamers, pt.betagamers.net, termos e condições de uso dos serviços de BetaGamers';
            $this->description = 'Percorra os termos e condições de uso dos serviços por BetaGamers';
            $data['page_title'] = "Termos de Betagamers";
            $data['h1'] = 'TERMOS DE USO DO BETAGAMERS';
        } elseif(LANG=='de') {
            $this->keywords = 'Betagamers.net, betagamers, betagamer, betagamers-website, de.betagamers.net, betagamers-Nutzungsbedingungen';
            $this->description = 'Gehen Sie die Nutzungsbedingungen der Dienste von BetaGamers durch';
            $data['page_title'] = "Bedingungen";
            $data['h1'] = 'BETAGAMERS BEDINGUNGEN';
        }
        $data['sidelist'] = $this->sidelist();
        $this->view("support/writeups",$data);
    }
}