<?php
if(LANG=='fr') {
$from['email'] = ENV['FR_EMAIL_NOREPLY'];
$from['password'] = ENV['FR_EMAIL_NOREPLY_PASS'];
$message['subject'] = 'Réinitialisation du mot de passe Betagamers';
$message['body'] = "
<p>Salut $fullname,<br>
Merci de vous être inscrit!</p>

<p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe:<br>
https://fr.betagamers.net/compte/reinitialiser?email=$email&hash=$hash</p>

<p>Meilleures salutations.</p>";
$message['alt'] = "Salut $fullname, 
Merci de vous être inscrit! Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe: https://fr.betagamers.net/compte/reinitialiser?email=$email&hash=$hash 
Meilleures salutations.";
} elseif(LANG=='es') {
$from['email'] = ENV['ES_EMAIL_NOREPLY'];
$from['password'] = ENV['ES_EMAIL_NOREPLY_PASS'];
$message['subject'] = 'Betagamers: Restablecimiento de contraseña';
$message['body'] = "
<p>Hola $fullname,<br>
Gracias por registrarse!</p>

<p>Por favor, haga clic en el enlace de abajo para restablecer su contraseña:<br> https://es.betagamers.net/cuenta/reset?email=$email&hash=$hash</p>

<p>Saludos cordiales.</p>";
$message['alt'] = "Hola $fullname, Gracias por registrarse! Por favor, haga clic en el enlace de abajo para restablecer su contraseña: https://es.betagamers.net/cuenta/reset?email=$email&hash=$hash 
Saludos cordiales.";
} elseif(LANG=='pt') {
$from['email'] = ENV['PT_EMAIL_NOREPLY'];
$from['password'] = ENV['PT_EMAIL_NOREPLY_PASS'];
$message['subject'] = 'Redefinição de senha de betagamers';
$message['body'] = "
<p>Olá $fullname,<br>
Obrigado por inscrever-se!</p>

<p>Por favor, clique no link abaixo para redefinir sua senha: <br>
https://pt.betagamers.net/conta/redefinicao?email=$email&hash=$hash</p>

<p>Cumprimentos.</p>";
$message['alt'] = "Olá $fullname, Obrigado por inscrever-se! Por favor, clique no link abaixo para redefinir sua senha: https://pt.betagamers.net/conta/redefinicao?email=$email&hash=$hash 
Cumprimentos.";
} elseif(LANG=='de') {
$from['email'] = ENV['DE_EMAIL_NOREPLY'];
$from['password'] = ENV['DE_EMAIL_NOREPLY_PASS'];
$message['subject'] = 'Betagamers Passwort zurücksetzen';
$message['body'] = "
<p>Hallo $fullname,<br>
Danke für die Registrierung!</p>

<p>Bitte klicken Sie auf den unten stehenden Link, um Ihr Passwort zurückzusetzen: <br>
https://de.betagamers.net/konto/rucksetzen?email=$email&hash=$hash</p>

<p>Mit freundlichen Grüßen.</p>";
$message['alt'] = "Hallo $fullname, Danke für die Registrierung! Bitte klicken Sie auf den unten stehenden Link, um Ihr Passwort zurückzusetzen: https://de.betagamers.net/konto/rucksetzen?email=$email&hash=$hash 
Mit freundlichen Grüßen.";
} else {
$from['email'] = ENV['EMAIL_NOREPLY'];
$from['password'] = ENV['EMAIL_NOREPLY_PASS'];
$message['subject'] = 'Betagamers Password Reset';
$message['body'] = "
<p>Hello $fullname,<br>
Thank you for signing up!</p>

<p>Please click the link below to reset your password: <br>
https://betagamers.net/account/reset?email=$email&hash=$hash</p>

<p>Best Regards.</p>";
$message['alt'] = "Hello $fullname, Thank you for signing up! Please click the link below to activate your account: https://betagamers.net/account/verify?email=$email&hash=$hash 
Best Regards.";
}
?>