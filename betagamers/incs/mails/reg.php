<?php
if(LANG=='fr') {
$message['subject'] = 'Vérification du compte BetaGamers';
$message['body'] = 
"<p>Salut $fullname,<br>
Merci de vous être inscrit!</p>

<p>Veuillez cliquer sur le lien ci-dessous pour activer votre compte: <br>
https://fr.betagamers.net/compte/verify?email=$email&hash=$hash</p>

<p>Meilleures salutations.</p>";
$message['alt'] = "Salut $fullname, Merci de vous être inscrit! Veuillez cliquer sur le lien ci-dessous pour activer votre compte: https://fr.betagamers.net/compte/verify?email=$email&hash=$hash 
Meilleures salutations.";
$from['email'] = ENV['FR_EMAIL_NOREPLY'];
$from['password'] = ENV['FR_EMAIL_NOREPLY_PASS'];

} elseif(LANG=='es') {
$message['subject'] = 'BetaGamers: Verificación de la cuenta';
$message['body'] = 
"<p>Hola $fullname,<br>
Gracias por registrarse!</p>

<p>Por favor, haga clic en el enlace de abajo para activar su cuenta: <br>
https://es.betagamers.net/cuenta/verificar?email=$email&hash=$hash</p>

<p>Saludos cordiales.</p>";
$message['alt'] = "Hola $fullname,Gracias por registrarse! Por favor, haga clic en el enlace de abajo para activar su cuenta: https://es.betagamers.net/cuenta/verify?email=$email&hash=$hash 
Saludos cordiales.";
$from['email'] = ENV['ES_EMAIL_NOREPLY'];
$from['password'] = ENV['ES_EMAIL_NOREPLY_PASS'];

} elseif(LANG=='pt') {
$message['subject'] = 'Verificação de conta BetaGamers';
$message['body'] = 
"<p>Olá $fullname,<br>
Obrigado por inscrever-se!</p>

<p>Clique no link abaixo para ativar sua conta: <br>
https://pt.betagamers.net/conta/verify?email=$email&hash=$hash</p>

<p>Cumprimentos.</p>";
$message['alt'] = "Olá $fullname, Obrigado por inscrever-se! Clique no link abaixo para ativar sua conta: https://pt.betagamers.net/conta/verify?email=$email&hash=$hash 
Cumprimentos.";
$from['email'] = ENV['PT_EMAIL_NOREPLY'];
$from['password'] = ENV['PT_EMAIL_NOREPLY_PASS'];

} elseif(LANG=='de') {
$message['subject'] = 'Überprüfung des BetaGamers-Kontos';
$message['body'] = 
"<p>Hallo $fullname,<br>
Danke für die Registrierung!</p>

<p>Bitte klicken Sie auf den unten stehenden Link, um Ihr Konto zu aktivieren: <br>
https://de.betagamers.net/konto/verifizieren?email=$email&hash=$hash</p>

<p>Mit freundlichen Grüßen.</p>";
$message['alt'] = "Hallo $fullname, Danke für die Registrierung! Bitte klicken Sie auf den unten stehenden Link, um Ihr Konto zu aktivieren: https://de.betagamers.net/konto/verifizieren?email=$email&hash=$hash 
Mit freundlichen Grüßen.";
$from['email'] = ENV['DE_EMAIL_NOREPLY'];
$from['password'] = ENV['DE_EMAIL_NOREPLY_PASS'];

} else {
$message['subject'] = 'BetaGamers Account Verification';
$message['body'] = 
"<p>Hello $fullname,<br>
Thank you for signing up!</p>

<p>Please click the link below to activate your account:<br>
https://betagamers.net/account/verify?email=$email&hash=$hash</p>

<p>Best Regards.</p>";
$message['alt'] = "Hello $fullname, Thank you for signing up! Please click the link below to activate your account: https://betagamers.net/account/verify?email=$email&hash=$hash 
Best Regards.";
$from['email'] = ENV['EMAIL_NOREPLY'];
$from['password'] = ENV['EMAIL_NOREPLY_PASS'];
}